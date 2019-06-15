<?php 
/*

!!!! BASIC - BLADE - syntax & more !!!!

> blade is very safe, it escapes dangerous tage, like script when processing

>> ALERT <<
	{{ $data }} - prints data
	{!! $data !!} - not printing data

*/

/*
MASTER PAGE - only create HTML template once (like php include)
> master layout page

1) create Layout folder in Resource > Views & put a file master.blade.php
4) yield section at specific plave you want
	-> you can have as many yields as you wish
*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

</head>

<body>

<div class="container">
	@yield('content')
</div>


</body>
</html>

<?php 
/*
INCLUDE PAGE - contact page
2) extends content of master page to contact page (views page)
3) create section to include (views page) to master
*/
@extends('layouts.master')

@section('content')
    <p>Contact Page</p>
@endsection /*or use @stop*/
?>

<?php 
/*
TAKE DATA FROM CONTROLLERS
> take data from custom variable from CONTROLLERS PAGE & send to VIEWS PAGE that sends to MASTER PAGE
*/
	public function contact() {
        $data = 'some random data<script>alert("you have been hacked");</script>';
        return view('contact', compact('data'));
    }



@extends('layouts.master')

@section('content')
    <p>Contact Page - {{ $data }}</p>
@endsection

?>

<?php 
/*
USING BLADE WITH JAVACRIPT LIBRARIES OR ANGULAR.JS
*/
{{ $data }} 	/*Blade syntax*/
@{{ $data }}	/*Angular or Javascrip library*/
?>

<?php 
/*
LOOPS
1) If / else
2) Unless - this is reverse if statement
3) foreach - create $people array in controllers & pass it to VIEWS PAGE ()
	> handy for getting information from a database
3.1) forelse - if there is no information returned
*/
@extends('layouts.master')

@section('content')
    @if($data)
        True
    @else
        False
    @endif
	
	
	@unless(1 == 2)
        This isnt true
    @endunless
	
	
	@foreach($people as $person)
        {{ $person }}
    @endforeach
	
	
	@forelse($people as $person)
        {{ $person }}
    @empty
        No one in list
    @endforelse
	
	
@endsection

?>

