<?php
/**
 * INTER - FORMS - WITH TEXT EDITOR, VALIDATION & SESSION MESSAGES
 * 1) create form post with id article-ckeditor
 * 		> Laravel wycwyg text editor
 * 		> https://github.com/UniSharp/laravel-ckeditor
 * 2) create controller with eloquent
 * 3) show posts
 * 4) success / error messages
 */
/*Create FOrm*/
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


/*Store Controller*/
/**
 * Store a newly created resource in storage.
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
    $post->save();

    return redirect('/posts')->with('success', 'Post Created');
}

/*Show Posts*/
@section('content')
	<h1>{{ $post->title }}</h1>
	<div>
		<p>{!! $post->body !!}</p>
	</div>
	<hr>
	<small>{{ $post->created_at }}</small>
@endsection


/*Messages - layout aoo*/
<div class="container">
    @include('include.messages')
    @yield('content')
</div>

/*Messages Page*/
@if (count($errors) > 0)
	@foreach ($errors->all() as $error)
		<div class="alert alert-danger">
			{{ $error }}
		</div>
	@endforeach
@endif

@if (session('success'))
	<div class="alert alert-success">
		{{ session('success') }}
	</div>
@endif

@if (session('error'))
	<div class="alert alert-error">
		{{ session('error') }}
	</div>
@endif