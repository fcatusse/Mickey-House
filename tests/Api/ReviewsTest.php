<?php
use App\User;
use Tests\TestCase;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DishesController;
use App\Http\Controllers\ReviewsController;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ReviewsTest extends TestCase
{

  use WithoutMiddleware;
  // the function has to find a dish and show it. It returns to the view in case of success
  // and gives an error 404 in case of id not found

  public function testShowReviews()
  {
    $response = $this->call('GET', '/users/show/1');
    $response->assertViewHas('averageNote');
    $response->assertViewHas('reviews');
    $this->assertTrue($response->status() == 200);
    $this->assertTrue($response->original->getData()["reviews"][0]->note == 1);
  }

  public function testSaveNewReview() {
    $user = new User();
    $user->id = 1;
    $this->be($user);
    $response = $this->call('POST', '/user/review', ['order_id' => 2, 'note' => 5, 'comment' => 'Bla bla bla bla']);
    $this->assertTrue($response->status() == 302);
  }

}
