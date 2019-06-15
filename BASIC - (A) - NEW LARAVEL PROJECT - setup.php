<?php 
/*
NEW LAVAREL PROJECT - SUBLIME TEXT


4.) Install -- Laravel for your project
	- go to parent directory >> C:\Users\DevilMayPoop\Sites
	> command prompt -> laravel new <website name>
	!! TO to command prompt to the <website name> folder & than install the rest !!
	
5.) Install -- barryvdh/laravel-ide-helper (TREBAO SE POJAVITI laravel-ide-helper.file ali nije - MAYBY NOT INSTALL)
	> command prompt -> composer require barryvdh/laravel-ide-helper
	EXTRA - after the ide-helper is installed add this to config > app.php
	- under all Application Service Providers...add
		Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
		(Go to https://github.com/barryvdh/laravel-ide-helper#automatic-phpdoc-generation-for-laravel-facades
		to check that this is ok for this service)
	
6.) You can set timezone app > config > app.php
	'timezone' => 'Europe/Zagreb',
	(get values from http://php.net/manual/en/timezones.php)
	
7.1) Install -- caouecs/lavarel4-lang
	> command prompt -> composer require caouecs/laravel-lang:~3.0
	(Version to install - 3.0.16)
	
7.2) Go to vendor > caouesc > laravel4-lang > src > hr folder & copy folder to resources > lang

8.) Install -- laravelcollective/html (NE ZNAM DA LI JEST - MAYBY NOT INSTALL)
	> command prompt -> composer require "laravelcollective/html":"^5.2.0"
	(Version to install - v5.3.0)
	EXTRA - after the ide-helper is installed add this to config > app.php 
	- under all Application Service Providers...add
		Collective\Html\HtmlServiceProvider::class,
		(Go to https://laravelcollective.com/docs/5.3/html
		to check that this is ok for this service)
	- under Class Aliases... add
		'Form' => Collective\Html\FormFacade::class,
		'Html' => Collective\Html\HtmlFacade::class,

		
10.1.) Install -- Laravel 5 Extended Generators (GENERATORS ARE SOMEHWAT FUCKED UP RIGHT NOW)
	a) > command prompt -> composer require laracasts/generators --dev
	b) change registry in app/Providers/AppServiceProvider.php
			public function register()
			{
				if ($this->app->environment() == 'local') {
					$this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
				}
			}
	** https://github.com/laracasts/Laravel-5-Generators-Extended **

11) node / npm / git / gulp (command prompt)
	a) check you have node & npm -> node -v  & npm -v
	b) check you have git -> git --version
	c) install npm in project folder -> npm install
	d) mayby -> bower install
		** POGLEDAJ package.json - u starim verzijama koje rade **
	Install following this tutorial
	https://laracasts.com/series/laravel-5-fundamentals/episodes/19
	
	SECOND OPTION without GULP (EASY - just do npm install)
	> command prompt > npm run watch

11) a) Install vue-router	
	- as an dependancy in package-json (you also have devDependencies)
	** without dependancy is just npm install vue-router **
	> command prompt -> npm install --save vue-router
	(Go To: https://github.com/vuejs/vue-router)
	
12.) Look up BASIC - AUTHENTIFICATION
	
13.) SERVER (Local Laravel Server)
	START Laravel Server
		- go to root directory of your sites
		> command prompt -> php artisan serve
		*path to local server in browser -> http://localhost:8000/
	END Laravel Server
		> command prompt -> CTRL + c
	WAMP SITE - accessable like so - http://localhost/mySite/public
		
14.) gulp (watch for the changes)
	> command prompt -> gulp watch

*/

?>