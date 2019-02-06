<?php

use App\Dish;
use App\Follower;
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
        factory(User::class, 15)->create();
        factory(Dish::class, 15)->create();
    }

    public function testDisplayUsers()
    {
        $user = User::find(1);
        $users = User::where('id', '!=', $user->id)->get();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('user.index'));
        $response->assertStatus(200);
        $users_view = $response->getOriginalContent()->getData()['users'];

        foreach ($users as $key => $user)
        {
            $this->assertEquals($user->getAttributes(), $users_view[$key]->getAttributes());
        }
    }

    public function testDisplayUsersWithoutSession()
    {
        $response = $this->get(route('user.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function testShowUserData()
    {
        $user = User::find(1);
        $this->assertInstanceOf(User::class, $user);
        $user_dishes = Dish::where('user_id', $user->id)->get();
        if(!empty($user_dishes)) {
            foreach ($user_dishes as $dish) {
                $this->assertInstanceOf(Dish::class, $dish);
            }
        }

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('user.show', $user->id));

        $user_view = $response->getOriginalContent()->getData()['user'];
        $this->assertEquals($user_view->username, $user->username);
        $this->assertEquals($user_view->lastname, $user->lastname);
        $this->assertEquals($user_view->firstname, $user->firstname);
        $this->assertEquals($user_view->address, $user->address);

        if(count($user_dishes) === 0) {
            $dishes_view = $response->getOriginalContent()->getData()['dishes'];
            foreach ($user_dishes as $key => $user_dish)
          {
              $this->assertEquals($user_dish->getAttributes(), $dishes_view[$key]);
          }
        }
    }

    public function testShowUserWithWrongId()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('user.show', 0));
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
        $user->username = 'test';
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put(route('user.update'), [
                'username' => $user->username,
                'email' => $user->email,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'address' => $user-> address,
                'postal_code' => $user->postal_code,
                'city' => $user->city
            ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('user.show', $user->id));
        $user_update = User::find(1);
        $this->assertEquals($user->getAttributes()['username'], $user_update->getAttributes()['username']);
    }

    public function testUpdateProfileWithWrongParams()
    {
        $user = User::find(1);
        $user->username = null;
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put(route('user.update'), [
                'username' => $user->username,
                'email' => $user->email,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'address' => $user-> address,
                'postal_code' => $user->postal_code,
                'city' => $user->city
            ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testPasswordEdit()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('password.edit', $user->id));
        $response->assertStatus(200);
    }

    public function testUpdatePassword()
    {
        $user = User::find(1);
        $password = 'tester';
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('/users/password/'.$user->id, [
                'new_psw' => $password,
                'new_psw_repeat' => $password,
                'old_psw' => 'secret'
            ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('user.show', $user->id));
        $user_update = User::find(1);

        $this->assertTrue(\Illuminate\Support\Facades\Hash::check($password, $user_update->password));
    }

    public function testUpdatePasswordWithWrongOldPassword()
    {
        $user = User::find(1);
        $password = 'tester';
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('/users/password/'.$user->id, [
                'new_psw' => $password,
                'new_psw_repeat' => $password,
                'old_psw' => 'sec'
            ]);
        $response->assertStatus(302);
        $response->assertRedirect('/users/password/'.$user->id);
    }

    public function testUpdatePasswordWithWrongNewPasswordAndRepeatPassword()
    {
        $user = User::find(1);
        $password = 'tester';
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('/users/password/'.$user->id, [
                'new_psw' => $password,
                'new_psw_repeat' => 'test',
                'old_psw' => 'secret'
            ]);
        $response->assertStatus(302);
        $response->assertRedirect('/users/password/'.$user->id);
    }

    public function testUpdatePasswordWithTooShortNewPassword()
    {
        $user = User::find(1);
        $password = 'test';
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('/users/password/'.$user->id, [
                'new_psw' => $password,
                'new_psw_repeat' => $password,
                'old_psw' => 'secret'
            ]);
        $response->assertStatus(302);
        $response->assertRedirect('/users/password/'.$user->id);
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

    public function testFollowUser()
    {
        $user = User::find(1);
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('user.index'));
        $user_to_follow = User::find(2);
        $follow = new Follower;
        $follow->user_id = $user->id;
        $follow->follows_id = $user_to_follow->id;
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('follow', $user_to_follow->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('user.index'));
        $new_follow = Follower::find(1);
        $this->assertEquals($follow->getAttributes()['user_id'], $new_follow->getAttributes()['user_id']);
        $this->assertEquals($follow->getAttributes()['follows_id'], $new_follow->getAttributes()['follows_id']);
    }

    public function testUnfollowUser()
    {
        $user = User::find(1);
        $user_to_follow = User::find(2);
        $follow = new Follower;
        $follow->user_id = $user->id;
        $follow->follows_id = $user_to_follow->id;
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post(route('follow', $user_to_follow->id));

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->delete(route('unfollow', $user_to_follow->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('user.index'));
        $old_follow = Follower::find(1);
        $this->assertNull($old_follow);
    }



}
