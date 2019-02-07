<?php

use App\Categories;
use App\Dish;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DishesControllerTest extends TestCase
{
      use RefreshDatabase;
      use DatabaseMigrations;

      public function setUp()
      {
          parent::setUp();
          factory(User::class, 15)->create();
          factory(Dish::class, 15)->create();
          factory(Categories::class, 15)->create();
      }

    public function testDisplayDishes()
    {
        $dishes = Dish::orderBy('created_at','desc')
            ->where('is_visible',1)
            ->paginate(4);
        foreach ($dishes as $dish) {
            $dish["photos"] = json_decode($dish["photos"]);
            $dish["categories"] = json_decode($dish["categories"]);
            $tmp_array = array();
            foreach ($dish["categories"] as $cat_id) {
                $tmp = Categories::where(['id' => $cat_id])->first(['title']);
                $tmp = $tmp["title"];
                array_push($tmp_array, $tmp);
            }
            $dish["cat_names"] = $tmp_array;
        }
        $response = $this->get(route('dish.show.all'));
        $response->assertStatus(200);

        $dishes_view = $response->getOriginalContent()->getData()['dishes'];
        foreach ($dishes as $key => $dish)
        {
            $this->assertEquals($dish->getAttributes(), $dishes_view[$key]->getAttributes());
        }
    }

    public function testDisplayDishesFromUserInSession()
    {
        $user = User::find(1);
        $dishes = Dish::where('dishes.user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($dishes as $dish) {
            $dish->photos = json_decode($dish->photos);
            $dish->categories = json_decode($dish->categories);
            $tmp_array = array();
            foreach ($dish->categories as $cat_id) {
                $tmp = Categories::where(['id' => $cat_id])->first(['title']);
                $tmp = $tmp["title"];
                array_push($tmp_array, $tmp);
            }
            $dish->cat_names = $tmp_array;
        }
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('dish.show.mine'));
        $response->assertStatus(200);

        $dishes_view = $response->getOriginalContent()->getData()['dishes'];
        foreach ($dishes as $key => $dish)
        {
            $this->assertEquals($dish->getAttributes(), $dishes_view[$key]->getAttributes());
        }
    }

    public function testDisplayDishesFromUserWithoutSession()
    {
        $response = $this->get('dish.show.mine');
        $response->assertStatus(404);
    }

    public function testShowFormCreate()
    {
        $user = User::find(1);
        $categories = Categories::all();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('create.dish'));
        $response->assertStatus(200);
        $categories_view = $response->getOriginalContent()->getData()['my_categories'];
        foreach ($categories as $key => $dish)
        {
            $this->assertEquals($dish->getAttributes()['title'], $categories_view[$key+1]);
        }
    }

    public function testCreateDish()
    {
        $user = User::find(1);
        $dish = new Dish();
        $dish->name = 'test';
        $dish->user_id = $user->id;
        $dish->description = 'description de test';
        $dish->photo1 = 'photo1';
        $dish->nb_servings = 4;
        $dish->price = 5.5;
        $dish->categorie1 = 'test';
        $dish->is_visible = true;
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('/dish/create', $dish->getAttributes());
        $response->assertStatus(302);
        $response->assertRedirect(route('user.show', $user->id));
        $dish_create = Dish::find(16);
        $this->assertEquals($dish->getAttributes()['name'], $dish_create->getAttributes()['name']);
        $this->assertEquals($dish->getAttributes()['user_id'], $dish_create->getAttributes()['user_id']);
        $this->assertEquals($dish->getAttributes()['description'], $dish_create->getAttributes()['description']);
        $this->assertEquals($dish->getAttributes()['nb_servings'], $dish_create->getAttributes()['nb_servings']);
        $this->assertEquals($dish->getAttributes()['price'], $dish_create->getAttributes()['price']);
        $this->assertEquals($dish->getAttributes()['is_visible'], $dish_create->getAttributes()['is_visible']);
        $this->assertEquals(json_encode([$dish->getAttributes()['categorie1']]), $dish_create->getAttributes()['categories']);
    }

    public function testCreateDishWithWrongParams()
    {
        $user = User::find(1);
        $dish = new Dish();
        $dish->name = null;
        $dish->user_id = $user->id;
        $dish->description = 'description de test';
        $dish->photo1 = 'photo1';
        $dish->nb_servings = 4;
        $dish->price = 5.5;
        $dish->categorie1 = 'test';
        $dish->is_visible = true;
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('/dish/create', $dish->getAttributes());
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testShowDish()
    {
        $dish = Dish::find(1);
        $this->assertInstanceOf(Dish::class, $dish);

        $cook = User::where('id','=', $dish->user_id)->get();
        $this->assertInstanceOf(User::class, $cook[0]);

        $response = $this->get(route('dish.show', $dish->id));
        $response->assertStatus(200);

        $dish_view = $response->getOriginalContent()->getData()['dish'][0];
        $this->assertEquals($dish_view->name, $dish->name);
        $this->assertEquals($dish_view->description, $dish->description);
    }

    public function testShowDishWithWrongId()
    {
        $response = $this->get(route('dish.show', 0));
        $response->assertStatus(404);
    }

    public function testShowFormEdit()
    {
        $user = User::find(1);
        $dish = Dish::find(1);
        $dish->user_id = 1;
        $dish->save();
        $categories = Categories::all();
        $all_categories = [];
        foreach ($categories as $category) {
            $all_categories[$category->id] = $category->title;
        }
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('dish/edit/'.$dish->id);
        $response->assertStatus(200);
        $dish_view = $response->getOriginalContent()->getData();
        $this->assertEquals($dish_view['name'], $dish->name);
        $this->assertEquals($dish_view['description'], $dish->description);
        $this->assertEquals($dish_view['photos'], json_decode($dish->photos));
        $this->assertEquals($dish_view['nb_servings'], $dish->nb_servings);
        $this->assertEquals($dish_view['price'], $dish->price);
        $this->assertEquals($dish_view['categories'], json_decode($dish->categories));
        $this->assertEquals($dish_view['is_visible'], $dish->is_visible);
        $this->assertEquals($dish_view['all_categories'], $all_categories);
    }

    public function testShowFormEditWithoutSession()
    {
        $response = $this->get('dish/edit/1');
        $response->assertStatus(302);
        $response->assertRedirect(route('dish.show.all'));
    }

    public function testUpdateDish()
    {
        $dish = Dish::find(1);
        $dish->user_id = 1;
        $dish->save();
        $user = User::find(1);
        $dish->name = 'test';
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('dish/edit/'.$dish->id, [
                'name' => $dish->name,
                'description' => $dish->description,
                'price' => $dish->price,
                'nb_servings' => $dish->nb_servings,
                'categorie1' => 'categorie1'
            ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('user.show', $user->id));
        $dish_update = Dish::find(1);
        $this->assertEquals($dish->getAttributes()['name'], $dish_update->getAttributes()['name']);
    }

    public function testMapDishes()
    {
        $user = User::find(1);
        $dishes = Dish::join('users', 'dishes.user_id', '=', 'users.id')
            ->select('dishes.*', 'users.username', 'users.id as cook_id', 'users.lat', 'users.long', 'users.address', 'users.postal_code', 'users.city')
            ->get();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('dish.map'));
        $response->assertStatus(200);
        $user_view = $response->getOriginalContent()->getData()['user'];
        $dishes_view = $response->getOriginalContent()->getData()['dishes'];
        $this->assertEquals($user->getAttributes(), $user_view->getAttributes());
        foreach ($dishes as $key => $dish)
        {
            $this->assertEquals($dishes[$key]->getAttributes()['name'], $dishes_view[$key]->name);
        }

    }

    public function testMapDishesWithoutSession()
    {
        $response = $this->get(route('dish.map'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

}
