<?php 
/*

!!!! BASIC - ROUTES !!!!

<< EXPLANATION >>
	>> Routes >> tell php what url to expect & what to do when you get that url
	

> takes in any route from our application

>> ALERT <<
	Some routes do not have name & that is ok

Basic steps for functions: (USE THIS MUCH SIMPLE)
1) create route
2) create view (in our case contact.blade.php)

Basic steps for controllers:
1.1.) create controller route
1.2.) create controller with console & put some functions inside

*/

/**
 * Make Everything for Controller & Routes
 * > this give every method (show, edit, delete, index...)
 * > create all the routes in routes file
 */
php artisan make:controller PostsController --resource

Route::resource('posts', 'PostsController');


/*
ROUTES > WEB API
1) FUNCTION
We have a route that makes a get requerst to the home directory(/), we are going to execute
this anonymous function, which returnes the view welcome
	** welcome view is what returns laravel starting page -> http://localhost:8000/ (what is on there) 
	or if stored in wamp > www > webApp -> http://localhost/myLavPro/public/about **
2) CONTROLLER
We have a route that takes a get request to the contact page & is going to go to pagescontroller &
look up contact method & run that method. That method will return the view for contact
*/
/*1 - starting - get welcome.blade.php view*/
Route::get('/', function () {
    return view('welcome');
});
/*1.1. Or through controller*/
Route::get('/', 'PagesController@index');

/*Example route (function) - get contact.blade.php view*/
Route::get('contact', function() {
    return view('contact');
});
/*2 - Example route*/
/*Logic - hej Laravel go to PagesController find contact function & get data to contact.blade.php in views*/
Route::get('contact', 'PagesController@contact');

/*
Force change name of the route (OPTIONAL)
> use if name does'not show in routes:list
- name of route is -> 'login'
- controller uses -> 'Auth\AuthController@getLogin'
*/
Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);

/**
 * Pass data in url
 */
Route::get('/users/{id}', function($id) {
	return "This is user " . $id;
});

Route::get('/cars/{id}/{name}', function($id, $name) {
	return "This is car named " . $name . " with id " . $id;
});

/*
RESOURCES > VIEWS
We have a welcome.blade.php view & that is displayed on laravel starting page
- it has entire html & part of css file in there (standard page)
*/

/*
Controller example
*/
class PagesController extends Controller
{
    public function contact() {
        return view('contact');
    }
}


/*
>> ALERT <<
	Accessing Routes inside application (HTML)
	a) if you have named routes
	b) if you have unnamed routes
*/
{{ route('pages.contact') }}	// a
{{ url('contact') }}	// b
?>