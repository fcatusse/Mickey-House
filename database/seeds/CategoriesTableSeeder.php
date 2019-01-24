<?php

use Illuminate\Database\Seeder;
use App\Categories;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    /*
    public function run()
    {
        factory(App\Categories::class, 12)->create()->each(function ($category) {
            $category->save();
        });
    }
    */

    public function run()
    {
        DB::table('categories')->insert([
            'title' => "boeuf"

        ]);
        DB::table('categories')->insert([
            'title' => "plat mijote"

        ]);
        DB::table('categories')->insert([
            'title' => "cuisine francaise"

        ]);
        DB::table('categories')->insert([
            'title' => "veau"

        ]);
        DB::table('categories')->insert([
            'title' => "cuisine italienne"

        ]);

    }

}
