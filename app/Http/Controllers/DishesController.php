<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use App\Order;
use App\Dish;
use App\User;
use DB;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DishesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishes = Dish::all();
        foreach ($dishes as $dish) {
            $dish["photos"] = json_decode($dish["photos"]); // transform json in string
            // $url = Storage::url('test.jpg');
            // return "<img src='".$url."'/>";

            $dish["categories"] = json_decode($dish["categories"]); // transfom json in string
            $tmp_array = array();
            foreach ($dish["categories"] as $cat_id) {
                $tmp = Categories::where(['id' => $cat_id])->first(['title']);
                $tmp = $tmp["title"];
                array_push($tmp_array, $tmp);
            }
            // $dish["test_photo"] = $tmp_photo;
            $dish["cat_names"] = $tmp_array;
        }

        return view('dishes.indexDish', compact('dishes'));

        // return view('dishes.testDish');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::all();
        // Construction du tableau pour alimenter les select de la view
        $my_categories = [];
        foreach ($categories as $category) {
            $my_categories[$category->id] = $category->title;
        }
        return view('dishes.createDish', compact('my_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Preparation du array pour les photos
        $my_photos = [];
        if ($request->file('photo1')) {
            $path_photo1 = $request->file('photo1')->store('public');
            $path_photo1 = preg_replace('/^public\//','',$path_photo1);
            array_push($my_photos, $path_photo1);
        }
        if ($request->file('photo2')) {
            $path_photo2 = $request->file('photo2')->store('public');
            $path_photo2 = preg_replace('/^public\//','',$path_photo2);
            array_push($my_photos, $path_photo2);
        }
        if ($request->file('photo3')) {
            $path_photo3 = $request->file('photo3')->store('public');
            $path_photo3 = preg_replace('/^public\//','',$path_photo3);
            array_push($my_photos, $path_photo3);
        }

        $dish = new Dish();
        $dish->user_id = 1;
        $dish->name = $request["name"];
        $dish->description = $request["description"];
        $dish->photos = json_encode($my_photos);
        $dish->nb_servings = $request["nb_servings"];
        $dish->price = $request["price"];
        $my_cat = [];
        if ($request["categorie1"]) {
            array_push($my_cat, $request["categorie1"]);
        }
        if ($request["categorie2"]) {
            array_push($my_cat, $request["categorie2"]);
        }
        if ($request["categorie3"]) {
            array_push($my_cat, $request["categorie3"]);
        }
        $dish->categories = json_encode($my_cat);
        $dish->is_visible = $request["is_visible"];
        $dish->save();

        return "Dish created !";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $dish = DB::table('dishes')
      ->join('users', 'dishes.user_id', '=', 'users.id')
      ->select('dishes.*', 'users.username')
      ->where('dishes.id', $id)
      ->get();
      //dump($dish);

      return view('dishes.showDish')->with('dish', $dish);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateServings(Request $request)
    {
      $dish = Dish::find($request->input('dish_id'));
      $dish->nb_servings = $dish->nb_servings - $request->input('nb_servings');
      $dish->save();

      return redirect('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
