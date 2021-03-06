<?php

use App\Dish;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


//déprotéger les routes utilisées dans le test dans app/Http/Middleware/VerifyCsrfToken
//302 si redirect, sinon 200 pour success ou return view

class OrdersControllerTest extends TestCase
{
    /**
  use WithoutMiddleware;
  use RefreshDatabase;
  use DatabaseMigrations;

  public function setUp()
  {
      parent::setUp();
      factory(User::class)->create();
      factory(Dish::class)->create();
  }

  //the function has to save new data in the table and redirect to a view
  public function testSaveNewOrderGood() {
    //order OK
    $response = $this->call('POST', '/orders/new', ['user_id' => 1, 'dish_id' => 1, 'nb_servings' => 1, 'price' => 4.5, 'stripeToken' => '']);
    $this->assertTrue($response->status() == 302);
  }

  //the function has to output an error  and return to a view
  public function testSaveNewOrderBad() {
    //order NOT OK
    $response = $this->call('POST', '/orders/new', ['user_id' => 2, 'dish_id' => 1, 'nb_servings' => -1, 'price' => 4.5, 'stripeToken' => '']);
    $this->assertTrue($response->status() == 302);
  }

  // the function has to display all orders of the current user
  public function testShowAllGood()
  {
    // test OK
    $user = new User();
    $user->id = 1;
    $this->be($user);
    $response = $this->call('GET','/orders/show');
    $response->assertViewHas('orders_passed');
    $this->assertTrue($response->status() == 200);

  }

  public function testShowAllBad()
  {
  // test KO
  $response = $this->call('GET','/orders/show');
  $this->assertTrue($response->status() == 500);

  }
*/
}
