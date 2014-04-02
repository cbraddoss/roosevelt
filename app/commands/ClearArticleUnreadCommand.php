<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ClearArticleUnreadCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'office:clear-article-unread';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Mark articles older than 1 month as read for all users.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$lastMonth = new DateTime('-1 month');
		$beenRead = '';
		$lastThreeMonths = new DateTime('-3 months');
		$articles = Article::where('created_at','<=',$lastMonth)
					->where('created_at','>=',$lastThreeMonths)->get();
		$usersAll = User::all();
		foreach($usersAll as $user) {
			$beenRead .= any_user_path($user->id).' ';
		}
		foreach($articles as $article) {
			$article->been_read = $beenRead;
			$article->save();
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
