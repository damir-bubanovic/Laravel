<?php 
/*

!! INTER - DATABASE - DATES - WORKING WITH THEM !!

> if you work with dates or compare dates is to convert data to Unix Timestamp (time is in seconds)!!
	>> use basic math commands to compare dates
	>> unix timestamp is a large integer, but our date time is stored in database in a string format

>> ALERT << 
	Look up carbon
	http://carbon.nesbot.com/docs/
	
*/

/*
> standard storing of time 2016-10-13 14:45:25 (YEAR-MONHT-DAY HOURS-MINUTES-SECONDS)
> our migration for database
> use strtotime() -> converts (time) string from our database (2016-10-13 14:45:25) & converts it to Unix timestamp
	>> unix timestamp = number of secconds that have passed since 1.jan.1970
*/
Schema::create('posts', function (Blueprint $table) {
	/*Creates Created & Updated timestamp fields in database*/
	$table->timestamps();
});

/*
Working with DATES (BLADE)
> get data from database - $post->created_at
> date - return a string formated by your specifications
> strtotime - convert string to Unix timestamp
> M j, Y h:ia - enter format we want between ''
*/
{{ date('M j, Y h:ia', strtotime($post->created_at) }}

?>