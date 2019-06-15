<?php 
/*

!! INTER - FORMS - FUNCTION - JavaScript VALIDATE !!

> Javascript form validation is not necessary, and if used, it does not replace strong backend server validation

> use PLUGIN --- Parsley
	- is a form validation library
	** http://parsleyjs.org/ **
	DOWNLOAD:
	- JS file -> use minified version (standard download) -> save in public > js folder
	- CSS file -> on their page but, in future projects create your own -> save in public > css folder

> TIP <
	- Do not include this file to main.blade.php, but only on pages where you need form validation
	- This way you are reducing bloatingness of app
	> Do it with @yield on main.blade.php & @section on form.blade.php
	
See on the pages what you have to does
1) Download js file & configure css file
2) Setup blade files
3) Setup tags to work with form validator
*/

/*
SETUP BLADE FILES
main.blade.css
- custom library comes after the rest of crucial css & js files
*/
@include('partials._header')
@yield('stylesheets')

@include('partials._footer')
@yield('script')

/*
form.blade.php 
- we are using HTML helpers from LaravelCollective/Html
- watch out for the order so everything looks nice
*/
@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('script')
    {!! Html::script('js/parsley.min.js') !!}
@endsection


/*
SETUP TAGS
- setup tag to empty string!!!
*/
/*Setup validator to this form*/
{!! Form::open(['route' => 'posts.store', 'data-parsley-validate' => '']) !!}
/*Required fields*/
{{ Form::text('title', null, array('class' => 'form-control', 'data-parsley-required' => '')) }}
{{ Form::textarea('body', null, array('class' => 'form-control', 'data-parsley-required' => '', 'data-parsley-maxlength' => '255')) }}
?>