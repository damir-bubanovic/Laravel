<?php 
/*

!! INTER - QUERY - QUERY BUILDER !!

> query builder - ultimate tool for queries (allows more complex queries)

1) change PagesController.php index method
	> if we are using a model $posts = Post::... we don not need to use like DB::table('users')
	> our Post model is app > Post.php
	> if you do a join request you have to do a DB::table to specify
	> if you have post that need to be verified than specify show only verified
*/
public function getIndex() {
	$posts = Post::orderBy('id', 'desc')->limit(4)->get();
	return view('pages.welcome')->withPosts($posts);
}

/*
2) welcome.blade.php
THIS COMES LATER
	> link leads to pages > single (wordpress terminology) - show 1 post
	> post->id - specific id number of our post
> truncate $post->body
> add use App\Post; to the PagesController.php
*/

@foreach ($posts as $post)
	<div class="post">
		<h3>{{ $post->title }}</h3>
		<p>{{ substr($post->body, 0, 100) }}{{ strlen($post->body) > 100 ? '...' : '' }}</p>
		<a href="#" class="btn btn-primary">Read More</a>
	</div>
	<hr>
@endforeach


/*
EXSTRA - add return button when in single post
> write second parameter even if it is empty
*/
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	{!! Html::linkRoute('posts.index', '<< See all Posts', array(), array('class' => 'btn btn-default btn-block btn-h1-spacing')) !!}
</div>
?>