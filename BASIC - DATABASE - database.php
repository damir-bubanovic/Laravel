<?php 
/*

!!!! BASIC - DATABASE - configure database settings !!!!

> change values in the .env file not config > database.php for connection variables

- check out this cool thing:
	database > migrations > php files (2 database files)
	*If you want to create / drop / update database from phpstorm you can do it from the console CTRL + X*
	
(*CREATE TABLE > MYSQL*) artisan - migrate -> create tables in database migrate folder


*** ALERT ***
	- check out options for migrate & creating tables because it 
	does not create a very good table
	- it creates default table migrations - DON'T MESS WITH THAT

- check out app > user.php	(connected with 2 database files)

*/


/*

!!!! BASIC - DATABASE - create new table !!!!

CREATE NEW TABLE for migrations
(*CREATE TABLE > PHPSTORM*) artisan make:migration create_blogs_table
	*it gives us starting point for table creation with function up() & down()
	
*** ALERT ***
	- all the options are at https://laravel.com/docs/5.3/migrations
	
EXAMPLE;
> blogs - name of table
> Blueprrint $table - callback function

(*ROLLBACK TABLE > MYSQL*) artisan migrate:rollback -> delete tables to startin point (only migrations table present)
	- after this use artisan migrate to populate tables to mysql
*/
	public function up()
    {
        Schema::create('blogs', function(Blueprint $table) {
            $table->increments('id'); /*Always have these columns in table*/
			$table->string('title');
            $table->string('text');
            $table->timestamps(); /*Always have these columns in table - adds created at & updated at(timestamp)*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blogs');
    }

	
	
/*

!!!! BASIC - DATABASE - update tables !!!!

(*REFRESH TABLE > MYSQL*) artisan migrate:refresh - delete (rollback) & upload (migrate) table data at the same time


> next medel of blogs table so we can create more couple more fileds??
(*MODEL TABLE*) artisan make:model - creates model in app > ... Blog.php

> add entrys into database table
(*ADD DATA TABLE > MYSQL*) artisan tinker


*/
?>