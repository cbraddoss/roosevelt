<?php

class Calendar {

	// public function show_current_month() {
	// 	// Start a clean calendar variable
	// 	$calendar = '';
		
	// 	// Get last days of previous month to start calendar view (if needed)
	// 	// get number of days in previous month
	// 	$daysLastMonth = Carbon::now()->addMonth(-1)->daysInMonth;
	// 	// get Sunday-Saturday numeric value of first day in this month
	// 	$monthFirstDay = Carbon::parse('first day of this month this year')->format('w');
	// 	$p = $daysLastMonth;
	// 	for($m=1; $m<=$monthFirstDay; $m++) {
	// 		$calendar .= '<span class="day last-month"><small>' . Carbon::parse('last month this year')->format('F') . '</small><span class="day-num">' . Carbon::parse('last day of last month this year')->addDays($m-2)->format('j') . '</span></span>';
	// 	}
		
	// 	// Populate current month calendar view
	// 	// get number of days in current month
	// 	$daysThisMonth = Carbon::now()->daysInMonth;
	// 	// get Articles with show_on_calendar
	// 	$articleShow = Article::where('show_on_calendar', '!=', '0000-00-00 00:00:00')
	// 					->where('status','published')
	// 					->get();
	// 	//dd($articleShow);
	// 	$articleThisMonth = array();
	// 	$articleNextMonth = array();
	// 	foreach($articleShow as $aShow) {
	// 		$aNum = Carbon::createFromFormat('Y-m-d H:i:s', $aShow->show_on_calendar)->format('j');
	// 		$aMonth = Carbon::createFromFormat('Y-m-d H:i:s', $aShow->show_on_calendar)->format('m');
	// 		//dd($aMonth);
	// 		$aShow->title = ( (strlen($aShow->title) >= '15') ? $aShow->title = substr($aShow->title, 0, 15).'...' : $aShow->title);
	// 		if($aMonth == Carbon::now()->format('m')) {
	// 			if(array_key_exists($aNum, $articleThisMonth)) $articleThisMonth[$aNum] .= '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
	// 			else $articleThisMonth[$aNum] = '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
	// 			//$articleTitleThisMonth[$aNum] = $aShow->title;
	// 			//$articleLinkThisMonth[$aNum] = $aShow->link;
	// 		}
	// 		if($aMonth == Carbon::now()->addMonth(1)->format('m')) {
	// 			if(array_key_exists($aNum, $articleNextMonth)) $articleNextMonth[$aNum] .= '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
	// 			else $articleNextMonth[$aNum] = '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
	// 			// $articleTitleNextMonth[$aNum] = $aShow->title;
	// 			// $articleLinkNextMonth[$aNum] = $aShow->link;
	// 		}
	// 	}
	// 	//dd($articleTitle);
	// 	for($i=1; $i<=$daysThisMonth; $i++) {
	// 		$today = ( (Carbon::today()->format('j') == $i) ? $today = 'today' : $today = '');
	// 		if(!empty($articleThisMonth[$i])) $calendar .= '<span class="day ' . $today . ' this-month">' . $articleThisMonth[$i] . '<span class="day-num">' . $i . '</span></span>';
	// 		else $calendar .= '<span class="day ' . $today . ' this-month"><span class="day-num">' . $i . '</span></span>';
		
	// 	}
		
	// 	// Get first days of next month to fill out calendar view (if needed)
	// 	// get Sunday-Saturday numeric value of last day in this month
	// 	$monthLastWeek = Carbon::parse('last day of this month this year')->format('w');
	// 	$n=0;
	// 	for($w=6; $w>$monthLastWeek; $w--) {
	// 		if(!empty($articleNextMonth[$n+1])) $calendar .= '<span class="day next-month">' . $articleNextMonth[$n+1] . '<span class="day-num">' . Carbon::parse('first day of next month this year')->addDays($n++)->format('j') . '</span></span>';
	// 		else $calendar .= '<span class="day next-month"><small>' . Carbon::parse('next month this year')->format('F') . '</small><span class="day-num">' . Carbon::parse('first day of next month this year')->addDays($n++)->format('j') . '</span></span>';
	// 		//else $calendar .= '<span class="day next-month">' . Carbon::parse('first day of next month this year')->addDays($n++)->format('j') . '</span>';
	// 	}
		
