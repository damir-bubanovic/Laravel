<?php 
/*

!! INTER - AUTHENTIFICATION - THEORY & OVERVIEW !!

*/

/*
THEORY & OVERVIEW

> look up advanced features

THINGS TO DO:
- roles - npr.admin, manager, employee, visitor...
- social authentification (via Twitter, Facebook...)
- password resets
* we are accassing database (user/password) every single page to see if you are logged in or not

FUTURE THINGS
- confirming the account
- salt & hash

*/

/*
OTHER
(1)
- database > migrations > create_users_table.php
> remember token is a hash value that gets stored in database, when you click remember me on the website, a cookie with 
the same has value gets stored on your browser. Next time you want to log in, web site checks do hashes match & if they do
you can automatically log into page
(2)
- password resets goes like this - if you forgot your password than enter email adress in field & web site automatically
sends an authentification email with random generated token. When you click the link with email it compares tokens & you
go to form to reset your password
*/
/*(1)*/
Schema::create('users', function (Blueprint $table) {
	...
	$table->rememberToken();
	...
});

/*(2)*/
Schema::create('password_resets', function (Blueprint $table) {
	...
});

?>