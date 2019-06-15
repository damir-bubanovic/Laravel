<?php 
/*

!!!! BASIC - CONTROLLERS - PASS DATA TO VIEW !!!!

> for dynamically displaying content 
>> ALERT <<
	- function name should get depending of the action it performs GET, POST, DELETE, PUT

*/

/**
 * Make Everything for Controller & Routes
 * > this give every method (show, edit, delete, index...)
 * > create all the routes in routes file
 */
php artisan make:controller PostsController --resource

Route::resource('posts', 'PostsController');


/*
BASIC
- namespace -> access something inside folder
- use -> access something outside folder
*/
<?php

namespace App\Http\Controllers;	// You belong in this folder (you can change that)

use Illuminate\Http\Request;	// access outside

use App\Http\Requests;	// access outide

class PagesController extends Controller
{
    public function getIndex() {	// Look up ALERT > function name
		/*
		WE CAN DO ALL SORTS OF THINGS HERE
		* process variable data or params
		* talk to the model (database)
		* receive from the model
		* compile & process data again
		* pass that data to the correct view
		*/
		return view('welcome');
	}
}



/*
1) METHOD - with() - single & multiple  variable
- in controllers
*/
class PagesController extends Controller
{
    public function contact() {
        $name = 'Mike';
		$location = 'USA';
		/*$name maps to 'name'*/
        return view('contact')->with('name', $name)->with('location', $location);
		
		/*Simpler Compact passing multiple variables*/
		return view('contact', compact('name', 'location'));
		
		/*Cool passing*/
		return view('contact')->withName($name)->withLocation($location);
    }
	
	public function getAbout() {
    	$firstName = 'Marko';
    	$lastName = 'Markovic';

    	$full = $firstName . ' ' . $lastName;
    	/*create variable fullname & set it to variable full*/
    	return view('pages.about')->with('fullname', $full);
		/*simpler way - same thing (even thou we have a capital letter withFullname, we access it below with lowercase)*/
		return view('pages.about')->withFullname($fullname);
		
		
    }
	
	public function getAbout() {
    	$firstName = 'Marko';
    	$lastName = 'Markovic';
        $email = 'marko@gmail.com';
		/*set data into array & pass it along*/
        $data = [
            'firstname' => $firstName,
            'lastname'  => $lastName,
            'email'     => $email
        ];
        return view('pages.about')->withData($data);
    }
	
	/*
	STRUCTURE POSITION OF VIEW EXAMPLE
	1) views > welcome.blade.php
	2) views > pages > welcome.blade.php (/ - more in spirit of Procedural)
	3) views > pages > welcome.blade.php (. - more in spirit of OOP)
	*/
	public function() {
		return view('welcome');
		return view('pages/welcome');
		return view('pages.welcome');
	}
}
/*
1) METHOD
- in views
- {{ }} - this is blade syntax
*/
<p>Contact Page for {{ $name }} from {{ $location }}</p>
/*this is like saying*/
?>
<p>Contact Page for <?php print $name;?></p>

/*Do not render literally, render this as it is a variable*/
<h1 class="text-center">About {{ $fullname }}</h1>

/*Show array data*/
<h1 class="text-center">About {{ $data['firstname'] }} {{ $data['lastname'] }}</h1>
<p class="text-center">Contact me at - {{ $data['email'] }}</p>


<?php

/**
 * Simple
 */
public function index() {
	$title = 'Welcome to Laravel';
	return view('pages.index')->with('title', $title);
}

@section('content')
	<h1>{{ $title }}</h1>
	<p>This is Laravel aplication from Youtube</p>
@endsection


public function services() {
	$data = array(
		'title'	=>	'Services Page'
	);
	return view('pages.services')->with('data', $data);
}

@section('content')
    <h1>{{ $data['title'] }}</h1>
    <p>This is Laravel Services</p>
@endsection
