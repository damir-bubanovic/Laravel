/**
 * INTER - CONTROLLER - CALL A FUNCTION FROM VIEW
 * > for formating phone number
 * 1) create helper file in app/Http/Helpers.php
 * 2) reference file in composer.json
 * 3) composer dump-autoload - to call this function from anywhere
 * 4) call function in view
 */


/**
 * formatPhoneNumber
 * @param  [type] $number [phone number]
 * @return [type]         [formated phone number by country & county extension]
 */
function formatPhoneNumber($number) {
	$croatia = substr($number, 0, 3);
	$county;
	$number;

	$detect_county_number = substr($number, 3, 1);

	if ($detect_county_number == 1) {
		$county = substr($number, 3, 1);
		$number = substr($number, 4);
	} else {
		$county = substr($number, 3, 2);
		$number = substr($number, 5);
	}

	return $croatia . ' ' . $county . ' ' . $number;
}



"autoload": {
    "files": [
        "app/Http/helpers.php"
    ],
    "classmap": [
        "database"
    ],
    "psr-4": {
        "App\\": "app/"
    }
},


<td>{{ formatPhoneNumber($ustanova[0]->TELEPHONENUMBER) }}</td>