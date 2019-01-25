<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5; $i++) { 
            DB::table('reviews')->insert([
                'order_id' => rand(1,2),
                'note' => rand(1,5),
                'comment'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris et condimentum neque. Duis et mattis elit, quis posuere urna. Maecenas metus felis, mollis condimentum eleifend vitae, porttitor at nisl. Morbi tincidunt porta mi, a dapibus leo cursus sed. Duis ut urna convallis, dictum eros ut, auctor est. Aenean sagittis ex eget tellus pellentesque, eget facilisis diam scelerisque. Praesent vulputate nunc quis quam egestas vulputate vel quis odio. Vivamus sodales mi nec sollicitudin gravida. Nam sodales, lorem nec lacinia rutrum, est sem tincidunt dolor, id placerat turpis dolor vitae tellus. Duis eu dolor maximus, vulputate odio a, dictum eros. Integer ac libero massa. Sed purus lorem, semper at sollicitudin imperdiet, varius quis lacus. Fusce finibus velit quis nisl fermentum, vel tincidunt dui malesuada. Nulla dictum lectus enim, eu condimentum magna pharetra in.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
