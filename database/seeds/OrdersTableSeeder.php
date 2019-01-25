<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('orders')->insert([
          'user_id' => 3,
          'dish_id' => 2,
          'nb_servings'=> 2,
          'price'=> 8,
          'sent'=> 0,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('orders')->insert([
          'user_id' => 2,
          'dish_id' => 1,
          'nb_servings'=> 2,
          'price'=> 9,
          'sent'=> 0,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);

    }
}
