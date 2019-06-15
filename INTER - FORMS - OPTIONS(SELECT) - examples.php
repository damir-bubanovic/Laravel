<?php 
/*

!! INTER - FORMS - OPTIONS(SELECT) - examples !!

1) simpler
2) with FORM helpers
	- create an array in controller to pop in in our select options form

*/

<select class="form-control" name="category_id">
	@foreach ($categories as $category)
		<option value="{{ $category->id }}">{{ $category->name }}</option>
	@endforeach
</select>



$post = Post::find($id);
$cats = $array();
foreach ($categories as $category) {
	$cats[$category->id] = $category->name;
}
return view('posts.edit')->withPost($post)->withCategories($cats);

{{ Form::label('category_id', 'Category:') }}
{{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}



?>