<?php 
/*

!! INTER - FORMS - FUNCTION - INSERT DATA & VALIDATE !!

> we have to store / insert data
> store action is coming in as post request -> @parem $request
	- pulls all  the data from the form that might have been submitted with the request
> take data, process it & store it

* automatically validates there is CSRF Protection (Cross Site forgery requests)

1) VALIDATE DATA
2) STORE DATA
	- no need for raw SQL code
	- work with model object & save it with methods
	- we created model before - app > Post.php
3) REDIRECT
4) USE POST MODEL

>> ALERT << 
	AVODI HAVING FORMS WITHIN FORMS IN LARAVEL
	
>> VALIDATE ALERT <<
	$post->name = $request->name; 		 IS EQUAL TO 		$post->name = $request->input('name');
*/


/*
LOOK UP VALIDATION RULES - https://laravel.com/docs/5.3/validation#available-validation-rules
COMMON:
> Accepted - yes or no - great for Terms of Service
> ActiveURL - valid url (quick DNS check - check the server)
> Alpha - characters must be alphanumerical characters
> Before & After(Date) > data is before or after present
> Boolean - true or false
> Integer - something is a whole number
> Unique - something is unique in the database (email adress)
> Required - somehting must be in the field (not null, not empty)
> Max - max amount of characters in a string
*/

/*POST MODEL*/
/* use App\Http\Requests; - after this */
use App\Post; // Add this - referes to - app > Post.php

/*
CONTROLLER - PostController
 * Store a newly created resource in storage.
 *
 * @param   Illuminate\Http\Request $request
 * @return 	Illuminate\Http\Response
 */
public function store(Request $request)
{
	// validate data - param: 1-request, 2-array(rules we want to validate against)
	$this->validate($request, array(
		/*Stacking rules with | (as many as you want) - title field is required & max character is 255*/
		'title' => 'required|max:255',
		'body'  =>  'required'
	));
	
	// store in database
	/*Create new instance of model (new post object) - we are always & only doing this in store method*/
	$post = new Post;
	/*Add thing to new instance of model - set post title & body to the title & body that came through our request*/
	$post->title = $request->title;
	$post->body = $request->body;
	/*Save data to database*/
	$post->save();
	
	// redirect to page
	/*Redirect to to view -> resources > views > posts > show.blade.php (name is from routes:list)*/
	/*You have to post id number to show specifi post -> route url is - posts/{posts} - grab id from post object*/
	return redirect()->route('posts.show', $post->id);
}


?>