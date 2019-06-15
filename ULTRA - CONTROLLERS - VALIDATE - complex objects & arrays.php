<?php
/**
 * ULTRA - CONTROLLERS - VALIDATE - COMPLEX OBJECTS & ARRAYS
 *
 * > locating elements position
 *     - $location = $request->location['element'];
 *     - print($location);
 *
 * COMPLEX DATA EXAMPLE (console.log)
	- Parent says finish: {
				"selected":7,"name":"etweer","long":54235,"lat":3452323,"startTime":"05:00","endTime":"09:00",
				"water":true,"food":true,"beds":4,"road":true,"macadam":false,"foot":true
			} 
	,also contact: [
		{"contact":"fdgh","email":"fdghdf","phone":"86789896"},
		{"contact":"bvnc","email":"vcnvb","phone":"907890890890"}
	]
 */


class TestingController extends Controller
{

    public function testing(Request $request) {

        /**
         * Verify Object inside Object (location.name = parent data)
         *
         * > locating elements position (key inside object inside array)
         *     - $location = $request->location['name'];
         *     - print($name);
         */
        $this->validate($request, array(
            'location.name'          =>  'required|string'
        ));

        $test = DB::table('testing')
                        ->insert([
                            'name'              =>  $request->location['name']
                        ]);

        return response()->json([
            'test'  =>  $test
        ], 200);


		/**
         * Verify Complex Object (contact...phone = contact data)
         *
		 *	=> VALIDATION all = * (no need for foreach or for loop)
         * > phone elements position (key inside object[all objects] inside array inside array)
         *     - $phone = $request->contact[0][1]['phone'];
         *     - print($phone);
		 *
		 * >> ALERT <<
				- no return response with this (for now)
         */
        $this->validate($request, array(
            'contact.0.*.contact' =>  'required|string',
            'contact.0.*.phone'   =>  'required|numeric'
        ));

		$data = $request->contact[0];

        $dataNumber = count($data);

        for($i = 0; $i < $dataNumber; $i++) {
            // print($data[$i]['email'] . "\n");
            $insertData = array(
                'contact'   =>  $data[$i]['contact'],
                'phone'     =>  $data[$i]['phone']
            );
            DB::table('testing')->insert($insertData);
        }

    }
}