<?php 
/*

!! INTER - DATABASE - SEEDS - FAKER !!

> create fake data
*/


use Illuminate\Database\Seeder;
use Faker\Factory;

class MountainsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $number = 5;

        for ($i = 0; $i < $number; $i++) {
            $data = array(
                'name'          =>  $faker->name,
                'created_at'    =>  $faker->dateTime(),
                'updated_at'    =>  $faker->dateTime()
            );
            DB::table('mountains')->insert($data);
        }


    }
}


class RefugeContactsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
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


class RoutesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $number = 20;

        for ($i = 0; $i < $number; $i++) {
            $data = array(
                'name'                      =>  $faker->company,
                'description'               =>  $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
                'difficulty'                =>  $faker->numberBetween($min = 1, $max = 5),
                'duration'                  =>  $faker->numberBetween($min = 14460, $max = 518340),
                'distance'                  =>  $faker->numberBetween($min = 1000, $max = 10400),
                'mountain_id'               =>  $faker->numberBetween($min = 1, $max = 5),
                'created_at'                =>  $faker->dateTime(),
                'updated_at'                =>  $faker->dateTime()
            );
            DB::table('routes')->insert($data);
        }


    }
}