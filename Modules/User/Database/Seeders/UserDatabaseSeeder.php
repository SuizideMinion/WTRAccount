<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Model::unguard();

        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $faker->phoneNumber,
                'remember_token' => md5($faker->date($format = 'D-m-y', $max = '2000',$min = '1990'))
            ]);
        }
        // $this->call("OthersTableSeeder");
    }
}
