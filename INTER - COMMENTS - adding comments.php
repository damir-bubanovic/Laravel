<?php 
/*

!! INTER - COMMENTS - ADDING COMMENTS !!

*/

/*
1) Migrations
> onDelete('cascade')
	- if someone deletes the post it deletes the referance
	- in many to many relationships is better to do detach, with simple ones do cascade
	
> foreign key can be assigned in the same migration only after the column has been created first
	- therefor Schema::create/table
	- you also have to kill foreign key contstraint 
		>> ALERT << 
			Pay Attention - to the order (first drop foreign relationship, than table)
			
>> ALERT <<
	NOT GOING TO FOCUS ON CRUD - except if you have new information to share, see other examples
	
*/
Schema::create('comments', function(Blueprint $table) {
	$table->engine = 'InnoDB';
	$table->increments('id');
	$table->string('name');
	$table->string('email');
	$table->text('comment');
	$table->boolean('approved');
	$table->integer('post_id')->unsigned();
	$table->timestamps();
});

Schema::table('comments', function($table) {
	$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
});



Schema::dropForeign(['post_id']);
Schema::drop('comments');


/*
2) create model ralationships
*/
class Post extends Model
{
    /**
     * ONE TO MANY
     * post has many comments
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }
}


class Comment extends Model
{
    public function post() {
        return $this->belongsTo('App\Post');
    }
}

/*
3) create CommentsController
- adapt methods by your own choosing, as you changed the controller
*/
Route::post('comments/{post_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);

public function store(Request $request, $post_id)
{
	// Code goes here
	
	// Grab the post object to use post_id in associate()
	$post = Post::find($post->id);
	
	$comment->post()->associate($post);
}

/*
4) Display & loop through all the comments
*/
@foreach ($post->comments as $comment)
	<div class="comment">
		<p>Name: {{ $comment->name }}</p>
		<p>Comment: <br/>{{ $comment->comment }}</p>
	</div>
@endforeach


/*
5) AVATAR API
- use GRAVATAR
	grawatar.com
*/
?>
