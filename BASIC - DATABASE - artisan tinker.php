<?php 
/*

!!!! BASIC - DATABASE - artisan tinker !!!!

> add entrys into database table
(*ADD DATA TABLE > MYSQL*) artisan tinker

*** ALERT ***
	This only works if you write directy into console after >>>
*/
/*Creates new Blog Object*/
$blog = new App\Blog;

/*Creates values for database columns*/
$blog->title = 'My First Blog';
$blog->body = 'My first blog from a laravel site';

/*Checks data entries is created*/
$blog->toArray();

/*Saves data to database*/
$blog->save();


/*
ELOQUENT SYNTAX - to manupulate data
*/
/*Returnes data from database in array*/
App\Blog::all()->toArray();

/*Finds in database table blog entry with id 3*/
$blog = App\Blog::find(3);

/*Find in database table blog entry with specific title*/
$blog = App\Blog::where('Title', 'My Second Blog Entry');

/*Find in database table blog entry with specific title & return method*/ 
$blog = App\Blog::where('title', 'My First Blog')->get(); 

/*Create new entry in database*/
$blog = App\Blog::create(['title' => 'Third Entry', 'body' => 'I am having a lot of fun with this']);
/*Before creating new entry change Blog.php*/
class Blog extends Model
{
    /*Set up which columns can be mass assigned - so people cannot change npr. id or timestamp, & so people cannot
	mass asign multiple columns - with this we are enabling mass asign with object([]) multiple columns in single row*/
	protected $fillable = [
        'title',
        'body'
    ];
}
/*Mayby you will have to restart tinker for this to work*/

/*UPDATE COLUMN*/
/*Update the column title of the latest table entry*/
$blog->update(['title' => 'What I have been up to lately']);


?>