<?php 
/*

!! INTER - AUTHENTIFICATION - SETUP !!

> if you are manually creating forms <form></form> -> without laravelcollective/html, 
than you need to add csrf protection -> {!! csrf_field() !!} inside <form> as form element

+ we are leaning how to block certain:
	+) views
	+) controlers(methods)
	+) actions / page elements

*/

/*
OTHER USEFULL STUFF - look up fore more methods/functions
a) see if someone is logged in / out (return boolean) -> Auth::guest()
	+ very good with menues / good for visual changes / changing text...
	- do not use this to protect the files (use middleware for this)
b) see if someone is guest (return boolean) -> Auth::guest();
c) get information from the user out of database -> Auth::user();
	+ return eloquent object
d) get the id number -> Auth::id()
	+ redirect to someone's id page, save id number in npr. history file
e) manually atempt to log someone in
f) log someone in once
g) logout
*/
public function check();
public function guest();
public function user();
public function id();
public function attempt(array $credentials = [], $remember = false, $login = true);
public function once(array $credentials = []);
public function logout();

/*
<<<<< NEW WAY >>>>>
- this command ads all the routes
>> ALERT <<
	- route:list - does not display the names of login & register routes (but they do work)
	- to access page go to /public/login
*/
Auth::routes();
/*
Force change name of the route (OPTIONAL)
> use if name does'not show in routes:list
- name of route is -> 'login'
- controller uses -> 'Auth\AuthController@getLogin'
*/
Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);

/*
<<<<< OLD WAY >>>>>
- this adds all the routes individualy
ALERT (to access page go to /public/auth/login)

1) Add new routes 
- use built in routes
A.1) LOGIN > get data
	> get method
	> default route auth/login
	> sent to controller -> 'Auth\LoginController@getLogin'
	> sent to (name of the action) -> login.blade.php
A.2) LOGIN > submit
	> post method
B.1) LOGOUT > get data (no need to post here)
	> get method
	
C.1) REGISTER > submit
	> get method

*/
/*Login / Logout*/
Route::get('auth/login', 'Auth\LoginController@getLogin');
Route::post('auth/login', 'Auth\LoginController@postLogin');

Route::get('auth/logout', 'Auth\LoginController@getLogout');

/*Register*/
Route::get('auth/register', 'Auth\RegisterController@getRegister');
Route::post('auth/register', 'Auth\RegisterController@postRegister');


/*
2) Create files & filders in resources > views
- create auth folder & inside 3 files: login, register
- form field names must correspond to the column names in our database
*/
/*LOGIN*/
{!! Form::open() !!}
	{{ Form::label('email', 'Email:') }}
	{{ Form::email('email', null, array('class' => 'form-control')) }}
	{{ Form::label('password', 'Password') }}
	{{ Form::password('password', array('class' => 'form-control')) }}
	<br>
	{{ Form::checkbox('remember') }}{{ Form::label('remember', 'Remember Me') }}
	<br>
	{{ Form::submit('Login', array('class' => 'btn btn-primary btn-block')) }}
{!! Form::close() !!}

/*REGISTER*/
{!! Form::open() !!}
	{{ Form::label('name', 'Name:') }}
	{{ Form::text('name', null, array('class' => 'form-control')) }}
	{{ Form::label('email', 'Email:') }}
	{{ Form::email('email', null, array('class' => 'form-control')) }}
	{{ Form::label('password', 'Password') }}
	{{ Form::password('password', array('class' => 'form-control')) }}
	{{ Form::label('password_confirmation', 'Confirm Password') }}
	{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
	<br>
	{{ Form::submit('Register', array('class' => 'btn btn-primary btn-block')) }}
{!! Form::close() !!}


/*
3) Test Login / Logout
	a) add if to main template
	b) register (/public/register)
		- should redirect you to homepage & display message Logged In!
	c) logout (/public/logout)
		- should redirect to homepage & display message Logged Out!
	d) check login (/public/login)
	e) as you are logged in test if the page throws you out of register (/public/register)
* in login & register controller you can change page where to redirect to after success
*/
@if (Auth::check())
	Logged In!
@else
	Logged Out!
@endif


/*
4) Give access to pages only to registered users 
- in the past we created BlogController (with pages for public) & PostController (with pages for registered users), 
now we want to restrict access to PostC...
*/
/*
PostController
> at top of class add this function
	- allow access to registered users ('auth')
	- allow acces to all/guests ('guest')
	- if you want couple of methods (functions) available to all
*/
public function __construct() {
	$this->middleware('auth');
}

public function __construct() {
	$this->middleware('guest');
}

public function __construct() {
	$this->middleware('guest', ['except' => 'index']); // if more add in array = ['index', 'store', 'update']
}


/*
5) Setup navigation bar to show options only if you are logged in
- Auth::check() - checks if you are logged in
- watch out for routes list
- set logout route
- add Hello <user_name> ( if you want email {{ Auth::user()->name }} )
*/
<ul class="nav navbar-nav navbar-right">
	@if (Auth::check())
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello {{ Auth::user()->name }} <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="{{ route('posts.index') }}">Posts</a></li>
				<li><a href="#">Another action</a></li>
				...
				<li><a href="{{ route('logout') }}">Log Out</a></li>
			</ul>
		</li>
	@else
		<a href="{{ route('login') }}" class="btn btn-default">Login</a>
	@endif
</ul>
?>

<?php
/**
 * Or not to show button if user is not authentificated
 */
@if (!Auth::guest())
	<a href="/posts/{{ $post->id }}/edit">Edit</a>
@endif


/**
 * See only your own posts
 */
@if (Auth::user()->id == $post->user_id)
	<a href="/posts/{{ $post->id }}/edit">Edit</a>
@endif