	// 	return $calendar;
	// }

	public function show_selected_month($year, $month) {
		// Start a clean calendar variable
		$calendar = '';
		
		// Selected Month
		$selectedMonth = Carbon::parse($month.$year)->format('F');
		$selectedYear = Carbon::parse($month.$year)->format('Y');

		// Previous Month and Month-Year
		$previousMonth = Carbon::parse($month.$year)->subMonths(1)->format('F');
		$previousMonthYear = Carbon::parse($month.$year)->subMonths(1)->format('Y/F');

		// Next Month and Month-Year
		$nextMonth = Carbon::parse($month.$year)->addMonths(1)->format('F');
		$nextMonthYear = Carbon::parse($month.$year)->addMonths(1)->format('Y/F');

		// get Articles with show_on_calendar
		$articleShow = Article::where('show_on_calendar', '>=', Carbon::parse('first day of '.$month.$year)->subWeeks(1))
						->where('show_on_calendar', '<=', Carbon::parse('last day of '.$month.$year)->addWeeks(1))
						->where('status','published')
						->get();
		//dd($articleShow);
		$postPreviousMonth = array();
		$postThisMonth = array();
		$postNextMonth = array();
		foreach($articleShow as $aShow) {
			// create article month and article year values
			$aNum = Carbon::createFromFormat('Y-m-d H:i:s', $aShow->show_on_calendar)->format('j');
			$aMonth = Carbon::createFromFormat('Y-m-d H:i:s', $aShow->show_on_calendar)->format('m');
			//dd($aMonth);
			// get article title and shorten to 15 characters (if needed)
			$aShow->title = ( (strlen($aShow->title) >= '15') ? $aShow->title = substr($aShow->title, 0, 15).'...' : $aShow->title);

			// parse previous month article
			if($aMonth == Carbon::parse($previousMonth.$year)->format('m')) {
				if(array_key_exists($aNum, $postPreviousMonth)) $postPreviousMonth[$aNum] .= '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
				else $postPreviousMonth[$aNum] = '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
			}

			// parse selected month articles
			if($aMonth == Carbon::parse($month.$year)->format('m')) {
				if(array_key_exists($aNum, $postThisMonth)) $postThisMonth[$aNum] .= '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
				else $postThisMonth[$aNum] = '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
			}

			// parse next month article
			if($aMonth == Carbon::parse($nextMonth.$year)->format('m')) {
				if(array_key_exists($aNum, $postNextMonth)) $postNextMonth[$aNum] .= '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
				else $postNextMonth[$aNum] = '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
			}
		}
		// get Employee Anniversaries
		$userAnniversary = User::all();
		foreach($userAnniversary as $uAnn) {
			// create anniversary month and anniversary year values
			$uNum = Carbon::createFromFormat('Y-m-d H:i:s', $uAnn->anniversary)->format('j');
			$uMonth = Carbon::createFromFormat('Y-m-d H:i:s', $uAnn->anniversary)->format('m');
			$uYears = Carbon::now()->format('Y')-Carbon::createFromFormat('Y-m-d H:i:s', $uAnn->anniversary)->format('Y');
			//dd($uYears);
			// get article title and shorten to 15 characters (if needed)
			$uAnn->title = $uAnn->first_name . ' ' . $uAnn->last_name;

			// parse previous month article
			if($uMonth == Carbon::parse($previousMonth.$year)->format('m')) {
				if(array_key_exists($uNum, $postPreviousMonth)) $postPreviousMonth[$uNum] .= '<a href="#" class="calendar-post-title user-anniversary-link">' . $uAnn->title . ' ['.$uYears.']</a>';
				else $postPreviousMonth[$uNum] = '<a href="#" class="calendar-post-title user-anniversary-link">' . $uAnn->title . ' ['.$uYears.']</a>';
			}

			// parse selected month articles
			if($uMonth == Carbon::parse($month.$year)->format('m')) {
				if(array_key_exists($uNum, $postThisMonth)) $postThisMonth[$uNum] .= '<a href="#" class="calendar-post-title user-anniversary-link">' . $uAnn->title . ' ['.$uYears.']</a>';
				else $postThisMonth[$uNum] = '<a href="#" class="calendar-post-title user-anniversary-link">' . $uAnn->title . ' ['.$uYears.']</a>';
			}

			// parse next month article
			if($uMonth == Carbon::parse($nextMonth.$year)->format('m')) {
				if(array_key_exists($uNum, $postNextMonth)) $postNextMonth[$uNum] .= '<a href="#" class="calendar-post-title user-anniversary-link">' . $uAnn->title . ' ['.$uYears.']</a>';
				else $postNextMonth[$uNum] = '<a href="#" class="calendar-post-title user-anniversary-link">' . $uAnn->title . ' ['.$uYears.']</a>';
			}
		}
		//dd($postPreviousMonth);

		// Get last days of previous month to start calendar view (if needed)
		// get number of days in previous month
		$daysLastMonth = Carbon::parse($previousMonth.$year)->daysInMonth;
		// get Sunday-Saturday numeric value of first day of selelcted month
		$selectedMonthFirstDay = Carbon::parse('first day of '.$selectedMonth.$year)->format('w');
		// dd($selectedMonthFirstDay);
		// fill up start of calendar with previous month days
		for($m=0; $m<$selectedMonthFirstDay; $m++) {
			$previousMonthDay = ($daysLastMonth+($m-($selectedMonthFirstDay-1)));
			if(!empty($postPreviousMonth[$previousMonthDay])) $calendar .= '<span class="day last-month">' . $postPreviousMonth[$previousMonthDay] . '<small>' . Carbon::parse($previousMonth.$year)->format('F') . '</small><span class="day-num">' . $previousMonthDay . '</span></span>';
			else $calendar .= '<span class="day last-month"><small>' . Carbon::parse($previousMonth.$year)->format('F') . '</small><span class="day-num">' . $previousMonthDay . '</span></span>';
		}
		
		// Populate current month calendar view
		// get number of days in current month
		$daysThisMonth = Carbon::parse($month.$year)->daysInMonth;
		for($i=1; $i<=$daysThisMonth; $i++) {
			$today = ( ($month == Carbon::now()->format('F') && Carbon::today()->format('j') == $i) ? $today = 'today' : $today = '');
			if(!empty($postThisMonth[$i])) $calendar .= '<span class="day ' . $today . ' this-month">' . $postThisMonth[$i] . '<span class="day-num">' . $i . '</span></span>';
			else $calendar .= '<span class="day ' . $today . ' this-month"><span class="day-num">' . $i . '</span></span>';
		
		}
		
		// Get first days of next month to fill out calendar view (if needed)
		// get Sunday-Saturday numeric value of last day in this month
		$monthLastWeek = Carbon::parse('last day of '.$month.$year)->format('w');
		$n=0;
		for($w=6; $w>$monthLastWeek; $w--) {
			if(!empty($postNextMonth[$n+1])) $calendar .= '<span class="day next-month">' . $postNextMonth[$n+1] . '<small>' . Carbon::parse($nextMonth.$year)->format('F') . '</small><span class="day-num">' . Carbon::parse('first day of '.$nextMonth.$year)->addDays($n++)->format('j') . '</span></span>';
			else $calendar .= '<span class="day next-month"><small>' . Carbon::parse($nextMonth.$year)->format('F') . '</small><span class="day-num">' . Carbon::parse('first day of '.$nextMonth.$year)->addDays($n++)->format('j') . '</span></span>';
		}
		
		return $calendar;
	}
}