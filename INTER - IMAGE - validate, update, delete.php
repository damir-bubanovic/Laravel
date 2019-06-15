<?php 
/*

!! INTER - IMAGE - VALIDATE, UPDATE, DELETE !!

> look up Storage Fasade (built in laravel)
	- allows Add, Update, Delete files locally or remotely
	config > filesystems.php

*/

/*
CONFIG
*/
'local' => [
	'driver' => 'local',
	'root' => public_path('images/'),
],

/*
UPDATE
- in split second old & new files will exist, and than the old is deleted
*/
{{ Form::label('featured_image', 'Update Featured image') }}
{{ Form::select('featured_image') }}


$this->validate($request, array(
	'featured_image' => 'image'
));
/*Or*/
$this->validate($request, [
    'featured_image' => 'image'
]);

if ($request-hasFile(featured_image)) {
	// Add new photo
	$image = $request->file('featured_image');
	$filename = time() . '.' . $image->getClientOriginalExtension();
	$location = public_path('images/' . $filename);
	Image::make($image)->resize(800, 400)->save($location);

	$oldFilename = $post->image;
	// Update the database
	$post->image = $filename;
	// Delete the old photo
	Storage::delete($oldFilename);
}


/*
DELETE
*/
public function destroy($id)
{
	Storage::delete($post->image);

	$post->delete();
}

?>