<?php 
/*

!!!! BASIC - LINKS - to individual blogs & creating view!!!!

> /blogs/ index & show
> /routes/ web
> /app/http/controllers


*/
/*Index/Blogs page -> index.blade.php*/
@extends('layouts.master')

@section('content')
    <h1>My Latest Blog</h1>

    @foreach($blogs as $blog)
        <a href="/blogs/{{ $blog->id }}"><h3>{{ $blog->title }}</h3></a> /*Use this href*/
        <a href="{{ action('BlogsController@show', [$blog->id]) }}"><h3>{{ $blog->title }}</h3></a> /*OR Use this href*/
        <p>{{ $blog->body }}</p>
    @endforeach

@endsection

/*Index/Blogs/{#id} -> show.blade.php*/
@extends('layouts.master')

@section('content')
    <h1>{{ $blog->title }}</h1>

    <p>{{ $blog->body }}</p>

@endsection

/*BlogsController*/
class BlogsController extends Controller
{
    public function index() {
        $blogs = Blog::all();
        return view('blogs.index')->with('blogs', $blogs);
    }

    public function show($id) {
        $blog = Blog::findOrFail($id);
        return view('blogs.show')->with('blog', $blog);
    }
}

/*Routes - add this*/
Route::get('blogs', 'BlogsController@index');
Route::get('blogs/{id}', 'BlogsController@show');




/*
EXAMPLE 2:
> link buttons to take us to another page
> Html::linkRoute() - pass in a named route & get a full anchor tag just like below
	- param1 	-> where to go - post edit page('posts.edit')
	- param2 	-> value - Edit
	- param3 	- any parameter you need to pass to url (pass in as an array!) 
				-> (look up Route:list) - posts/{post}/edit ({post} - pass in primary id) - array($post->id)
				-> if you don't have any variables you still need to pass an empty array
	- param4	-> optional array parameter for anything... class, id, data...
*/
{!! Html::linkRoute('post.edit', 'Edit', array($post->id), array('class' => 'btn btn-primary btn-block') !!}
<a href="#" class="btn btn-primary btn-block">Edit</a>

{!! Html::linkRoute('posts.destroy', 'Delete', array($post->id), array('class' => 'btn btn-danger btn-block')) !!}
?>