<?php 
/*

!! INTER - MODEL(DATABASE) - FORMS - BINDING(UPDATE) !!

1) find the specific post & display the information from that post

>> ALERT << 
	AVODI HAVING FORMS WITHIN FORMS IN LARAVEL
*/

public function edit($id)
{
	// find the post in database & save it as a variable
	$post = Post::find($id);
	// return the view & pass in the information previously created
	return view('posts.edit')->withPost($post);
}

/*
2) create file edit.blade.php > in posts folder
> create editable text
> use model-form binding -> pass model object (example = $post = Post::find($id);), eg. bind model object to the form
	- therefore laravel knows if there is a value to automatically fill it into the form (if not empty)

> use FORM::model() - se are opening a form, but we need to connect it to model(database) we are passing data in
	>> param1 	- what model it needs to bind to the form
				- we are passing in object we have in the form that contains the model data -> that is $post
				- we used that $post variable to go out to the database, find a row of information that we need, and then
				returna as an object with informations (this is a model object)
	>> param2	- other options (method, route, classes...)
				> route -> link to the route (submit infor to the update route)
					>> we need 2 form of information: name of the route & id number we want to pass into route
	>> param3	- you have to manuall set method see Routes:list - for method for name

> Form::text	- echo out the form
	>> param1	- name of the text field that corespands with the column name in the database
	>> param2	- set the default value to the current value in the database, type null - do not override what laravel wants to do
	>> param3 	- set class for bootstrap
	
> Form::textarea
	>> param1	- name of the textarea field correspons with the columna name in the database
	>> param2 	- set size of textarea, type null - do not override what laravel wants to do
	>> param3	- set class for bootstrap
*/

{!! Form::model($post, array('route' => array('posts.update', $post->id), 'method' => 'PUT')) !!}
	{{ Form::text('title', null, array('class' => 'form-control')) }}
	{{ Form::textarea('body', array('class' => 'form-control')) }}
{!! Form::close() !!}

/*
3) set up submit button
> value of the button to show
*/
{!! Html::linkRoute('posts.update', 'Save', array($post->id), array('class' => 'btn btn-success btn-block')) !!} // change this
{{ Form::submit('Save Changes', array('class' => 'btn btn-success btn-block')) }} // to this


/*
4) set up update function
> validate data the same way as we did with the function store
> $request->input('title') - identify something from the post input that was posted from the post (or through get method)
> no need for $post->updated because $post->save automatically updates
*/
public function update(Request $request, $id)
{
	// validate data
	$this->validate($request, array(
		'title' =>  'required|max:255',
		'body'  =>  'required'
	));
	// save data to the database
	$post = Post::find($id);
	
	$post->title = $request->input('title');
	$post->body = $request->input('body');
	
	$post->save();
	// set flash data with success message
	Session::flash('success', 'The blog post was successfully updated!');
	// redirect with flash data to posts.show
	return redirect()->route('posts.show', $post->id);
}
?>




<?php
/**
 * Alternative (check out route list - this is why we need hidden _method PUT)
 * > edit view
 * > update controller
 */
@section('content')
	<h1>Create Post</h1>
	{!! Form::open(['action' => ['PostsController@store', $post->id], 'method' => 'POST']) !!}
    	<fieldset class="form-group">
    		{{ Form::label('title', 'Title') }}
    		{{ Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title']) }}
    	</fieldset>
    	<fieldset class="form-group">
    		{{ Form::label('body', 'Body') }}
    		{{ Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text']) }}
    	</fieldset>
        {{ Form::hidden('_method', 'PUT') }}
	    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
	{!! Form::close() !!}
@endsection




/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    $this->validate($request, [
        'title' => 'required',
        'body'  => 'required'
    ]);

    $post = Post::find($id);
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    $post->save();

    return redirect('/posts')->with('success', 'Post Updated');
}