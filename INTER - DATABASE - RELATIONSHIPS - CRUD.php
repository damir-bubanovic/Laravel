<?php 
/*

!! INTER - DATABASE - RELATIONSHIPS - CRUD !!

1) create CategoriesController & CRUD
	* limit access to crud only to login users (as we did before)
*/
public function __construct() {
	$this->middleware('auth');
}

/*
A) create methods: index, store
- do not forget to include Category Model inside Controller
- do not forget to include session if you are outputing flash messages
*/
use App\Category;
use Session;

public function index()
{
	// display view of all our categories
	// it will have a form to create a new category
	$categories = Category::all();
	return view('categories.index')->withCategories($categories);

}

public function store(Request $request)
{
	// Save a new category & redirect back to index
	$this->validate($request, array(
		'name' => 'required|max:255'
	));
	// create new Category object
	$category = new Category;

	$category->name = $request->name;
	$category->save();
	// create success message
	Session::flash('success', 'new Category has been created');
	// redirect to index
	return redirect()->route('categories.index');
}

/*
B) create routes for our CRUD Categories
- but because we deleted CRUD create of our categories so we have to tell laravel not to create a route categories.create
so we pass in a third parameter to Route::resource
- or instead of 'except' you can use 'only' & list routes to link
*/
/**
 * CATEGORIES ROUTES
 * this gives all the additional routes for our CRUD methods (functions)
 */
Route::resource('categories', 'CategoryController', ['except' => ['create']]);

/*
C) create folder & files for Categories
	C.1) index.blade.php
		- display categories & show form to add new category
*/
<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<h1>Categories</h1>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($categories as $category)
				<tr>
					<th>{{ $category->id }}</th>
					<td>{{ $category->name }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div><!-- END of column md-8 -->
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	<div class="well">
		{!! Form::open(['route' => 'categories.store']) !!}
			<h2>New Category</h2>
			{{ Form::label('name', 'Name:') }}
			{{ Form::text('name', null, ['class' => 'form-control']) }}
			<hr>
			{{ Form::submit('Create New Category', ['class' => 'btn btn-primary btn-block']) }}
		{!! Form::close() !!}
	</div>
</div>

?>
