<?php 
/*

!! INTER - FORMS - CRUD - DELETE !!

1) set controller
2) put delete button inside form (you can also do this with ajax)

>> ALERT << 
	AVODI HAVING FORMS WITHIN FORMS IN LARAVEL
*/



/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return Illuminate\Http\Response
 */
public function destroy($id)
{
	$post = Post::find($id);

	$post->delete();

	Session::flash('success', 'The blog post was successfully deleted!');
	return redirect()->route('posts.index');
}



{!! Form::open(array('route' => array('posts.destroy', $post->id), 'method' => 'DELETE')) !!}
	{!! Form::submit('Delete', array('class' => 'btn btn-danger btn-block')) !!}
{!! Form::close() !!}

?>



<?php
/**
 * Alternative
 * > delete / show view
 */
{!! Form::open(['action' => 'PostsController@destroy', $post->id], 'method' => 'POST') !!}
	{{ Form::hidden('_method', 'DELETE') }}
	{{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
{!! Form::close() !!}


/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
    $post = Post::find(id);
    $post->delete();

    return redirect('/posts')->with('success', 'Post Removed');
}