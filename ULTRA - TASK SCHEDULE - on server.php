<?php 
/*

!! ULTRA - TASK SCHEDULE - ON SERVER !!

> run controller methods on server with cronjob
> run tasks every time interval

*/

/*
App > Console > Kernel.php
*/
protected function schedule(Schedule $schedule)
{
	$schedule->call('App\Http\Controllers\WeatherController@storeWeather')
			 ->everyFiveMinutes();
}


/*
SERVER root (may need to select nano editor to open cronjob)
> open crontab & add below line to file
*/
crontab -e

* * * * * php /var/www/laravel/artisan schedule:run 1>> /dev/null 2>&1

?>