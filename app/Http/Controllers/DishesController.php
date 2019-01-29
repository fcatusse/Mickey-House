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

        return view('dishes.indexDish', compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::all();
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
        // Validate
        $request->validate([
            'categorie1' => 'required',
            'photo1' => 'required',
            'nb_servings' => 'integer|min:0',
            'price' => 'integer|min:0',
        ]);

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
        if (isset($request["is_visible"])) {
            $dish->is_visible = $request["is_visible"];
        } else {
            $dish->is_visible = 0;
        }
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
    public function edit(Dish $dish)
    {
        // Get all categories list
        $categories = Categories::all();
        $all_categories = [];
        foreach ($categories as $category) {
            $all_categories[$category->id] = $category->title;
        }

        // Get Dish info
        $dish->photos = json_decode($dish->photos);
        $dish->categories = json_decode($dish->categories);

        return view('dishes.editDish', [
            'name' => $dish->name,
            'description' => $dish->description,
            'photos' => $dish->photos,
            'nb_servings' => $dish->nb_servings,
            'price' => $dish->price,
            'categories' => $dish->categories,
            'is_visible' => $dish->is_visible,
            'all_categories' => $all_categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        // Validate
        $request->validate([
            'categorie1' => 'required',
            'nb_servings' => 'integer|min:0',
            'price' => 'integer|min:0',
        ]);

        // Preparation du array pour les photos
        $dish->photos = json_decode($dish->photos);

        $my_photos = [];
        if ($request["del_photo1"] != 1) {
            if ($request->file('photo1')) {
                $path_photo1 = $request->file('photo1')->store('public');
                $path_photo1 = preg_replace('/^public\//', '', $path_photo1);
                array_push($my_photos, $path_photo1);
            } else {
                if (isset($dish->photos[0])) {
                    array_push($my_photos, $dish->photos[0]);
                }
            }
        }
        if ($request["del_photo2"] != 1) {
            if ($request->file('photo2')) {
                $path_photo2 = $request->file('photo2')->store('public');
                $path_photo2 = preg_replace('/^public\//', '', $path_photo2);
                array_push($my_photos, $path_photo2);
            } else {
                if (isset($dish->photos[1])) {
                    array_push($my_photos, $dish->photos[1]);
                }
            }
        }
        if ($request["del_photo3"] != 1) {
            if ($request->file('photo3')) {
                $path_photo3 = $request->file('photo3')->store('public');
                $path_photo3 = preg_replace('/^public\//', '', $path_photo3);
                array_push($my_photos, $path_photo3);
            } else {
                if (isset($dish->photos[2])) {
                    array_push($my_photos, $dish->photos[2]);
                }
            }
        }

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
        if (isset($request["is_visible"])) {
            $dish->is_visible = $request["is_visible"];
        } else {
            $dish->is_visible = 0;
        }

        $dish->save();

        return "Dish update !";
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        Session::flash('alert-danger', 'The dish has been deleted with success.');
        return "Dish deleted !";
    }
}
