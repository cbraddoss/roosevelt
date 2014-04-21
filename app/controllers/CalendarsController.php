<?php

use \Calendar;

class CalendarsController extends \BaseController {

	protected $calendar;

	/**
     * Instantiate a new UsersController instance.
     */
    public function __construct(Calendar $calendar)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->calendar = $calendar;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$calendarShow = $this->calendar->show_current_month();
		$selectedMonth = Carbon::now()->format('F');
		$selectedYear = Carbon::now()->format('Y');
		$nextMonthYear = Carbon::now()->addMonths(1)->format('Y/F');
		$previousMonthYear = Carbon::now()->subMonths(1)->format('Y/F');
		return View::make('calendar.index', compact('calendarShow','nextMonthYear','previousMonthYear','selectedYear', 'selectedMonth'));
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
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($year, $month)
	{
		$calendarShow = $this->calendar->show_selected_month($year, $month);
		$selectedMonth = Carbon::parse($month.$year)->format('F');
		$selectedYear = Carbon::parse($month.$year)->format('Y');
		$nextMonthYear = Carbon::parse($month.$year)->addMonths(1)->format('Y/F');
		$previousMonthYear = Carbon::parse($month.$year)->subMonths(1)->format('Y/F');
		return View::make('calendar.index', compact('calendarShow','nextMonthYear','previousMonthYear','selectedYear', 'selectedMonth'));
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
