<?php 
/*

!! INTER - FORMS - CRUD - READ FROM DATABASE !!

> pull data from the database & diyplay it to the database

1) we want to find the post by id number & display that specific post
	> we are using Eloquent to work with our database
		>> simple way to create SQL requests using PHP
		
2) show data in the view

>> ALERT << 
	AVODI HAVING FORMS WITHIN FORMS IN LARAVEL
*/

/**
PostController.php
     * Display the specified resource.
     *
     * @param  int  $id (pass in unique id - in our example post id)
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        /*If we created model before we do not need to say new Post, but only use existing model*/
		/*We created new Post (model in public function store(Request $request))*/
		/*In our case find primary id ($id is passed through the url)*/
		$post = Post::find($id);
		// return the view & pass in post variable that is set to $post (sending all columns from that $id)
        return view('posts.show')->with('post', $post);
		return view('posts.show')->withPost($post); // alternatively way of writing
    }

	
/*
show.blade.php (posts folders)
*/
@section('content')
	/*title column - show / print specific id title value*/
    <h1>{{ $post->title }}</h1>
	/*show body*/
	<p>{{ $post->body }}</p>
@endsection



/*
EXAMPLE 2 - working on index page
1) setup the PostController.php
*/
public function index()
{
	// create a variable & store all the blog post from the database
	// Post object was created before so no need for new Post (in store function)
	// Post::all() - gets all the posts from database
	$posts = Post::all();
	// return a view & pass in above variable 
	return view('posts.index')->withPosts($posts);
}

/*
2) setup views - create index.blade.php in posts folder
- create a button to create new posts
- {{ route('posts.create') }} 	- allows us to pass on a named route & automatically generate an url from than named route
								- posts.create - links to creating a new blog post
*/
<a href="{{ route('posts.create') }}" class="btn btn-lg btn-block btn-primary">Create New Post</a>

/*
3) create index page
> create index.blade.php
> <th>{{ $post->id }}</th> - so the text is bold (css properties)
> truncate body (eg. show only part of the body) & if body string is greater than 50 characters add ... at end
> format friendly date
> link buttons
	- display -> posts.show with the current id of post -> $post->id
*/
<table class="table">
	<thead>
		<th>#</th>
		<th>Title</th>
		<th>Body</th>
		<th>Created At</th>
		<th></th>
	</thead>
	<tbody>
		@foreach ($posts as $post)
			<tr>
				<th>{{ $post->id }}</th>
				<td>{{ $post->title }}</td>
				<td>{{ substr($post->body, 0, 50) }}{{ strlen($post->body) > 50 ? '...' : '' }}</td>
				<td>{{ date('M j, Y', strtotime($post->created_at)) }}</td>
				<td>{{ route('posts.show', '$post->id') }}</td>
				<td>
					{!! Html::linkRoute('posts.show', 'Show', array($post->id), array('class' => 'btn btn-default btn-sm')) !!}
                    {!! Html::linkRoute('posts.edit', 'Edit', array($post->id), array('class' => 'btn btn-default btn-sm')) !!}
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

?>