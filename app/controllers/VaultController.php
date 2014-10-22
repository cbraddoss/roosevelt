<?php

use \Vaults;
use \Tags;

class VaultController extends \BaseController {

	/**
     * Instantiate a new ProjectsController instance.
     */
    public function __construct(Vault $vault, Tag $tag)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

		$this->vault = $vault;

		$this->tag = $tag;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax()) {
			if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) {
				$response = array(
					'errorMsg' => 'do not load form'
				);
				return Response::json( $response );
			}
			return View::make('assets.partials.new-vault-asset');
		}
		if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) return View::make('assets.vault-access');
		
		$vaults = $this->vault->getAllVaults();
		$vaultsCount = $vaults->count();
		return View::make('assets.vault',compact('vaults','vaultsCount'));
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
		if($vault_key == '1234') {
			$expiresAt = Carbon::now()->addMinutes(15);
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
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ( Cache::get('vault_key_'.Auth::user()->user_path) != 'vault access' ) return Redirect::to('assets.vault');
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
			$newVault->url = Input::get('url');
			$newVault->username = Input::get('username');

 			$vaultPW = Input::get('password');
			$newVault->password = Crypt::encrypt($vaultPW);

			if(Input::has('notes')) $newVault->notes = clean_content(Input::get('notes'));
			
			if(Input::has('tags')) {
				$newVault->tag_id = '';
			}

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
					'errorMsg' => 'Oops, there might be a vault asset with this title already. Try a different title.'
				);
				return Response::json( $response );
			}

			$response = array(
				'slug' => $newVault->slug,
				'msg' => 'Vault Asset created successfully!'
			);
			return Response::json( $response );
		}
		
		$response = array(
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
		$vaultAsset = Vault::where('slug', $slug)->first();

		if(empty($vaultAsset)) return Redirect::route('assets.vault');
		
		//$currentUser = Auth::user();
		// if($vaultAsset->type == 'server') {
		// 	if($currentUser->userrole == 'admin' || $article->author_id == $currentUser->id) $testing = ''; 
		// 	else return Redirect::route('news');
		// }
		
		//move to ajax called function
		//$decrypted = Crypt::decrypt($encryptedValue);

		if($vaultAsset) return View::make('assets.vault-single', compact('vaultAsset'));
		else return Redirect::route('assets.vault');
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
