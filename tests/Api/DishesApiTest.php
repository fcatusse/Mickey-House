<?php

use App\Http\Controllers\DishesController;
use Tests\TestCase;

class DishesApiTest extends TestCase
{

    public function testDishesController() {
        $controller = new DishesController();
        $result = $controller->index();
        $this->assertTrue($result == 1);
    }

    public function testUpdateServings() {
      $response = $this->call('PUT', '/dish/order', ['user_id' => 1, 'dish_id' => 2, 'nb_servings' => 1, 'price' => 4]);
      dump($response->status());
      $this->assertTrue($response->status() == 302);
    }

}
