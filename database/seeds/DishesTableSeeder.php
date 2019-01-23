<?php

use Illuminate\Database\Seeder;

class DishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('dishes')->insert([
          'user_id' => 1,
          'name' => "bourguignon",
          'description'=> "plat traditionnel de boeuf mijoté au vin rouge",
          'photos'=> 'food_img',
          'nb_servings' => 4,
          'price' => 4.5,
          'categories' => "boeuf, plat mijote, cuisine francaise",
          'is_visible' => true
      ]);
      DB::table('dishes')->insert([
          'user_id' => 2,
          'name' => "osso bucco",
          'description'=> "ragout italien au veau, legumes et vin blanc",
          'photos'=> 'food_img',
          'nb_servings' => 4,
          'price' => 4.0,
          'categories' => "veau, plat mijote, cuisine italienne",
          'is_visible' => true
      ]);

    }
}
