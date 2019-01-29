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
     * Display the dish that corresponds to the id.
     * Calls the table dishes, the table users to retrieve the name of the cook
     * that we want to display in the view, and the table categories to retrieve
     * the name of the categories we have in this dish
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
       $find_dish = Dish::find($id);
       if ($find_dish) {
         $dish = DB::table('dishes')
         ->join('users', 'dishes.user_id', '=', 'users.id')
         ->select('dishes.*', 'users.username', 'users.id as cook_id')
         ->where('dishes.id', $id)
         ->get();

         // converts json into string for photos and categories
         $dish[0]->photos = json_decode($dish[0]->photos);
         $dish[0]->categories = json_decode($dish[0]->categories);

         // call to table categories
         $cat = DB::table('categories')
         ->whereIn('id', $dish[0]->categories)
         ->get();
         $dish[0]->categories = $cat;

         // create array of nb of servings from 1 to the total available nb of
         // servings for the selector in the form
         // display the price corresponding to the number of servings
         $servings = [];
         for ($i = 1; $i <= $dish[0]->nb_servings; $i++) {
           $servings[$i] = $i. " - ". $i*$dish[0]->price. "€";
         }

         // find other dishes from this cook
         $recommendations = DB::table('dishes')
         ->where([['user_id','=', $dish[0]->cook_id], ['id', '!=', $id]] )
         ->latest()
         ->limit(3)
         ->get();

         if ($recommendations) {
           foreach ($recommendations as $recommendation) {
               $recommendation->photos = json_decode($recommendation->photos);
           }
         }

         return view('dishes.showDish', [
           'dish' => $dish,
           'servings' => $servings,
           'recommendations' => $recommendations
         ]);
       } else {
         return response()->view('error.error404', [], 404);
       }
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
