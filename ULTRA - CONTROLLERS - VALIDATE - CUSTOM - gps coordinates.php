<?php
/**
 * ULTRA - CONTROLLERS - VALIDATE - CUSTOM - GPS COORDINATES
 *
 * > change Providers / AppServiceProvider.php 
 */

/* AppServiceProvider.php */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('gps_lat', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $value);
        });

        Validator::extend('gps_lng', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}


/*Controller*/
public function postRoute(Request $request) {
	$this->validate($request, array(
		'startLong'     =>  'required|gps_lng',
		'startLat'      =>  'required|gps_lat',
		'endLong'       =>  'required|gps_lng',
		'endLat'        =>  'required|gps_lat',
	));

}