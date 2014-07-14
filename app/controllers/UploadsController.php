<?php

class UploadsController extends \BaseController {

	public function __construct()
    {
        $this->beforeFilter('auth');

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
			if(file_exists($path)) {
				if(strpos($path, '.pdf') !== false || strpos($path, '.PDF') !== false) {
					$resource = file_get_contents($path);
					return Response::make($resource, 200, array('content-type'=>'application/pdf'));
				}
				else return Response::download($path);
			}
		}
	}

}
