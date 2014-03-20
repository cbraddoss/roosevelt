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

In /app/config/dev-YOURNAME/database.php update the appropriate lines for your database connection.
We'll be using 'remoteoffice' as the main database. The database structure will be included with a migration (more on that below).

##Databse Migrations:

Coming soon...


##Quick guide for a new Laravel install on a local dev environment:
Go to https://getcomposer.org/download/ and run this command in terminal:

	curl -sS https://getcomposer.org/installer | php

Then run:

	sudo mv composer.phar /usr/local/bin/composer

Go the the directory you want to install a new Laravel installation. e.g.:

	cd ~/Sites/laraveltest.localdev

Install Laravel in above desired directory (this takes a couple of minutes to complete):

	composer create-project laravel/laravel laraveltest.localdev

Go to http://laraveltest.localdev and you should have a fresh installation of Laravel!