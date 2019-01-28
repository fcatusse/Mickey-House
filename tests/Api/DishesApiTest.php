<?php

use App\Http\Controllers\DishesController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DishesApiTest extends TestCase
{

  use WithoutMiddleware;
  // the function has to find a dish and show it. It returns to the view in case of success
  // and gives an error 404 in case of id not found

  public function testShowDish()
  {
    $response = $this->call('GET', '/dish/1');
    $response->assertViewHas('dish');
    $response->assertViewHas('servings');
    $this->assertTrue($response->status() == 200);
    //$this->assertTrue($response->original->getData()["dish"][0]->id == 1);
  }

}
