<?php
/**
 * INTER - UPLOAD - FILES - FULL ALTERNATIVE
 * > save image file name in database (create migration)
 */

{!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
	{{ Form::file('cover_image') }}
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
{!! Form::close() !!}


/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
	/**
	 * Max size
	 * > for lot of apache servers upload size is 2mb
	 * > link storage with public folder
	 * 		- php artisan storage:link
	 */
    $this->validate($request, [
        'cover_image'	=> 'image|nullable|max:1999'
    ]);

    if ($request->hasFile('cover_image')) {
    	// Get filename with extension
    	$filenameWithExt = $request->file('cover_image')->getClientOriginalName;
    	// Get just filename
    	$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    	// Get just ext
    	$extension = $request->file('cover_image')->getClientOriginalExtension();
    	// Filename to store (unique filename)
    	$fileNameToStore = $filename . '_' . time() . '.' . $extension;
    	// Uplod image to storage public folder
    	$path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
    } else {
    	$fileNameToStore = 'noimage.jpg'
    }

    $post = new Post;
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    $post->user_id = auth()->user()->id;
    $post->cover_image = $fileNameToStore;
    $post->save();

    return redirect('/posts')->with('success', 'Post Created');
}



/**
 * Display image
 */
<img src="/storage/cover_images/{{ $post->cover_image }}"></img>