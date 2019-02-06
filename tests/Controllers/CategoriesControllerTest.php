<?php


use App\Categories;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{

    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        factory(Categories::class, 10)->create();
        factory(User::class)->create();
    }

    public function testDisplayCategories()
    {
        $user = User::find(1);
        $categories = Categories::all();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get(route('adminCat'));
        $response->assertStatus(200);
        $categories_view = $response->getOriginalContent()->getData()['categories'];
        foreach ($categories as $key => $category)
        {
            $this->assertEquals($category->getAttributes(), $categories_view[$key]->getAttributes());
        }
    }

    public function testDisplayCategoriesWithoutSession()
    {
        $response = $this->get(route('adminCat'));
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testShowFormCreate()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('admin/categories/create');
        $response->assertStatus(200);
    }

    public function testCreateCategory()
    {
        $category = new Categories();
        $category->title = 'test';
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post('admin/categories', $category->getAttributes());
        $response->assertStatus(302);
        $response->assertRedirect(route('adminCat'));
        $category_create = Categories::find(11);
        $this->assertEquals($category->getAttributes()['title'], $category_create->getAttributes()['title']);
    }

    public function testCreateWithWrongParams()
    {
        $category = new Categories();
        $category->title = null;
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->post('admin/categories', $category->getAttributes());
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $category_create = Categories::find(11);
        $this->assertNull($category_create);
    }
    
    public function testShowFormEdit()
    {
        $user = User::find(1);
        $category = Categories::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('admin/categories/'.$category->id);
        $response->assertStatus(200);
        $category_view = $response->getOriginalContent()->getData()['category']->getAttributes();
        $this->assertEquals($category_view['title'], $category->title);
    }

    public function testUpdateCategory()
    {
        $category = Categories::find(1);
        $category->title = 'test';
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('admin/categories/'.$category->id, ['title' => $category->title]);
        $response->assertStatus(302);
        $response->assertRedirect(route('adminCat'));
        $category_update = Categories::find(1);
        $this->assertEquals($category->getAttributes()['title'], $category_update->getAttributes()['title']);
    }

    public function testUpdateCategoryWithWrongId()
    {
        $user = User::find(1);
        $category = new Categories();
        $category->id = 0;
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('admin/categories/'.$category->id, ['title' => 'test']);
        $response->assertStatus(404);
    }

    public function testUpdateCategoryWithWrongParams()
    {
        $category = Categories::find(1);
        $category->title = null;
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->put('admin/categories/'.$category->id, ['title' => $category->title]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testDeleteCategory()
    {
        $user = User::find(1);
        $category = Categories::find(1);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->delete('admin/categories/'.$category->id);
        $response->assertStatus(302);
        $response->assertRedirect(route('adminCat'));
        $category_delete = Categories::find(1);
        $this->assertNull($category_delete);
    }

    public function testDeleteWithWrongId()
    {
        $user = User::find(1);
        $category = new Categories();
        $category->id = 0;
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->delete('admin/categories/'.$category->id);
        $response->assertStatus(404);
    }

}
