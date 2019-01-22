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
            'is_admin'=> true,
        ]);
        DB::table('users')->insert([
            'username' => "user",
            'email' => "user@user.com",
            'password'=> bcrypt('user')
        ]);
    }
}
