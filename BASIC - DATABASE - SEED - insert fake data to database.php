<?php
/*

!! BASIC - DATABASE - SEED - INSERT FAKE DATA !!

*/


/**
 * SEEDING DATABASE
 *
 * 1) Create database, model, migration
 * 2) artisan make:seeder
 * 3) artisan DB:Seed
 */

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Todo;

class TodosTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * - use enable model (App\Todo) & factory (Faker\Factory)
     *
     * - create faker
     * - truncate (mysql) - empty the table completely (not correct meaning, explore more)
     * - foreach loop / for loop to add data corresponds to fields in database
     */
    public function run()
    {
        $faker = Factory::create();

        Todo::truncate();

        foreach(range(1,50) as $a) {
            Todo::create([
                'name'      =>  $faker->name,
                'address'   =>  $faker->address,
                'phone'     =>  $faker->phoneNumber
            ]);
        }
    }
	
	/**
	* EXAMPLE 2
	*/
	public function run()
    {
        $faker = Factory::create();

        Todo::truncate();

        for($i=0; $i < 20; $i++) {
            Todo::create([
                'title'     => $faker->text($maxNbChars = 20),
                'completed' => $faker->boolean($chanceOfGettingTrue = 50),
                'user_id'   => $faker->numberBetween($min = 1, $max = 3)
            ]);
        }
    }
	
	/**
	* EXAMPLE 3
	*/
	public function run()
    {
        $faker = Factory::create();

        $number = 200;

        for ($i = 0; $i < $number; $i++) {
            $data = array(
                'refuge_id'                 =>  $faker->numberBetween($min = 1, $max = 50),
                'person'                    =>  $faker->name,
                'email'                     =>  $faker->email,
                'phone'                     =>  $faker->e164PhoneNumber,
                'created_at'                =>  $faker->dateTime(),
                'updated_at'                =>  $faker->dateTime()
            );
            DB::table('refuge_contacts')->insert($data);
        }
    }
}



class DatabaseSeeder extends Seeder
{
    /**
     * Run single table to seed
     */
    public function run()
    {
        $this->call(TodosTableSeed::class);
    }
	
	/**
	* Run multiple tables at once to seed
	*/
	public function run()
	{
		$this->call(UsersTableSeeder::class);
		$this->call(PostsTableSeeder::class);
		$this->call(CommentsTableSeeder::class);
	}
	
	/**
     * Run the database seeds.
     *
     * > Disable Foreign key check for seeder & later Enable
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(MountainsTableSeed::class);
        $this->call(RefugesTableSeed::class);
        $this->call(RefugeRoadTableSeed::class);
        $this->call(RefugeInformationTableSeed::class);
        $this->call(RefugeContactsTableSeed::class);
        $this->call(RoutesTableSeed::class);
        $this->call(StoryTableSeed::class);
        $this->call(RouteStoryTable::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

?>