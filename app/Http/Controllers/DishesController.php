<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Dish;
use App\User;
use DB;

class DishesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // dd(json_encode(["tarte01.jpg","tarte02.jpg","tarte03.jpg"]));

        $dishes = Dish::all();
        foreach ($dishes as $dish) {
            $dish["photos"] = json_decode($dish["photos"]); // transfom json in string
            $dish["categories"] = json_decode($dish["categories"]); // transfom json in string
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
       $find_dish = Dish::findById($id);
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

         return view('dishes.showDish', [
           'dish' => $dish,
           'servings' => $servings
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
