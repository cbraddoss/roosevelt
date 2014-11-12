<?php

use \Account;
use \Mailer;
use \Project;
use \AccountComment;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Events\MouseEvent;
use Ivory\GoogleMap\Overlays\InfoWindow;
use Ivory\GoogleMap\Helper\MapHelper;
use Ivory\GoogleMap\Controls\ControlPosition;
use Ivory\GoogleMap\Controls\MapTypeControl;
use Ivory\GoogleMap\Controls\MapTypeControlStyle;
use Ivory\GoogleMap\Controls\OverviewMapControl;
use Ivory\GoogleMap\Controls\ZoomControl;
use Ivory\GoogleMap\Controls\ZoomControlStyle;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Services\Geocoding\Geocoder;
use Ivory\GoogleMap\Services\Geocoding\GeocoderProvider;
use Geocoder\HttpAdapter\CurlHttpAdapter;

class AccountsController extends \BaseController {

	protected $mailer;
	/**
     * Instantiate a new AccountsController instance.
     */
	public function __construct(Mailer $mailer, Project $project, Account $account, Tag $tag, TagRelationship $tagRelationship)
	{
		$this->beforeFilter('auth');

		$this->beforeFilter('csrf', array('on' => 'post'));

        $this->mailer = $mailer;

        $this->project = $project;

        //$this->accountComment = $accountComment;

        $this->account = $account;

		$this->tag = $tag;

		$this->tagRelationship = $tagRelationship;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$accounts = Account::where('status','=','active')
					->paginate(30);
		$accountsCount = Account::where('status','=','active')->count();
		return View::make('accounts.index', compact('accounts','accountsCount'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function search($title) {
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
		$accounts = $this->account->getAccountsSearch($title);
		$accountsSearched = '';
		foreach($accounts as $account) {
			$accountsSearched .= '<span value="'.$account->id.'" class="accounts-searched ss-buildings">' . $account->name . '</span>';
		}
		if($accountsSearched != '') {
			$response = array(
				'accounts' => $accountsSearched,
				'msg' => 'found some'
			);
			return Response::json( $response );
		}
		else {
			$response = array(
				'msg' => 'none'
			);
			return Response::json($response);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax()) return View::make('accounts.partials.new');
		else return Redirect::to('/accounts');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($accountname)
	{
        $account = Account::where('slug', '=', $accountname)->first();
        $accountAddress = $account->address.', '.$account->city.', '.$account->state;
		
        // Set new Geocoder and set Provider
		$geocoder = new Geocoder();
		$geocoder->registerProviders(array(
		    new GeocoderProvider(new CurlHttpAdapter()),
		));
		// Geocode a location from basic address, city, state
		$response = $geocoder->geocode($accountAddress);
		$status = $response->getStatus(); 
// dd($status);
		// Create your map
		$map = new Map();
		$map->setPrefixJavascriptVariable('map_');
		$map->setHtmlContainerId('map_canvas');
		$map->setAsync(false);
		$map->setAutoZoom(false);
		$map->setMapOption('zoom', 7);
		$map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);
		$map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
		$map->setMapOption('mapTypeId', 'roadmap');
		$map->setMapOption('disableDefaultUI', true);
		$map->setMapOption('disableDoubleClickZoom', true);
		$map->setMapOptions(array(
		    'disableDefaultUI'       => true,
		    'disableDoubleClickZoom' => true,
		));
		$map->setStylesheetOption('width', '400px');
		$map->setStylesheetOption('height', '300px');
		$map->setStylesheetOptions(array(
		    'width'  => '400px',
		    'height' => '300px',
		));
		
		// Create new info window for map
		$infoWindow = new InfoWindow();

		// Configure your info window options
		$infoWindow->setPrefixJavascriptVariable('info_window_');
		$infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
		$infoWindow->setContent('<h4>'.$account->name.'</h4><p>'.$account->address.'</p><p>'.$account->city.', '.$account->state.'</p>');
		$infoWindow->setOpen(true);
		$infoWindow->setAutoOpen(true);
		$infoWindow->setOpenEvent('click');
		$infoWindow->setAutoClose(false);
		$infoWindow->setOption('disableAutoPan', true);
		$infoWindow->setOption('zIndex', 10);
		$infoWindow->setOptions(array(
		    'disableAutoPan' => true,
		    'zIndex'         => 10,
		));
		foreach ($response->getResults() as $result) {
		    // Create a marker
		    $marker = new Marker();

		    // Position the marker
		    $marker->setPosition($result->getGeometry()->getLocation());
		    $map->setCenter($result->getGeometry()->getLocation());
			$infoWindow->setPosition($result->getGeometry()->getLocation());
			$map->addInfoWindow($infoWindow);
		    // Add the marker to the map
		    $map->addMarker($marker);
		}
		$mapTypeControl = new MapTypeControl();

		// Add your map type control to the map
		$map->setMapTypeControl($mapTypeControl);
		$map->setMapTypeControl(
		    array(MapTypeId::ROADMAP, MapTypeId::SATELLITE),
		    ControlPosition::TOP_RIGHT,
		    MapTypeControlStyle::DEFAULT_
		);
		$zoomControl = new ZoomControl();

		// Add your zoom control to the map
		$map->setZoomControl($zoomControl);
		$map->setZoomControl(ControlPosition::TOP_LEFT, ZoomControlStyle::DEFAULT_);
		$overviewMapControl = new OverviewMapControl();

		// Add your overview map control to the map
		$map->setOverviewMapControl($overviewMapControl);
		$map->setOverviewMapControl(false);
		$mapHelper = new MapHelper();

		$mapJS = $mapHelper->renderJavascripts($map);
		$mapMap = $mapHelper->renderHtmlContainer($map);

		//Find projects, billables, help, invoices, and vault assets for this account
		$vaults = Vault::where('account_id','=',$account->id)
					  ->orderBy('created_at','DESC')
					  ->get();
		$projects = Project::where('account_id','=',$account->id)
					->orderBy('created_at','DESC')
					->get();
		// $billables = Billable::where('account_id','=',$account->id)
		// 			->orderBy('created_at','DESC')
		// 			->get();
		$billables = '';
		// $invoices = Invoice::where('account_id','=',$account->id)
		// 			->orderBy('created_at','DESC')
		// 			->get();
		$invoices = '';
		// $helps = Help::where('account_id','=',$account->id)
		// 			->orderBy('created_at','DESC')
		// 			->get();
		$helps = '';

		return View::make('accounts.single',compact('account','mapMap','mapJS','vaults','projects','billables','invoices','helps'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function accountContactInfo($id)
	{
		if(Request::ajax()) {
			$account = Account::find($id);
			return View::make('accounts.partials.account-contact-info-edit',compact('account'));
		}
		else return Redirect::route('accounts');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Update the account on single view pages.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateOnSingleView($id, $value)
	{
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/accounts')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
			$account = Account::where('id','=',$id)->first();
			if(empty($account)) return Redirect::to('/accounts');
			else $oldValue = $account->$value;
			
			if(Input::has('attachnewtag') == 'attachtag') {

		 		$validator = Validator::make(Input::all(), array(
					'tag_id' => 'required|integer',
					'type_id' => 'required|integer'
				));

				if($validator->fails()) {
					$messages = $validator->messages();
					$response = array(
						'actionType' => 'account-update',
						'errorMsg' => $messages->first()
					);
					return Response::json( $response );
				}

				$articleId = Input::get('type_id');
				$parseTags = Input::get('tag_id');
				$parseTags = explode(',', $parseTags);
				$parseTags = array_unique($parseTags);
				foreach($parseTags as $parseTag) {
					if(is_numeric($parseTag)) {
						$newTagRelationship = $this->tagRelationship->newRelationship($parseTag, 'account', $articleId);
						if($newTagRelationship == 'fail') {
							$response = array(
								'actionType' => 'account-update',
								'errorMsg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
							);
							return Response::json( $response );
						}
						if($newTagRelationship == 'existing') {
							$response = array(
								'actionType' => 'account-update',
								'errorMsg' => 'This tag is already attached to this Account.'
							);
							return Response::json( $response );
						}
					}
					else {
						$response = array(
							'actionType' => 'account-update',
							'errorMsg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
						);
						return Response::json( $response );
					}
				}

				$response = array(
					'actionType' => 'account-update',
					'tagsText' => Input::get('tagsText'),
					'tagID' => Input::get('tag_id'),
					'msg' => 'Tag added successfully!'
				);
				return Response::json( $response );

			}
			if(Input::has('detachtag') == 'detachtag') {
				$validator = Validator::make(Input::all(), array(
					'tag_id' => 'required|integer',
					'type_id' => 'required|integer'
				));
				if($validator->fails()) {
					$messages = $validator->messages();
					$response = array(
						'actionType' => 'tag-detach',
						'errorMsg' => $messages->first()
					);
					return Response::json( $response );
				}
				$tagID = Input::get('tag_id');
				$type = 'account';
				$typeID = Input::get('type_id');

				$findExisitingRelationship = TagRelationship::where('tag_id','=',$tagID)
											 ->where('type','=',$type)
											 ->where('type_id','=',$typeID)
											 ->first();
				try
				{
					$findExisitingRelationship->delete();
				} catch(Illuminate\Database\QueryException $e)
				{
					$response = array(
						'actionType' => 'tag-detach',
						'errorMsg' => 'Oops, there was a problem removing the tag. Please try again.'
					);
					return Response::json( $response );
				}

				$response = array(
					'actionType' => 'tag-detach',
					'tagsText' => Input::get('tagsText'),
					'msg' => 'Tag removed successfully!'
				);
				return Response::json( $response );
			}
			
			return Response::json( $response );
		}
		else return Redirect::route('accounts');
	}

	public function removeImage($id,$imageName) {
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/accounts')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
			$account = Account::find($id);
			$attachments = $account->attachment;
			$attachments = unserialize($attachments);
			$imagePath = Input::get('imagePath');
			$imageName = $imagePath;
			$name = array_search($imageName, $attachments);
			if($name !== false) unset($attachments[$name]);
			if(empty($attachments)) $account->attachment = '';
			else $account->attachment = serialize($attachments);
			try
				{
					$account->save();
				} catch(Illuminate\Database\QueryException $e)
				{
					$response = array(
						'actionType' => 'attachment-delete',
						'errorMsg' => 'Oops, something went wrong. Please try again.',
					);
					return Response::json( $response );
				}

			$response = array(
				'actionType' => 'attachment-delete',
				'msg' => 'Attachment removed.',
				'image' => $imageName,
			);
				
			return Response::json( $response );
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$account = Account::find($id);
		if(Auth::user()->userrole == 'admin' || Auth::user()->id == $account->author_id) {
			$accountTitle = $account->title;
			$account->delete();
			return Redirect::to('/accounts/')->with('flash_message_error', '<i>' . $accountTitle . '</i> successfully deleted');
		}
		else return Redirect::route('accounts');
	}

}