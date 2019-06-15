<?php 
/*

!! INTER - DATABASE - RELATIONSHIPS - MANY TO MANY (TAGS) !!

>> ALERT <<
	There is a lot - look up existing resources

> use intermediary table for many to many relationships

1) use belongsToMany('App\Tag', 'post_tag', 'post_id', 'tag_id') to our model
	- param1 -> name of our model to link to (npr. for Post.php model) (only parameter that is required)
	- param2 -> customize table name for intermediary table (not needed if you folow conventions, BUT DO THIS!)
					- convention for name is alphabetical order of 2 connecting tables (post table & tag table), 
					in our case 'post_tag'
	- param3 & 4 -> define column names in our models
					> 3 = Column name for Current Model
					> 4 = Column name for Joining Model
	>> ALERT <<
		Both of these work in the example because we are following conventions, we can write however we want

2) create migration
	A) create_tags_table - for storing tags
	b) create_post_tag-table - intermediary table


*/

/*Post.php Model*/
/**
 * MANY TO MANY
 * tags belong to this post
 */
public function tags() {
	return $this->belongsToMany('App\Tag');
}

/*Tags.php Model*/
/**
 * MANY TO MANY
 * posts belongs to a tag
 */
public function posts() {
	return $this->belongsToMany('App\Post', 'post_tag', 'tag_id', 'post_id');
}


/*A) create_tags_table*/
Schema::create('tags', function(Blueprint $table) {
	$table->engine = 'InnoDB';
	$table->increments('id');
	$table->string('name');
	$table->timestamps();
});

/*B) create_post_tag_table*/
Schema::create('post_tag', function(Blueprint $table) {
	$table->engine = 'InnoDB';
	$table->increments('id');
	$table->integer('post_id')->unsigned(); // only positive integers of post id
	$table->foreign('post_id')->references('id')->on('posts'); // we are manually telling database this is a foreign key
	$table->integer('tag_id')->unsigned(); // only positive integers of tag id
	$table->foreign('tag_id')->references('id')->on('tags'); // hard coding (if database does not support, it ignores it)
});


/*
C) Create select options 
1) select multiple options / tags
	- instead of bootstrap select, use jQuery plugin Select2
		https://select2.github.io/
	- little tricky to set up
		> tags[] - crutial because we are passing data as an array of selected options
2) in create.blade.php
	- do this - after save sync array of data (data is saved after save())
	- look this all up a lot harder on Laravel Site
*/
{{ Form::label('tags', 'Tags:') }}
<select class="select2-multi form-control" name="tags[]" multiple="multiple">
	@foreach ($tags as $tag)
		<option value="{{ $tag->id }}">{{ $tag->name }}</option>
	@endforeach
</select>

$post->save();
$post->tags()->sync($request->tags, false);


/*
D) view post with tags
*/
<div class="tags">
	@foreach ($post->tags as $tag)
		<span class="label label-default">{{ $tag->name }}</span>
	@endforeach
</div>

/*
E) edit post with tags
*/
{{ Form::label('tags', 'Tags', ['class' => 'form-control']) }}
{{ Form::select('tags[]', $tags, null, ['class' => 'select2-multi form-control', 'multiple' => "multiple"]) }}

$tags = Tag::all();
$tags2 = array();
foreach ($tags as $tag) {
	$tags2[$tag->id] = $tag->name;
}
// return the view & pass in the information previously created
return view('posts.edit')->withTags($tags2);

/*
F) change jQuery in edit.blade.php
*/
/*Show Tags*/
$(".select2-multi").select2().val({{ json_encode($post->tags()->getRelatedIds()) }}).trigger('change');
/*Save Edited Tags*/

/*
G) sync data in update method
- so not to get an error if we pass no tags / delete all tags
*/
$post->save();
if (isset($request->tags)) {
	$post->tags()->sync($request->tags, true);
} else {
	$post->tags()->sync(array());
}


/*
H) tags.edit
*/
{!! Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' => 'PUT']) !!}
	{{ Form::label('name', 'Name:') }}
    {{ Form::text('name', null, ['class' => 'form-control']) }}
	{{ Form::submit('Save Changes') }}
{!! Form::close() !!}


/*
J) Deleting many to many relationships
- make sure you handle both directions in relationships (post / tag controller)
- detach any reference to the current object
> onDelete('cascade')
	- if someone deletes the post it deletes the referance
	- in many to many relationships is better to do detach
	- with simple ones do cascade
	$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade'); // migrations
*/
$post->tags()->detach();
/*npr. PostController*/
public function destroy($id)
{
	$post = Post::find($id);
	$post->tags()->detach();

	$post->delete();

	Session::flash('success', 'The blog post was successfully deleted!');
	return redirect()->route('posts.index');
}


/*
OTHER
- get number of times tag is used (in how many posts)
*/
{{ $tag->posts()->count() }}

?>
