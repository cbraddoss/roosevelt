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
	public function __construct(Mailer $mailer, Project $project, Account $account)
	{
		$this->beforeFilter('auth');

		$this->beforeFilter('csrf', array('on' => 'post'));

        $this->mailer = $mailer;

        $this->project = $project;

        //$this->accountComment = $accountComment;

        $this->account = $account;
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

		return View::make('accounts.single',compact('account','mapMap','mapJS'));
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}