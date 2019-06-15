<?php 
/*

!! INTER - SESSIONS - and FLASH messages !!

> session lasts 2 hours, after that browser thinks it is a new session
> you can store sessions in the database

- configure sessions
	config > session.php
	-> change session lifetime depending on usage - default if 2 hours, usually 30 minutes is ok
	-> you can encrypt cookies
	
- FlASH session 
	-- is a session that only exists for the news request
	-- stored in session variables
	-- great for displaying alert messages on the next page
	
EXPLAIN ONE MORE TIME:
> Flash exists for one page request
> Put exists until the session is removed

INSTRUCTIONS:
1) Declare session (flash / put)
2) Use session
3) in view pull the session & display it to our user (set up show.blade.php with the text to display)
4) in main.blade.php set space below navigation to display messages for all the pages
5) create _message.blade.php
6) !! MAYBY NOT NEED - mess with routes > api.php - middleware !!
	- code that is runs when something is sent to the route but before it gets to the controller
	- visual representation
		STANDARD PATH
		Route::get('about', 'PagesController@getAbout'); - go to the route, than go to the controller 
		MIDDLEWARE PATH
		Route::get('about', 'Middleware', 'PagesController@getAbout'); - go to the route, go to the middleware, go to the controller
		** GOOD **
			> for things like authentification... explore more usage
		
		https://www.youtube.com/watch?v=-FMecyZs5Cg&list=PLwAKR305CRO-Q90J---jXVzbOd4CDRbVx&index=15

Display error messages
> in our post controller validate automatically submits errors back to the same request (on the same page)
> if validate fails it automatically adds message errors to flash session
	- creates error object with multiple errors inside
7) in _messages.blade.php create code for errors
	
/*
PostController
- create flash messages notifying if the post is saved to the database or not
1)
*/
/*after we save post data $post->save(); before redirect page*/
Session::flash('key', 'value');
/*Example*/
Session::flash('sucess', 'The blog post was successfully save!');
/*If you want something put permanenty for 120 minutes (session time)*/
Session::put('sucess', 'The blog post was successfully save!');

/*
2)
*/
use App\Http\Requests;
use App\Post;
use Session; // use session

/*
3) 
*/
@section('content')
    <p>This is the Blog Post</p>
@endsection

/*
4)
*/
@include('partials._messages')

/*
5)
- universal for sucess messages
- blade session with @if & @endif
- Session::has('success') -> in php isset($_SESSION['success'])
*/
@if (Session::has('success'))
	// Use bootstrap alert
    <div class="alert alert-success">
		/*Pulls success message out of the session*/
        <strong>Success!</strong> {{ Session::get('seccess') }}
    </div>
@endif

/*
7)
- if error count is greater than 0
- loop the errors - foreach - display as list items
- call method all for errors $errors->all()
*/
@if (count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <strong>Errors:!</strong>
		<ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
?>