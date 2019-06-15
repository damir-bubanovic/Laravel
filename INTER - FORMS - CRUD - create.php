<?php 
/*

!! INTER - FORMS - FUNCTION - CREATE THEM !!

> we are going to work with -> laravelcollective/html
1) Modify create function in controller
2) Create view
	2.1.) Create Form with the helder of -> laravelcollective/html
	2.2.) As url copy route (artisan route:list) location -> use Name (Route)
		> for our purposes we want with the POST method STORE form information to database
		> url is ['route' => 'posts.store']
	2.3.) Pass in id for label - id should match the column name in database
	2.4.) 
		1 - sync label & input field
		2 - There has to be a default value, if not than pass null (blank)
		3 - optional - can be an array of any other options, in our case we set class to form-control (bootstrap css)

SECURITY (creates & validates hidden SCRF field)
* gives us CSRF Protection - prevents people from other websites from submitting our form on our website


>> ALERT << 
	AVODI HAVING FORMS WITHIN FORMS IN LARAVEL

*/


/*
CONTROLLER - PostController
     * Show the form for creating a new resource.
     *
     * @return Illuminate\Http\Response
     */
    public function create()
    {
		/*In here we only need to show form*/
		/*We are returning view that is tored in resources > posts > create.blade.php*/
        return view('posts.create');
    }
	

/*
VIEW
*/
{!! Form::open(['route' => 'posts.store']) !!}
	/*LABEL FIELD -Parameters: 1-column name in database 2-value of label */
	{{ Form::label('title', 'Title:') }}
	/*TEXT INPUT FIELD - Parameters: 1-for syncing label & input field 2-default value null*/
	{{ Form::text('title', null, array('class' => 'form-control')) }}
	{{ Form::label('body', 'Post Body:') }}
	{{ Form::textarea('body', null, array('class' => 'form-control')) }}
	<br />
	{{ Form::submit('Create Post!', array('class' => 'btn btn-success btn-lg btn-block')) }}
{!! Form::close() !!}
?>




<?php
/**
 * Alternative with AUTH
 * > create view
 * > create controller
 */

@section('content')
	<h1>Create Post</h1>
	{!! Form::open(['action' => 'PostsController@store', 'method' => 'POST']) !!}
    	<fieldset class="form-group">
    		{{ Form::label('title', 'Title') }}
    		{{ Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title']) }}
    	</fieldset>
    	<fieldset class="form-group">
    		{{ Form::label('body', 'Body') }}
    		{{ Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text']) }}
    	</fieldset>
	    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
	{!! Form::close() !!}
@endsection


/**
 * Store a newly created resource in storage with user id
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
    $this->validate($request, [
        'title' => 'required',
        'body'  => 'required'
    ]);

    $post = new Post;
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    $post->user_id = auth()->user()->id;
    $post->save();

    return redirect('/posts')->with('success', 'Post Created');
}