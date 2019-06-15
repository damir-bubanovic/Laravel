<?php
/**
 * ULTRA - GOOGLE MAPS - GET KML DATA & STORE IT TO DATABASE
 *
 * > get latitude, longitude & elevation
		- https://github.com/alexpechkarev/google-maps CUSTOM API
 * > don't forget to link public / storage folder with storage / app / public folder
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FileController extends Controller
{
    public function show() {

        /*
		SIMPLE
		> ALERT -> this only works if the uploaded file is .xml
			$file = $request->file('file');
            $fileStored = Storage::disk('public')->put('uploads', $file);
		*/
		/**
         * Get Coordinates from .gpx file
		 * > load file (converts xml file to object)
         * > foreach loop to cycle through data
		 * > get elevation data - & round altitude number
         * > unload file
         */
		 
		/*ALERT*/
		$file = Storage::disk('public')->get($request->route['routeFile']);
        $XMLfile = simplexml_load_string($file);
		
		 
        $file = simplexml_load_file('storage/route.gpx');

        foreach($file->trk->trkseg->trkpt as $coordinate) {			
			$longitude = $coordinate['lon'];
			$latitude = $coordinate['lat']
			
			$elevation_data = \GoogleMaps::load('elevation')
                ->setParamByKey('locations', $longitude . ',' . $latitude)
                ->get();

            $elevation_json = json_decode($elevation_data);
            $altitude_decimal = $elevation_json->results[0]->elevation;
            $altitude = round($altitude_decimal);

            $gps_route = DB::table('routes_gps')
                        ->insert([
                            'route_id'          =>  $route_id,
                            'longitude'         =>  $longitude,
                            'latitude'          =>  $latitude,
                            'altitude'          =>  $altitude,
                            'created_at'        =>  $now,
                            'updated_at'        =>  $now
                        ]);

        }
        unset($xml);
		
		
		/*
		SIMPLE
		> ALERT -> this only works if the uploaded file is .xml
			$file = $request->file('file');
            $fileStored = Storage::disk('public')->put('uploads', $file);
		*/
		/**
         * Get Coordinates from .kml file
         * 1) load file from storage as xml file
         * 2) target coordinates container & get coordinates data
         * 3) coordinates
         *     > remove \n - new line from text
         *     > trim whitespace from start
         *     > remove ending characters ( 0  )
         * 4) create array data with explode
         */
		
		/*ALERT*/
		$file = Storage::disk('public')->get($request->route['routeFile']);
        $XMLfile = simplexml_load_string($file);
		
		
        $file = simplexml_load_file('storage/staza23.kml');
        $coordinates_string = $file->Document->Placemark->LineString->coordinates;
        $coordinates_clean = preg_replace('/\n/', '', $coordinates_string);
        $coordinates_cleaner = trim($coordinates_clean);
        $coordinates_cleanest = substr($coordinates_cleaner, 0, -2);
        $coordinates = explode(',0 ', $coordinates_cleanest);

        /**
         * 5) loop through all coordinates & get combined long & lat values
         * 6) create single coordinates data from individual values
         * 7) define longitude & latitude
         */
        foreach ($coordinates as $value) {
            $coordinate = explode(',', $value);
            $longitude = $coordinate[0];
            $latitude = $coordinate[1];

            $elevation_data = \GoogleMaps::load('elevation')
                ->setParamByKey('locations', $longitude . ',' . $latitude)
                ->get();

            $elevation_json = json_decode($elevation_data);
            $altitude_decimal = $elevation_json->results[0]->elevation;
            $altitude = round($altitude_decimal);

            $gps_route = DB::table('routes_gps')
                        ->insert([
                            'route_id'          =>  $route_id,
                            'longitude'         =>  $longitude,
                            'latitude'          =>  $latitude,
                            'altitude'          =>  $altitude,
                            'created_at'        =>  $now,
                            'updated_at'        =>  $now
                        ]);
        }
		
        unset($file);
		
		
		
		/*
		COMPLEX
		*/
		
		/**
         * GPS Coordinates Custom Function
         * > Get Gps Coorinates located between tags <coordinates>
         */
        function getTextBetweenTags($string, $tagname) {
            $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
            preg_match($pattern, $string, $matches);
            return $matches[1];
        }

        /**
         * File Conversion KML
         * 1) get file from storage
         * 2) remove new line from file
         * 3) gps_container_dirty
         *     > get data between tags <coordinates>
         * 4) gps_container_cleanest
         *     > Remove '0 ' patern from container_dirty
         *     > Remove whitespace from start
         *     > Remove , from end
         * 5) coordinates string to array
         * 6) create coordinate lat lng groups
         */
        $file = Storage::get('public/staza.kml');
        $file_clean = trim(preg_replace('/\s+/', ' ', $file));
        $gps_container = getTextBetweenTags($file_clean, "coordinates");
        $gps_container_clean = preg_replace('/[0]\s+/', '', $gps_container);
        $gps_container_cleaner = trim($gps_container_clean);
        $gps_container_cleanest = substr($gps_container_cleaner, 0, -1);
        $coordinates = explode(',', $gps_container_cleanest);
        $coordinate_pairs = array_chunk($coordinates, 2);

        $now = Carbon::now();
        $route_id = 1;
        /**
         * 8) Cycle through array & determine longitude & latitude
         *     - custom Google Maps API package for Laravel
         *     > find elevation (longitude = $value[1] / latitude = $value[0])
         */
        foreach ($coordinate_pairs as $value) {
            $elevation_data = \GoogleMaps::load('elevation')
                ->setParamByKey('locations', $value[1] . ',' . $value[0])
                ->get();

            $elevation_json = json_decode($elevation_data);
            $altitude_decimal = $elevation_json->results[0]->elevation;
            $altitude = round($altitude_decimal);

            $gps_route = DB::table('routes_gps')
                        ->insert([
                            'route_id'          =>  $route_id,
                            'longitude'         =>  $value[1],
                            'latitude'          =>  $value[0],
                            'altitude'          =>  $altitude,
                            'created_at'        =>  $now,
                            'updated_at'        =>  $now
                        ]);
        }
		
		
		
		/**
         * AlTERNATIVE
         * > if simplexml_load_file does not work
         * > !! Must have custom folder in public folder !!
         */
        $GPSfile = 'upload/staza.kml';

        if (file_exists($GPSfile)) {
            $file_contents = file_get_contents($GPSfile);
            $file = simplexml_load_string($file_contents);
            /*
            $coordinates_string = $file->Document->Placemark->LineString->coordinates;
            $coordinates_clean = preg_replace('/\n/', '', $coordinates_string);
            $coordinates_cleaner = trim($coordinates_clean);
            $coordinates_cleanest = substr($coordinates_cleaner, 0, -2);
            $coordinates = explode(',0 ', $coordinates_cleanest);
            */
            $coordinates_string = $file->Document->Placemark->LineString->coordinates;
            $coordinates_clean = preg_replace('/\n/', '', $coordinates_string);
            $coordinates_cleaner = trim($coordinates_clean);
            $coordinates_cleanest = substr($coordinates_cleaner, 0, -2);
            $coordinates = explode(',0 ', $coordinates_cleanest);

            return dd($coordinates);

        } else {
            return 'Failed to open file';
        }


    }

}