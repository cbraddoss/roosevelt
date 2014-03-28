## InsideOut Solutions Employee Remote Office

### Code Name: Roosevelt

Project management, Account management, and internal company tools system designed for InsideOut Solutions.

##Pulling from bitbucket
Use SourceTree and clone this project into a new directory (office.localdev for example)

In terminal, go to the new directory stated above (your directory may vary), e.g.:

	cd ~/Sites/office.localdev

Run in terminal:

	composer install

Installation complete at http://office.localdev !

##Once pulled from bitbucket:
Overwrite .gitignore with the following (exactly):

	/bootstrap/compiled.php
	/vendor
	/app/config/dev-brad
	/app/config/dev-jack
	/app/config/dev-taylor
	composer.phar
	composer.lock
	.env.local.php
	.env.php
	.DS_Store
	Thumbs.db

In /bootstrap/start.php under 'detectEnvironment' section, update hostname for your appropriate line (only change the CHANGE_ME text). Type 'hostname' in terminal to determine hostname. Ok to push to git after updated.

Create a directory in /app/config/ called dev-YOURNAME

Create 2 files. One called database.php and one called app.php

In app.php, add:

	<?php
	return array(
		'debug' => true,
		'url' => 'http://localhost'
	);

In database.php, add:

	<?php
	return array(
		'connections' => array(
			'mysql' => array(
				'driver'    => 'mysql',
				'host'      => 'localhost',
				'database'  => 'io_remoteoffice',
				'username'  => 'CHANGE_ME',
				'password'  => 'CHANGE_ME',
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix'    => '',
			)
		)
	);

Update appropriate CHANGE_ME values.

We'll be using 'io_remoteoffice' as the main database. Create a database with this name in your local environment. The database structure will be included with a migration (more on that below).

##Databse Migrations:

Run the following command to migrate included database structures:

	php artisan migrate

To seed the database with default values (mainly for testing during development):

	php artisan db:seed

If you have issues doing the above, try running (then run the above again):

	composer dump-autoload

##Additional Notes:

Creating a new view? Use the following structure as a guideline when extending the main view. Replace all instances of 'NewPage' with desired page name.

	@extends('layout.main')

	@section('page-title')
	{{ 'NewPage' }}
	@stop

	@section('page-content')
	<div id="page-title">
		<h2>NewPage</h2>
	</div>

	<div id="NewPage-page"  class="inner-page">

	</div>
	@stop


##Quick guide for a new Laravel install on a local dev environment:

Not needed for this project, but good if you want to run a separate Laravel install for additional testing.

Go to https://getcomposer.org/download/ and run this command in terminal:

	curl -sS https://getcomposer.org/installer | php

Then run:

	sudo mv composer.phar /usr/local/bin/composer

Go the the directory you want to install a new Laravel installation. e.g.:

	cd ~/Sites/laraveltest.localdev

Install Laravel in above desired directory (this takes a couple of minutes to complete):

	composer create-project laravel/laravel laraveltest.localdev

Go to http://laraveltest.localdev and you should have a fresh installation of Laravel!