<?php 
/*

!! BASIC - MVP - SIMPLE !!

1) create Controller & add some methods
2) create all routes for TestController from its methods(functions)
3) create views in folder (V)
4) if you are using model npr Test.php - do not forget to include model to controller

*/
use App\Test;

class TestController extends Controller
{
    public function customA() {
        return view('tests.customA')->withPosts($posts);
    }

    public function customB() {
    	$firstName = 'Marko';
    	$lastName = 'Markovic';
        $email = 'marko@gmail.com';

        $data = [
            'firstname' => $firstName,
            'lastname'  => $lastName,
            'email'     => $email
        ];
        return view('tests.customB')->withData($data);
    }

}


Route::resource('test', 'TestController');


test (Folder)
	customA.blade.php (File)
	customB.blade.php (File)

?>
