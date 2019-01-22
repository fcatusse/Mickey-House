<?php

use App\Http\Controllers\Ordercontroller;
use Tests\TestCase;

class OrderAPITest extends TestCase
{
  public function testOrderController() {
    $controller = new OrderController();
    $result = $controller->index();
    $this->assertTrue($result == 1);
  }
}

 ?>
