<?php 
/*

!! INTER - URL - SLUGS - ADDING SLUGS !!

> PagesController.php is where all of our frontend stuff is going to be
	>> pro tip - do not have 1 controller for 1 item (useless)

*/


/*
1) add a column to our database to store slugs
- best way to do it is just make changes in the original table, lose data & move on (you are in development enviroment)
	- in production enviroment it gets FUCKED UP - ALERT!!!!
> create new migrations - add_slugs_to users
	>> we are creating new column in the existin create_posts_table.php (migration)
	>> unique index the slugs column - faster searches
	>> for OCD purposes add slug (new) column after body column
		!! TIP OF THE DAY !!
			- when you do something very often (100 / 1000 times a day) if is good to index it. You read faster, but you input
			a little bit more data into database
			- use it when you are searching, sorting columns...
			- do not add indexed willy nilly because it adds a lot of space
	
>> ALERT <<
	- if you are using SQLite database you have to tinker with your composer.json
		- put "doctrine/dbal" : "*" in require dev
	- update library => 1. composer self-update (few times a month), 2. composer update (do everything inside sites > blog folder)
		- composer update can take more than 5 minutes
		
>> ALERT <<
	When you run artisan migrate:rollback... you are deleting data & creating clean database
*/
/**
 * Run the migrations.
 *
 * @return void
 */
public function up()
{
	Schema::table('posts', function($table) {
		$table->string('slug')->unique()->after('body');
	});
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
	Schema::table('posts', function() {
		$table->dropColumn('slug')->unique()->after('body');
	});
}


/*
2) modify PostController.php & views > posts > create 
> for validation we need Alpha Dash - alows you alphanumeric characters as well as dashes & underscores
	>> order of the errors matter (logic is to catch the biggest errors first)
> we are testing unique
	>> unique inside posts table & we are testing slug column
	>> set it as last because this process is slower (others are very fast)
> we need slugs in create.blade.php (place slug between title & body)
*/
'slug'  =>  'required|alpha_dash|min:5|max:255|unique:posts,slug', // add to parsley validation, function store
$post->slugs = $request->slugs; // add to function store


{{ Form::label('slug', 'Slug:') }}
{{ Form::text('slug', null, array('class' => 'form-control', 'data-parsley-required' => '', 
'data-parsley-minlength' = '5', 'data-parsley-maxlength' => '255')) }}

/*
3) modify PostController.php & views > posts > show
> show.blade.php - only modified (we are just showing data, not adding it - like with create)
*/
<dl class="dl-horizontal">
	<dt>Url Slug:</dt> // get slug
	<dd>{{ $post->slug }}</dd>
	<label>Url:</label> // Or get URL
	<p><a href="{{ url($post->slug) }}">{{ url($post->slug) }}</a></p>
</dl>

/*
4) modify PostController.php & views > posts > edit
*/
{{ Form::label('slug', 'Slug:') }}
{{ Form::text('slug', null, array('class' => 'form-control')) }}

/*
5) modify PostController.php & views > posts > update
- modify validate because slug is unique
- sent slug input to database
*/
$post = Post::find($id);
// if input slug is the same as the slug from the database
if($request->input('slug') == $post->slug) {
	// validate data
	$this->validate($request, array(
		'title' =>  'required|max:255',
		'body'  =>  'required'
	));
} else {
	// validate data
	$this->validate($request, array(
		'title' =>  'required|max:255',
		'slug'  =>  'required|alpha_dash|min:5|max:255|unique:posts,slug', // add to parsley validation, function edit
		'body'  =>  'required'
	));
}

$post->slug = $request->input('slug'); // add to function edit

/*
6) modify routes > web.php (set new route)
> set route to specific url blog/{slug} - slug name
	- you can do multiple parameters for url Route::get('blog/{slug}/comments/{id}'); ...
> name the route - pass in values in array - single blog
> uses - where the you send it
> where() - define what kind of information can go in through the slug
	- in our case alphanumeric character that potencialy has a - or _
	- if it falls outside these parameters we don't accept it as route
	- enter regex
	- [\w\d\-\_]+ - any character, any number, -, _, +(how ever many after that)
*/
Route::get('blog/{slug}', array('as' => 'blog.single', 'uses' => 'BlogController@getSingle'))->where('slug', '[\w\d\-\_]+');

/*
7) create new controller BlogController (we are using this because down the road we may include comments)
- pass in new function
	> in function pass in the parameter {slug} = $slug
	> fetch data from db where 'slug' is equal to variable $slug (we are using query builder - look up laravel)
		>> we are using first() instead of get, because slug is unique, we do not have to loop results, first says get the
		first result & stop
- app use post, because we are using post
*/
public function getSingle($slug) {
	// fetch from database based on slug
	$post = Post::where('slug', '=', $slug)->get();
	// return the view & pass in the post object
	return view('blog.single')->withPost($post);
}

use App\Post;

/*
8) create blog folder & single.blade.php
- creative way to browser tab title as post title
- simple display blog title & text
*/
@section('title')
| {{ $post->title }}
@endsection

<h1>{{ $post->title }}</h1>
<p>{{ $post->body }}</p>

/*
9) link homepage posts with blog posts
- in welcome blade modify href of button Read More (create the correct url)
*/
<a href="{{ url('blog/ . '$post->slug) }}" class="btn btn-primary">Read More</a>
?>