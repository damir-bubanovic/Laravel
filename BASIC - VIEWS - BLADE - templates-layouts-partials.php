<?php 
/*

!! BASIC - BLADE -> templates, layouts, partials !!

1) LAYOUTS 		-> each (most) pages have the same structure npr. doctype, header, footer, nav, copywright
				-> make repetitive websites easier to work with (DRY - don't repeat yourself)
 
2) TEMPLATES 	-> 

3) PARTIALS 	-> extract further content of our web page, even more than layouts
				-> extract code to it's own file for repeation or organization (much more for organization)

*/




/*
1.1.)
- usually create main or master.blade.php in views folder
- extract all repetitive elements from pages
@yield - this thing (content) is added prom other pages into master.blade.php
	(The rest of the code is the same for all pages)
- @yield('content'), name it what ever you like -> @yield('cat'), @yield('sidebar'), @yield('marks')
*/
/*1) main.blade.php*/
<div class="container">
    @yield('content')
</div><!-- END of .container -->


/*
1.2.) 
- welcome.blade.php
- located in views > pages (folder)
- you can have 2 or more sections in file - * if there is nothing it will ignore it! *
	> commonly used when you want to load extra css or js for special purposes npr. 1.3.)
*/
@extends('main') // location of the layout file main.blade.php (if in folder npr layouts than 'layouts.main')
@section('content') // everything inside section is part of 'content'
	<p>This is the content my the page</p>
@endsection


@section('sidebar')
	<p>Sidebar for all kinds of elements</p>
@endsection


/*
1.3.)
- main file for displaying
- tables file with special css - graph_css (inport/include file or write special rules in here)
- even thougt there is no graph_css section in there is does not produce error when loading other
pages, only displays those that have that section
*/
/*main.php*/
<html>
	// General Css files
	@yield('graph_css')
</html>

/*tables.php (pages folder)*/
@extends('main')

@section('graph_css')
	<link rel="stylesheet" type="text/css" href="styles.css">
@endsection

@section('graph_css')
	<p>Some text here goes & i show something here</p>
@endsection


/*
1.4.)
- another usage for dinamicly displaying title
*/
/*main.php*/
<title>Laravel Blog @yield('title')</title> // Change title for each page, diyplays in browser in tab window

/*contact.php*/
@section('title')
| Contact
@endsection




/*
3.1.)
- use for header, footer, navigation...
- when working with partials name file _filename npr. when working with head name it _head
- simple include (@yield works great with @include)
- better way to do it is to create folder partials & put files in there & inspect / view page source to see everything OK (3.2)
*/
/*main.blade.php*/
@include('_head')

/*_head.blade.php*/
// Head information with doctype & lang

/*3.2.)*/
@include('partials._head')

/*Example of file structure*/
views >
	pages >
		about.blade.php
		contact.blade.php
		welcome.blade.php
	partials >
		_copywright.blade.php
		_footer.blade.php
		_header.blade.php
		_nav.blade.php
	main.blade.php
?>