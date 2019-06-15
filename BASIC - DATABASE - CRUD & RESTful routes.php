<?php 
/*

!! BASIC - CRUD & RESTful Routes !!

> creating controllers for starter

THIS CREATES OPERATIONS FOR CRUD
> cannot create --resource controller (CRUD controller) so copy inside code
	** https://scotch.io/tutorials/simple-laravel-crud-with-resource-controllers **
	
> after this create routes (very simple)

*/

/*
ROUTES
1) resource - with this we create routes for all the function we have in PageController.php, 
no need for each function for get or post
2) url at start & then name of the controller

> ALERT <
	To see if you configured correctly type Laravel Artisan 5: route:list
	(should list all the routes)
*/
Route::resource('posts', 'PostController');


?>