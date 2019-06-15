<?php
/*

!! BASIC - MODEL-VIEW-CONTROLLER !!

- usually you are only working in these fields in laravel

	* MODEL 		(represents -> Database [stores information])
		> STORED -> app > User.php(basic)
	
	* VIEW 			(represents -> Client/Browser [show information])
		> STORED -> resources > views > welcome.blade.php(basic)
	
	* CONTROLLER	(represents -> Server [process information])
		> STORED -> app > Http > Controllers > controller.php(basic)
	
	* (EXTRA) Routes (where to expect & get url)
		> STORED -> routes > web.php(basic)
	
	* (EXTRA) Configuration file
		
*/


/*
MODEL:
> add & retrive items from database
> process data from or to database
> speaks only with the controller

VIEW:
> only thing the user ever sees
> HTML & CSS
> speaks (only listenes) only with the controller

CONTROLLER:
> process GET/POST/PUT/DESTROY requests
> all server-side logic
> the middle man
*/


?>