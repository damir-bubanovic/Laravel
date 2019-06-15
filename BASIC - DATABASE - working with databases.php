<?php 
/*

!! BASIC - DATABASE - WORKING WITH DATABASES !!


>> ALERT << 
	if the database is already set up (tables/columns..), you don't need migrations, unless you plan to 
	add something to the database, if not you only need a MODEL with witch to communicate to the database



1) create model -> Laravel Artisan 5: Create Model -> name will be Post
	app > Post.php
	
2) create migration -> Laravel Artisan 5: Create Migration -> name will be create_posts_table
	database > migrations > create_posts_table.php

3) Laravel Artisan 5: Migrate
	- when the tables (migrations) are ready put tables to database with this command
*/

/*
INTERESTING - Column Modifiers (MOST USED)
1) nullable -> if you are ok to have in a column null value (to be empty) add nullable 
	> npr. title is optional, do not throw an error if somebody does not give you a title
	> can be used for tags or something else
		$table->string('title')->nullable();
	
2) default value -> set default value if user has not inputed value with desired default value
		$table->string('title')->default('No Title Given');
		
3) unsigned -> integer cannot receive negative values npr. -24 (signed can have positive & negative values)
		$table->string('title')->unsigned();

4) after -> used for setting newly created columns after certain columns
		$table->string('title')->after('body');
*/

?>