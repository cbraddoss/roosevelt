<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',128)->unique();
			$table->enum('status', array('active', 'inactive'));
			$table->string('link')->unique();
			$table->string('email',50);
			$table->string('website',128);
			$table->integer('author_id');
			$table->integer('billable_time');
			$table->date('billable_expire');
			$table->date('billable_renew');
			$table->integer('billable_time_max');
			$table->string('past_due');
			$table->text('website_aliases');
			$table->text('outside_accounts');
			$table->string('address');
			$table->string('city');
			$table->string('state');
			$table->string('zip');
			$table->string('phone_number');
			$table->string('toll_free_number');
			$table->string('fax');
			$table->string('client_type');
			$table->string('site_designed');
			$table->date('site_launch_date');
			$table->date('hosting_started');
			$table->date('hosting_ended');
			$table->string('hosting_type');
			$table->string('hosting_addons');
			$table->string('sem_rep');
			$table->date('sem_started');
			$table->date('sem_ended');
			$table->string('sem_type');
			$table->string('sem_addons');
			$table->string('sem_blog_posts');
			$table->string('print_options');
			$table->date('print_last_rack_cards_date');
			$table->string('print_last_rack_cards_quantity');
			$table->date('print_last_business_cards_date');
			$table->string('print_last_business_cards_quantity');
			$table->date('print_last_letter_head_date');
			$table->string('print_last_letter_head_quantity');
			$table->date('print_last_envelopes_date');
			$table->string('print_last_envelopes_quantity');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('accounts');
	}

}
