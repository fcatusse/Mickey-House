<?php

use Illuminate\Database\Seeder;

class DemandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5; $i++) { 
            DB::table('demands')->insert([
                'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
                'user_id' => 2,
                'budget' => rand(10,100),
                'phone' => 6686965300,
                'email' => 'habib@habib.com',
                'description'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris et condimentum neque. Duis et mattis elit, quis posuere urna. Maecenas metus felis, mollis condimentum eleifend vitae, porttitor at nisl. Morbi tincidunt porta mi, a dapibus leo cursus sed.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
