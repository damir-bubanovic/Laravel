<?php 
/*

!! INTER - AUTHENTIFICATION - RESET PASSWORD EMAIL !!

> password resets theory
	- if you forgot your password than enter email adress in field & web site automatically
	sends an authentification email with random generated token. When you click the link with 
	email it compares tokens & you go to form to reset your password

*/

/*
OLD WAY

1) ROUTES
Password Reset Routes
	A) when it generates the token it automatically adds the token to password/reset & that is how we identify someone
	is identified by email
		> ? is because not every time a person will have a token (? indicates this is optional, in our case token is optional)
		> we are basicly creating 2 urls ( password/reset & password/reset/anynumber )
	B) password/email - triggers off the email
	C) when someone postst to 'password/reset'
*/
Route::get('password/reset/{token?}', 'Auth\PasswordController@showresetForm')
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail')
Route::post('password/reset', 'Auth\PasswordController@reset');

/*
2) Set views
- create folder password & put inside 2 file: email & reset
	E) email.blade.php  	- first form we see when we click forgot my password & enter email adress
						- this will trigger email to be sent to inbox with special url with token
						- when you click the token it will trigger reset.blade.php
	F) reset.blade.php 	- form where you reset your password
						- you have password & password confirmation field
*/
/*
E) hidden token field - pass in $token that has 2 variables into view ( token & email )
*/
| Forgot My Password

<div class="panel panel-default">
	<div class="panel-heading">Reset Password</div>
	@if (session('status'))
		<div class="alert alert success">{{ session('status') }}</div>
	@endif
	<div class="panel-body">
		{!! Form::open(['url' => 'password/email', 'method' => 'POST']) !!}
			{{ Form::label('email', 'Email Address:') }}
			{{ Form::email('email', null, ['class' => 'form-control']) }}
			{{ Form::submit('Reset Password', ['class' => 'btn btn-primary']) }}
		{!! Form::close() !!}
	</div>
</div>

/*
F) 
*/
| 

<div class="panel panel-default">
	<div class="panel-heading">Reset Password</div>
	<div class="panel-body">
		{!! Form::open(['url' => 'password/reset', 'method' => 'POST']) !!}
			{!! Form::hidden('token', $token) !!}
			{{ Form::label('email', 'Email Address:') }}
			{{ Form::email('email', $email, ['class' => 'form-control']) }}
			{{ Form::label('password', 'New Password') }}
			{{ Form::password('password', ['class' => 'form-control']) }}
			{{ Form::label('password_confirmation', 'Confirm New Password') }}
			{{ Form::password('password_confirmation', ['class' => 'form-control']) }}
			{{ Form::submit('Reset Password', ['class' => 'btn btn-primary']) }}
		{!! Form::close() !!}
	</div>
</div>


/*
3) create new folder emails > password.blade.php
- this is our email we are sending (we can create entire email here) - here we have a very basic version
- look up regarding this $link
*/
Click here to Reset your Password: <br>
<a href="{{ $link = url('password/reset', $token) . '?email=' . urlencode($user->getEmailForPasswordReset()) }}">{{ $link }}</a>


/*
4) Add link to login page - forget my password
*/
<p><a href="{{ url('password/reset') }}">Forgot Password</a></p>


/*
5) Set up Testing Email sending
> tinkle with .env (file)
	- senting emails in various ways: use different api-s (Amazon SMS, Mandril, MailGun, SendGrid)
	- Laravel uses library called SwiftMailer (great for PHP) / smtp
	- look up <smtp> setting for whatever email provider I have (for CROATIA), you can use gmail
	- we are goint to set up for Gmail
	-> mayby use Mailtrap service (instead of Gmail - look it up) - safe email testing
*/
/*GMAIL*/
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=25
MAIL_USERNAME=myemailadress@gmail.com
MAIL_PASSWORD=mypassword
MAIL_ENCRYPTION=tls
/*!!in my google email setting I will have to allow less secure apps to access my gmail (mayby - in development faze for sure)!!*/

/*
6) set default sending email adress
- config > mail.php
- tinker with - Global "From" Address
*/
'from' => [
	'address' => 'damir.bubanovic@gmail.com',
	'name' => 'Damir Laravel',
],
/*
7) RESET SERVER TO WORK
- because we changed the .env file we have to restart the server for changes to take effect
*/
Restart Wamp

/*
8) Look up rest of the video
https://www.youtube.com/watch?v=duMmNEJEZCw&list=PLwAKR305CRO-Q90J---jXVzbOd4CDRbVx&index=35
*/

/*
9) add flash messages to notify user
- added above
*/
@if (session('status'))
	<div class="alert alert success">{{ session('status') }}</div>
@endif

/*
10) Change page we land on after changing password
- in Password Controller
*/
use ResetsPasswords; // under this type
protected $redirectTo = '/'; // redirect to root, to login-ed starting page
?>
