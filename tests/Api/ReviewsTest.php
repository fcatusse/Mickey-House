<?php

use App\User;
use App\Dish;
use App\Order;
use App\Reviews;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ReviewsTest extends TestCase
{

  use RefreshDatabase;
  use DatabaseMigrations;
  use WithoutMiddleware;

  public function setUp()
  {
      parent::setUp();
      //factory(User::class, 5)->create();
      //factory(Dish::class, 10)->create();
      //factory(Order::class, 10)->create();
      factory(Reviews::class, 10)->create();

  }

  public function testIndex()
  {
    $response = $this->call('GET', '/user/review/1');
    $this->assertTrue($response->status() == 200);
    $order_id = $response->getOriginalContent()->getData()['order_id'];
    $this->assertTrue($order_id != null);
  }

  public function testIndexAdmin()
  {
    $response = $this->call('GET', '/admin/reviews');
    $this->assertTrue($response->status() == 200);
    $reviews = $response->getOriginalContent()->getData()['reviews'];
    $this->assertTrue($reviews != null);
  }

  public function testReviewsPageUser()
  {
    $response = $this->call('GET', '/users/show/1');
    $this->assertTrue($response->status() == 200);

    $avg_note = $response->getOriginalContent()->getData()['averageNote'];
    $this->assertTrue($avg_note != null);

    $reviews = $response->getOriginalContent()->getData()['reviews'];
    $this->assertTrue($reviews != null);
  }

  public function testStoreReview()
  {
    $user = new User();
    $user->id = 1;
    $this->be($user);
    $response = $this->call('POST', '/user/review', ['order_id' => 2, 'note' => 5, 'comment' => 'Bla bla bla bla']);
    $this->assertTrue($response->status() == 302);
  }

}
