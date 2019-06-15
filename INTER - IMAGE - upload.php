<?php 
/*

!! INTER - IMAGE - UPLOAD !!

> we can upload images client side or server side
	- client side with javascript to Amazon S3

> local storage image upload (server side)
> we are going to use Intervention Image
		http://image.intervention.io/

>> ALERT <<
	- great system for pdf & such (not for images)
		https://laravel.com/docs/5.3/filesystem

>> ALERT <<
	- when uploading image look up Recapcha if neccessary
	
*/

/*
SAVING IMAGES:
2 places to store images on local file system:
	A) store > app - you have to custom config it like an api, you have to make routes to acces it
	B) public > images - great for images (we are doing this)

	
1) view - set up file open (files => open) & create field to upload images
	(if not using form helpers you need enctype="multipart/form-data")
*/
{!! Form::open(['route' => 'posts.store', 'data-parsley-validate' => '', 'files' => 'true']) !!}

{{ Form::label('featured_image', 'Upload Featured Image:') }}
{{ Form::file('featured_image') }}

/*
2.A) create migration
	- in database we tell laravel which image belongs to which posts
	- we store the images in public > images
2.B) modify Controller
*/
Schema::table('posts', function($table) {
	$table->string('image')->nullable()->after('slug');
});


// save our images
if ($request->hasFile('featured_image')) {
	// Grab the file
	$image = $request->file('featured_image');
	// Rename the saved file (filename must be unique) & save in original extension
	$filename = time() . '.' . $image->getClientOriginalExtension();
	// Chose location
	$location = public_path('images/' . $filename);
	// Create image object & resize image so not to break server & where to save
	Image::make($image)->resize(800, 400)->save($location);
	
	// Save image name into our database
    $post->image = $filename;
}

$post->save();


/*
3) Display image to user
*/
<img src="{{ asset('images/' . $post->image) }}">


/*
4) validate
- using laravel npr. file (is file uploaded), image (file type of image), Mime types (file type - look it up),
size (file size)
*/
$this->validate($request, array(
	'featured_image' => 'sometimes|image'
));
?>