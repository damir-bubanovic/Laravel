<?php 
/*

!!!! BASIC - CSS - styling !!!!

1) install node.js to your computer
	- default folder c:\Program FIles\nodejs
2) install node.js plugin in PhpStorm
	- settings > languages & framework > node.js and npm
		- node interpreter -> C:\Program Files\nodejs\node.exe
	Check that node & npm are installed, type in console
	node -v (now 4.6.0)
	npm -v (now 2.15.9)
***EXTRA***
	1) jednom sam disablao resources > assets > sass
		//@import "node_modules/bootstrap-sass/assets/stylesheets/bootstrap";
	2) jednom sam instalirao settings > languages & framework > node.js and npm > npm (double click - install)
		*plavi je npm među svim paketima tako da je možda već prije instaliran
	*** pošto mi je node.js u c: a ne u wampu (gdje se laravel) možda moram Configure Node.js Remote Interpreter 




*/

/*
LINK CSS via BLADE Syntax
*/
<!-- Custom CSS -->
{{ Html::style('css/styles.css') }}

?>