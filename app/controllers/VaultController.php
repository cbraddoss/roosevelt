<?php

use \Vaults;
use \Tags;
use \TagRelationships;

class VaultController extends \BaseController {

	/**
     * Instantiate a new ProjectsController instance.
     */
    public function __construct(Vault $vault, Tag $tag, TagRelationship $tagRelationship)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

		$this->vault = $vault;

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
		if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) return View::make('assets.vault-access');
		
		// Cache::forget('vault_key_'.Auth::user()->user_path);
		$vaults = $this->vault->getAllVaults();
		$vaultsCount = $vaults->count();
		$vaultTagsSelect = $this->vault->getSelectListVaultTags();
		return View::make('assets.vault',compact('vaults','vaultsCount','vaultTagsSelect'));
	}

	/**
	 * Verify Vault Access.
	 *
	 * @return Response
	 */
	public function vaultAccess()
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/assets/vault')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		$vault_key = Input::get('vault_key');
 		//change key to value stored in db and able to change in admin area
		if($vault_key == '1234') {
			$expiresAt = Carbon::now()->addMinutes(30);
			Cache::put('vault_key_'.Auth::user()->user_path, 'vault access', $expiresAt);
		}
		return Redirect::route('assets.vault');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax()) {
			if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) {
				$response = array(
					'actionType' => 'vault-add',
					'errorMsg' => 'do not load form'
				);
				return Response::json( $response );
			}
			return View::make('assets.partials.new-vault-asset');
		}
		if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) return View::make('assets.vault-access');
		return Redirect::to('/assets/vault');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) return Redirect::to('assets.vault')->with('flash_message_error','Please enter vault key again.');
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/assets/vault')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		$validator = Validator::make(Input::all(), array(
			'title' => 'required|max:120',
			'url' => 'required',
			'username' => 'required',
			'password' => 'required',
			'type' => 'required|in:website,ftp,database,email,server,generic'
		));

		if($validator->fails()) {
			$messages = $validator->messages();
			$response = array(
				'actionType' => 'vault-add',
				'errorMsg' => $messages->first()
			);
			return Response::json( $response );
		}
		else {
			$newVault = new Vault;
			$newVault->title = clean_title(Input::get('title'));
			$newVault->slug = convert_title_to_path(Input::get('title'));
			$newVault->type = Input::get('type');
			$newVault->author_id = Auth::user()->id;
			$newVault->edit_id = Auth::user()->id;
			$newVault->account_id = Input::get('account_id');
			$newVault->url = Input::get('url');
			$newVault->username = Input::get('username');

 			$vaultPW = Input::get('password');
			$newVault->password = Crypt::encrypt($vaultPW);

			if(Input::has('notes')) $newVault->notes = clean_content(Input::get('notes'));
			
			if(Input::has('database_name')) $newVault->database_name = Input::get('database_name');
			if(Input::has('ftp_path')) $newVault->ftp_path = Input::get('ftp_path');

			if(Input::hasFile('attachment')) {
				$attachment = Input::file('attachment');
				$fileNames = array();
				foreach($attachment as $attach) {
					$fileName = $attach->getClientOriginalName();
					$fileExtension = $attach->getClientOriginalExtension();
					$currentTime = Carbon::now()->timestamp;
					$attach = $attach->move(upload_path(), $currentTime.'-'.$fileName);
					if($fileExtension != 'pdf') $attachThumbnail = Image::make($attach)->resize(300, null, true)->crop(200,200,0,0)->save(upload_path().'thumbnail-'.$currentTime.'-'.$fileName);
					$fileNames[] = '/uploads/'.Carbon::now()->format('Y').'/'.Carbon::now()->format('m').'/'.$currentTime.'-'.$fileName;
				}
				$newVault->attachment = serialize($fileNames);
			}

			try
			{
				$newVault->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				$response = array(
					'actionType' => 'vault-add',
					'errorMsg' => 'Oops, there might be a vault asset with this title already. Try a different title.'
				);
				return Response::json( $response );
			}

			if(Input::has('tag_id')) {
				$parseTags = Input::get('tag_id');
				$parseTags = explode(',', $parseTags);
				$parseTags = array_unique($parseTags);
				foreach($parseTags as $parseTag) {
					if(is_numeric($parseTag)) {
						$newTagRelationship = $this->tagRelationship->newRelationship($parseTag, 'vault', $newVault->id);
						if($newTagRelationship == 'fail') {
							$response = array(
								'actionType' => 'vault-add',
								'slug' => $newVault->slug,
								'windowAction' => '/assets/vault/asset/'.$newVault->slug,
								'msg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
							);
							return Response::json( $response );
						}
					}
					else {
						$response = array(
							'actionType' => 'vault-add',
							'slug' => $newVault->slug,
							'windowAction' => '/assets/vault/asset/'.$newVault->slug,
							'msg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
						);
						return Response::json( $response );
					}
				}
			}

			$response = array(
				'actionType' => 'vault-add',
				'slug' => $newVault->slug,
				'windowAction' => '/assets/vault/asset/'.$newVault->slug,
				'msg' => 'Vault Asset created successfully!'
			);
			return Response::json( $response );
		}
		
		$response = array(
			'actionType' => 'vault-add',
			'errorMsg' => 'Something went wrong. :('
		);
		return Response::json( $response );

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) return Redirect::route('assets.vault');
		
		$vaultAsset = Vault::where('slug', $slug)->first();

		if(empty($vaultAsset)) return Redirect::route('assets.vault');
		
		//$currentUser = Auth::user();
		// if($vaultAsset->type == 'server') {
		// 	if($currentUser->userrole == 'admin' || $article->author_id == $currentUser->id) $testing = ''; 
		// 	else return Redirect::route('news');
		// }

		if($vaultAsset) return View::make('assets.vault-single', compact('vaultAsset'));
		else return Redirect::route('assets.vault');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showPassword($slug)
	{
		if(Request::ajax()) {
			if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) {
				$response = array(
					'actionType' => 'password-show',
					'errorMsg' => 'do not load form'
				);
				return Response::json( $response );
			}
			$vaultAsset = Vault::where('slug', $slug)->first();
			if(empty($vaultAsset)) return Redirect::route('assets.vault');
			else $getPassword = Crypt::decrypt($vaultAsset->password);
			$response = array(
				'actionType' => 'password-show',
				'asset' => $getPassword,
				'msg' => 'asset found'
			);
			return Response::json( $response );
		}
		if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) return Redirect::route('assets.vault');
		return Redirect::to('/assets/vault/');
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function tags($tag)
	{
		if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) return Redirect::route('assets.vault');
		
		$vaultTagsSelect = $this->vault->getSelectListVaultTags($tag);
		$tag = Tag::where('slug','=',$tag)->first();
		
		$vaultTagRelationships = TagRelationship::where('tag_id','=',$tag->id)
					->where('type','=','vault')
					->orderBy('created_at','DESC')
					->get();
		foreach($vaultTagRelationships as $tagVault) {
			$vaultIDs[] = $tagVault->type_id;
		}
		if(!empty($vaultIDs)) $vaultIDs = array_unique($vaultIDs);
		else $vaultIDs = array(0);
		$vaults = Vault::whereIn('id',$vaultIDs)
					 ->orderBy('created_at','DESC')
					 ->get();
		
		return View::make('assets.vault-tag', compact('tag','vaults','vaultTagsSelect'));
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateOnSingleView($id, $value)
	{
		if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) return Redirect::to('assets.vault')->with('flash_message_error','Please enter vault key again.');
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/assets/vault')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		if(Input::has('attachnewtag') == 'attachtag') {

	 		$validator = Validator::make(Input::all(), array(
				'tag_id' => 'required|integer',
				'type_id' => 'required|integer'
			));

			if($validator->fails()) {
				$messages = $validator->messages();
				$response = array(
					'actionType' => 'vault-update',
					'errorMsg' => $messages->first()
				);
				return Response::json( $response );
			}

			$vaultId = Input::get('type_id');
			$parseTags = Input::get('tag_id');
			$parseTags = explode(',', $parseTags);
			$parseTags = array_unique($parseTags);
			foreach($parseTags as $parseTag) {
				if(is_numeric($parseTag)) {
					$newTagRelationship = $this->tagRelationship->newRelationship($parseTag, 'vault', $vaultId);
					if($newTagRelationship == 'fail') {
						$response = array(
							'actionType' => 'vault-update',
							'errorMsg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
						);
						return Response::json( $response );
					}
				}
				else {
					$response = array(
						'actionType' => 'vault-update',
						'errorMsg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
					);
					return Response::json( $response );
				}
			}

			$response = array(
				'actionType' => 'vault-update',
				'tagsText' => Input::get('tagsText'),
				'msg' => 'Tag added successfully!'
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
		$vault = Vault::find($id);
		if(Auth::user()->userrole != 'admin') {
			$vaultTitle = $vault->title;
			$vault->delete();
			return Redirect::to('/assets/vault/')->with('flash_message_error', '<i>' . $vaultTitle . '</i> successfully deleted.');
		}
		else return Redirect::route('assets.vault');
	}


}
