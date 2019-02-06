<?php

use App\Dish;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DishesControllerTest extends TestCase
{
  use RefreshDatabase;
  use DatabaseMigrations;
  use WithoutMiddleware;

  public function setUp()
  {
      parent::setUp();
      factory(User::class, 15)->create();
      factory(Dish::class, 15)->create();
  }

  // the function has to find a dish and show it. It returns to the view in case of success
  // and gives an error 404 in case of id not found

  public function testShowDish()
  {
    $dish = Dish::find(1);
    $this->assertInstanceOf(Dish::class, $dish);

    $cook = User::where('id','=', $dish->user_id)->get();
    //dd($cook);
    $this->assertInstanceOf(User::class, $cook); //not working??

    $response = $this->get(route('dish.show', $dish->id));
    $response->assertStatus(200);

    $dish_view = $response->getOriginalContent()->getData()['dish'];
    $this->assertEquals($dish_view->name, $dish->name);
    $this->assertEquals($dish_view->description, $dish->description);

    //$this->assertTrue($response->original->getData()["dish"][0]->id == 1);
  }

}
