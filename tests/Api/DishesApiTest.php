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

}