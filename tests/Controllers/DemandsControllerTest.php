<?php

use App\Demand;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemandsControllerTest extends TestCase
{

    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        factory(Demand::class, 10)->create();
        factory(User::class)->create();
    }

    public function testDisplayDemands()
    {
        $user = User::find(1);
        $demands = Demand::all();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('/demands');
        $response->assertStatus(200);
        $demands_view = $response->getOriginalContent()->getData()['demands'];
        foreach ($demands as $key => $demand)
        {
            $this->assertEquals($demand->getAttributes(), $demands_view[$key]->getAttributes());
        }
    }

    public function testDisplayDemandsWithoutSession()
    {
        $response = $this->get('/demands');
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function testShowFormCreate()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('/user/demand');
        $response->assertStatus(200);
    }

    public function testCreateDemand()
    {
        $demand = new Demand();
        $demand->title = 'test';
        $demand->description = 'description test';
        $demand->budget = 2.2;
        $demand->phone = '0605040302';
        $demand->email = 'test@test.com';
        $demand->user_id = 1;
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post('/user/demand', $demand->getAttributes());
        $response->assertStatus(302);
        $response->assertRedirect('/home');
        $demand_create = Demand::find(11);
        $this->assertEquals($demand->getAttributes()['title'], $demand_create->getAttributes()['title']);
        $this->assertEquals($demand->getAttributes()['description'], $demand_create->getAttributes()['description']);
        $this->assertEquals($demand->getAttributes()['email'], $demand_create->getAttributes()['email']);
        $this->assertEquals($demand->getAttributes()['budget'], $demand_create->getAttributes()['budget']);
        $this->assertEquals($demand->getAttributes()['phone'], $demand_create->getAttributes()['phone']);
    }

    public function testCreateWithWrongParams()
    {
        $demand = new Demand();
        $demand->title = 'test';
        $demand->description = 'description test';
        $demand->budget = 2.2;
        $demand->phone = '0605040302';
        $demand->email = null;
        $demand->user_id = 1;
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post('/user/demand', $demand->getAttributes());
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $demand_create = Demand::find(11);
        $this->assertNull($demand_create);
    }

}