<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\DishesController;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

//déprotéger les routes utilisées dans le test dans app/Http/Middleware/VerifyCsrfToken
//302 si redirect, sinon 200 pour success ou return view

class OrderAPITest extends TestCase
{
  use WithoutMiddleware;

  //the function has to save new data in the table and redirect to a view
  public function testSaveNewOrder() {
    //order OK
    $response = $this->call('POST', '/orders/new', ['user_id' => 2, 'dish_id' => 1, 'nb_servings' => 1, 'price' => 4.5]);
    $this->assertTrue($response->status() == 302);
  }

  // the function has to display all orders of the current user
  public function testShowAll(){
    // test OK
    $user = new User();
    $user->id = 1;
    $this->be($user);
    $response = $this->call('GET','/orders/show');
    $response->assertViewHas('orders');
    $this->assertTrue($response->status() == 200);
    // test KO
    // $response = $this->call('GET','/orders/show');
    // $response->assertViewHas('orders');
    // $this->assertTrue($response->status() == 500);

  }



}

 ?>
