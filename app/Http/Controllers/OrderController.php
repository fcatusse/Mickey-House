<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Dish;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return(1);
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

    }

    /**
     * Store a newly created order and update a dish (nb of servings).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAndUpdate(Request $request)
    {
      $data = $request->validate([
        'user_id' => 'required|integer',
        'dish_id' => 'required|integer',
        'nb_servings' => 'required|integer',
        'price' => 'required|numeric',
      ]);

      if ($data == false) {
        //return response('One or more inputs have the wrong type', 400);
        Session::flash('alert-danger', 'One or more inputs have the wrong type');
        return response()->view('dish.show.all', [], 400);
      }

      $order = new Order;
      $order->user_id = $request->input('user_id');
      $order->dish_id = $request->input('dish_id');
      $order->nb_servings = $request->input('nb_servings');
      $order->price = $request->input('nb_servings') * $request->input('price');
      $order->sent = 0;
      $order->save();

      // find dish corresponding to order and update the number of servings
      // remove the nb of servings that has just been ordered
      $dish = Dish::find($request->input('dish_id'));
      $dish->nb_servings = $dish->nb_servings - $request->input('nb_servings');
      $dish->save();

      Session::flash('alert-success', 'Votre commande a été passée');
      return redirect('/dishes'); //donne status 302
      //return response('Success', 200); //donnera status 200
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the orders of the currently authentified customer.
     * Calls the dishes table to get the detail of the order and
     * the users table to get name of the cook
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
      $orders = DB::table('orders')
      ->join('dishes', 'dishes.id', '=', 'orders.dish_id')
      ->join('users', 'users.id', '=', 'dishes.user_id')
      ->select('orders.*', 'dishes.name', 'dishes.description', 'dishes.photos', 'users.username')
      ->where('orders.user_id', Auth::user()->id)
      ->get();

      //converts json into string
      foreach ($orders as $order) {
          $order->photos = json_decode($order->photos);
      }

      return view('users.orders', [
        'orders' => $orders,
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
