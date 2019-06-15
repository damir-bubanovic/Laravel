<?php 
/*

!! INTER - DATABASE - RELATIONSHIPS - ONE TO MANY (CATEGORIES) !!

>> ALERT - WORKING WITH <<
	> Primary & Foreing Key through PHP (not SQL)
	
1) create model - in our case to work with categories
	artisan make:model <Category>
2) create migration - work with categories
	artisan make:migration <create_categories_table>
3) create migration
	artisan make:migration <add_category_id_to_posts>
	- this is to link posts table & categories table
4) run newly created migrations (does not affect others)
	artisan migrate
*/

Schema::create('categories', function(Blueprint $table) {
	$table->engine = 'InnoDB';
	$table->increments('id');
	$table->string('name');
	$table->timestamps();
});

/*
3) add coluimn to existing table
-> nullable - in production remove this, but we add here so we do not get an error is category is not present
-> after - insert after column slug
-> unsigned - this integer column has only positive numbers (saves space) / (always do this with foreign id-s)
	* there is also helper npr. $table->foreing('category_id')->references('id')->on('categories');
	* tip - do not use this because not every database supports this type of encoding
	* primary / foreign key will be manipulated on the Laravel level, not Database Level
		- so to recap php will create relationship, not the database
		- InnoDB vd MyIsam - foreing key / primary key relationships
*/
Schema::table('posts', function($table) {
	$table->integer('category_id')->nullable()->after('slug')->unsigned();
});

/*
5) Make changes to model Category
A) in Category MODEL say -> category has many posts
> when you have a funky name for a model tell the model to use categories table
	- usually that is not neccessary, but with a funky name we should do it (look it up), so when you are not following convention
	- no need for npr. User, Post... (Models)
	- in our case use categories table when working with this model
> define relationships in method (function)
	- we are saying category has many posts & connect it to the Post model (relationship ONE TO MANY)
	- look up more about the relationships
		https://laravel.com/docs/5.3/eloquent-relationships
B) in Post MODEL say -> many posts have single category
*/
class Category extends Model
{
    protected $table = 'categories';
	
	public function posts() {
        return $this->hasMany('App\Post');
    }
}

class Post extends Model
{
    public function category() {
        return $this->belongsTo('App\Category');
    }
}

/*
6) Using relationships to display information
> the tables are connected!
> $post->category->name 
	- (exmplanations) - in the post model use category method that initiates relationship with category model, 
	that is connected with categories table, therefore we have access to all table column values
*/
<h1>{{ $post->title }}</h1>
<p>{{ $post->body }}</p>
<hr>
<p>Posted in: {{ $post->category->name }}</p>
?>





<?php
/**
 * Full Model With Auth
 * > Post model
 * > User model
 * > Home / Index Controller
 * > Home View
 */
class Post extends Model
{
    /**
     * Single Post belongs to User
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Single User has Many Posts
     * @return [type] [description]
     */
    public function posts() {
        return $this->hasMany('App\Post');
    }
}


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        return view('home')->with('posts', $user->posts);
    }
}


@if (count($posts)) {
    <table class="table table-striped">
        <tr>
            <th>title</th>
            <th></th>
            <th></th>
        </tr>
        @foreach ($posts as $post)
            <tr>
                <th>{{ $post->title }}</th>
                <th><small>{{ $post->user->name }}</small></th>
            </tr>
        @endforeach
    </table>
@endif