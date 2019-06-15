<?php
/**
 * ELOQUENT - Model / View / Controller - working with Databases
 * 1) Get All Posts From Database
 * 2) Show All Posts
 * 3) Get Desired Post
 * 		- Route::resource('posts', 'PostsController'); (list:routes)
 */

/**
 * Get All Posts From Database
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
    /**
     * If you want to see just string for testing purposes
     * - return Post::all();
     */
    $posts = Post::all();
    return view('posts.index')->with('posts', $posts);
}


@section('content')
	<h1>Posts</h1>
	@if (count($posts) > 0)
		<ul class="list-group">
			@foreach ($posts as $post)
				<div class="well">
					<h3><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h3>
					<small>Written on {{ $post->created_at }}</small>
				</div>
			@endforeach
		</ul>
	@else
		<p>No Posts Found</p>
	@endif
@endsection


/**
 * Display the specified Post.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function show($id)
{
    $post = Post::find($id);
    return view('posts.show')->with('post', $post);
}


@section('content')
	<h1>{{ $post->title }}</h1>
	<p>{{ $post->body }}</p>
@endsection