<?php

use App\Http\Controllers\Ordercontroller;
use Tests\TestCase;

//déprotéger les routes utilisées dans le test dans app/Http/Middleware/VerifyCsrfToken

class OrderAPITest extends TestCase
{
  public function testSaveNewOrder() {
    $response = $this->call('POST', '/order/new', ['user_id' => 1, 'dish_id' => 2, 'nb_servings' => 1, 'price' => 4.5]);
    dump($response->status());
    //302 si redirect, sinon 200 pour success
    $this->assertTrue($response->status() == 302);
  }
}

 ?>
