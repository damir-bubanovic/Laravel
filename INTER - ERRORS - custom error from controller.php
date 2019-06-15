<?php
/**
 * INTER - ERRORS -CUSTOM ERROR FROM CONTROLLER
 * > usually we get errors from auth predetermined
 */

/**
 * Custom Error
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function edit($id)
{
    $post = Post::find($id);

    // Check correct user
    if (auth()->user()-id !== $post->user_id) {
        return redirect('/posts')->with('error', 'Unauthorized Page');
    }

    return view('posts.edit')->with('post', $post);
}