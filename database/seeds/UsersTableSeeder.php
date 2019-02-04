<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => "admin",
            'email' => "admin@admin.com",
            'password'=> bcrypt('admin'),
            'lat'=> 48.1113387,
            'long'=> -1.6800198,
            'is_admin'=> true
        ]);
        DB::table('users')->insert([
            'username' => "user",
            'email' => "user@user.com",
            'password'=> bcrypt('user'),
            'lat'=> 48.1978559,
            'long'=> 3.282606
        ]);
        DB::table('users')->insert([
            'username' => "consumer",
            'email' => "consumer@user.com",
            'password'=> bcrypt('consumer'),
            'lat'=> 48.8566101,
            'long'=> 2.3514992
        ]);
    }
}