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

       $dish[0]->photos = json_decode($dish[0]->photos); // transfom json in string
       $dish[0]->categories = json_decode($dish[0]->categories); // transfom json in string
       $cat = DB::table('categories')
       ->whereIn('id', $dish[0]->categories)
       ->get();
       $dish[0]->categories = $cat;

       $servings = [];
       for ($i = 1; $i <= $dish[0]->nb_servings; $i++) {
         $servings[$i] = $i;
       }

       return view('dishes.showDish', [
         'dish' => $dish,
         'servings' => $servings
       ]);
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
