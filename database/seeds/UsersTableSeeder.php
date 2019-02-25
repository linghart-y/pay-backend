<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $user = new User();
            $user->username = 'admin';
            $user->password = bcrypt('password');
            $user->email = "admin@test.com";
            $user->first_name = "Service";
            $user->last_name = "Administrator";
            $user->remember_token = true;
            $user->role = 'admin';
        $user->save();

        for($i = 1; $i <= 500; $i++)
        {
            $gender = rand(1,100) % 2 == 0 ? 'male' : 'female';
            $first_name = $faker->firstName($gender);
            $last_name = $faker->lastName();
            
            $user = new User();
                $user->username = rand(1,100) . '_' . lcfirst($first_name) . '_' . lcfirst($last_name);
                $user->password = bcrypt('password');
                $user->email = rand(1,100) . '_' . lcfirst($first_name) . '_' . lcfirst($last_name) . "@test.com";
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->remember_token = true;
            $user->save();          
        }
    }
}
