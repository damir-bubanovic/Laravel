<?php 
/*

!! ULTRA - UPLOAD - FILES !!

> Token important that is sent to new page, see if it's neccessary with axios & vue

*/


/*Upload.blade.php*/
{!! Form::open(array('url' => 'store', 'files' => true)) !!}
	{!! Form::file('image') !!}
	{!! Form::token() !!}
	<br>
	{!! Form::submit('Upload') !!}
{!! Form::close() !!}



/*Controller*/
/**
 * LINKING PUBLIC FOLDERS
 * > it is important to link storage/app/public folder
 * with public folder(main folder)
 *     - php artisan storage:link (on command prompt)
 *     - this creates linked folder in public folder
 *     - REASON it is easier to link to files in public folder
 */

/**
 * Save Database
 * > when saving to database it is good to save size of file
 */

/**
 * Store File
 */
public function store(Request $request) {
	/**
	 * Save File
	 * > checking if request file is empty
	 */
	if($request->hasFile('image')) {
		/**
		 * Default File
		 */
		return $request->file('image');
		return $request->image->extension();
		return $request->image->path();
		/**
		 * Saving file in storage/app/public folder
		 */
		return $request->image->store('public');
		return Storage::putFile('public/new', $request->file('image'));
		/**
		 * Saving file with different name
		 */
		return $request->image->storeAs('public', 'myFile.jpg');
		/**
		 * Get File original name
		 */
		$fileName = $file->getClientOriginalName();
		/**
		 * Store file with specific name
		 */
		return $request->image->storeAs('public', 'bitfumes.jpg');
	} else {
		return 'No File Selected';
	}
}

/**
 * Display FIle
 */
public function show() {
	/**
	 * Return files in storage - public folder
	 * Return all files in storage - public folder
	 */
	return Storage::files('public');
	return Storage::allFiles('public');
	/**
	 * Make new directory
	 */
	return Storage::makeDirectory('public/make');
	/**
	 * Delete directory
	 */
	return Storage::deleteDirectory('public/make');
	/**
	 * Return file with specific name from storage
	 */
	return Storage::url('bitfumes.jpg');
	/**
	 * Returns actual image & displays it on screen
	 */
	$url = Storage::url('bitfumes.jpg');
	return "<img src='" . $url . "' />";
	/**
	 * Get the size of image
	 */
	return Storage::size('public/bitfumes.jpg');
	/**
	 * last modified
	 */
	return Storage::lastModified('public/bitfumes.jpg');
	/**
	 * Copy file from public folder to public root
	 */
	return Storage::copy('public/bitfumes.jpg', 'bitfumes.jpg');
	/**
	 * Move Image
	 */
	return Storage::move('public/bitfumes.jpg', 'bitfumes.jpg');
	/**
	 * Delete image
	 */
	Storage::delete('bitfumes.jpg');
}


/*Routes*/
Route::get('upload', 'UploadController@index');

Route::post('store', 'UploadController@store');

Route::get('show', 'UploadController@show');

?>