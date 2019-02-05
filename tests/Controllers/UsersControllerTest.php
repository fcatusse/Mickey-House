<?php

use App\Dish;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersControllerTest extends TestCase
{

    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        factory(User::class)->create();
        factory(Dish::class)->create();
    }

    public function testShowUserData()
    {
        $user = User::find(1);
        $this->assertInstanceOf(User::class, $user);

        $user_dishes = Dish::where('user_id', $user->id)->get();
        foreach ($user_dishes as $dish) {
            $this->assertInstanceOf(Dish::class, $dish);
        }
        $response = $this->get(route('user.show', $user->id));
        $response->assertStatus(200);

        $user_view = $response->getOriginalContent()->getData()['user'];
        $this->assertEquals($user_view->username, $user->username);
        $this->assertEquals($user_view->lastname, $user->lastname);
        $this->assertEquals($user_view->firstname, $user->firstname);
        $this->assertEquals($user_view->address, $user->address);

        $dishes_view = $response->getOriginalContent()->getData()['dishes'];
        foreach ($user_dishes as $key => $user_dish)
        {
            $this->assertEquals($user_dish->getAttributes(), $dishes_view[$key]);
        }
    }

    public function testShowUserWithWrongId()
    {
        $response = $this->get(route('user.show', 0));
        $response->assertStatus(404);
    }

    public function testEdit()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('user.edit', $user->id));
        $response->assertStatus(200);

        $user_view = $response->getOriginalContent()->getData()['data']['user']->getAttributes();
        $this->assertEquals($user_view['username'], $user->username);
        $this->assertEquals($user_view['email'], $user->email);
        $this->assertEquals($user_view['lastname'], $user->lastname);
        $this->assertEquals($user_view['firstname'], $user->firstname);
        $this->assertEquals($user_view['address'], $user->address);
        $this->assertEquals($user_view['city'], $user->city);
        $this->assertEquals($user_view['postal_code'], $user->postal_code);
    }

    public function testEditWithWrongId()
    {
        $response = $this->get(route('user.edit', 0));
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function testEditWithNoSession()
    {
        $user = User::find(1);
        $response = $this->get(route('user.edit', $user->id));
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function testUpdateProfile()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put(route('user.update', $user), ['username' => 'test', 'email' => 'test@test.com']);
        $response->assertStatus(302);
        //var_dump($response->getContent());
        $user = User::find(1);
        //var_dump($user);
        //$this->assertEquals($user->getAttributes()['username'], 'test');
    }

    public function testPasswordEdit()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('password.edit', $user->id));
        $response->assertStatus(200);
    }

    public function testPasswordEditWithWrongId()
    {
        $response = $this->get(route('password.edit', 0));
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function testPasswordEditWithNoSession()
    {
        $user = User::find(1);
        $response = $this->get(route('password.edit', $user->id));
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

}