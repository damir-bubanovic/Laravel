<?php 
/*

!! BASIC - MODEL - USAGE !!

> NAMING CONVENTIONS: capital letter & singular version of model (Post, Tag, User, Animal...)

> explore what do you use model for
> from my experiance we use it to:
	a) specify database relationships like one-to-many, or many-to-many
	b) specify fillable / nonfillable / hidden fields in forms

*/

public function posts() {
	return $this->belongsToMany('App\Post');
}

protected $fillable = [
	'name', 'email', 'password',
];

?>


<?php
/**
 * Create All
 * > when creating Model, Controller & Migration use these commands
 * > Controller (Posts - plural), Model (Post - singular)
 * 		-m creates migration
 */
php artisan make:controller PostsController
php artisan make:model Post -m



/**
 * Full Model
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