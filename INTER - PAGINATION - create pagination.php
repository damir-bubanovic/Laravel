<?php 
/*

!! INTER - PAGINATION !!

1) use paginate method in PostController.php
*/

public function index()
{
	// create a variable & store all the blog post from the database
	// $posts = Post::all(); - this produces all results
	// order by descending order, newest first - use id not timestamp because it is faster
	$posts = Post::orderBy('id', 'desc')->paginate(5);
	// return a view & pass in above variable
	return view('posts.index')->withPosts($posts);
}

/*
2) change index.blade.php where posts are displayed
- we are calling links method on our object
*/
<div class="text-center">
	{{ $posts->links() }}
</div>
?>