<?php 
/*

!! INTER - FORMS - CONTACT - SEND EMAIL !!

> use mail class
	- it is built upon php library SWIFT MAILER
	- swiftmailer comes preinstalled on laravel

> send mail either through SMTP or API
		- if you have thousands of users use API to send emails
		
> look up sending main documentation in laravel

*/
/*
1) config > mail.php
- add changes to: driver, host, port, default email address, username & password
2) .env
- add changes to all the neccessary elements in MAIL_...
*/

/*
3) setup route - to go to contact form & submit/send email
*/
Route::get('contact', 'PagesController@getContact');
Route::post('contact', 'PagesController@postContact');

/*
4) setup methods for PagesController
- do not forget to call the request in your namaspace / use
- instead fo Mail::send() for lots of emails you can use Mail::queue() - npr. in e-commerce
- Mail::send()
	> view - own folder & files, for e-commerce sites it can have emails, notifications, newsletter, receits...
	> $data - it has to be passed as an ARRAY - you have to manually compile & pass in the information from the 
	request into array
		>> tricky to pass 'message' because it is reserved! variable! in laravel
		>> $data - every single key of $data in Laravel becomes it's own variable & to access it
		we simply use $varName ($email, $subject, $body_message)
	> inside function you can have as well: cc, bcc, attachment...
	> with use($data) we can have acces to $data[] items
*/
public function getContact() {
	return view('pages.contact');
}

public function postContact(Request $request) {
	$this->validate($request, array(
		'email' => 'required|max:255',
		'subject' => 'required|min:3',
		'messsage' => 'required|min:10'
	));
	
	$data = [
		'email' => $request->email,
		'subject' => $request->subject,
		'body_message' => $request->message
	];
	
	Mail::send('emails.contact', $data, function($message) use($data) {
		$message->from($data['email']);
		$message->to('mirko@gmail.com');
		$message->subject($data['subject']);
	});
}

/*
5) setup contact form if neccessary
- do not forget to settup method if necccessary
*/
// <form action="{{ url('contact') }} method="POST">


/*
6) create basic hmtl email
*/
<h3>You have a New Contact Via the Contact Form</h3>

<div>
    {{ $bodyMessage }}
</div>

<p>Sent via {{ $email }}</p>


/*
7) CSRF field - if setting up mail manually you have to have CSRF field / token inside contact form
*/
{{ csrf_field() }}


/*
8) if using mail do not forget namespace use mail in Controller
*/
use Mail;

?>