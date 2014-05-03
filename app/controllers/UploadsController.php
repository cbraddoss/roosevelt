<?php

class UploadsController extends \BaseController {

	public function __construct()
    {
        $this->beforeFilter('admin');

        $this->beforeFilter('csrf', array('on' => 'post'));
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($year,$month,$name)
	{
		if ( Auth::guest() ) return Redirect::guest('login');
		else {
			$path = storage_path().'/uploads/'.$year.'/'.$month.'/'.$name;
			return Response::download($path);
		}
	}

}
