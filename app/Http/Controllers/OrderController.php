<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Dish;
use App\User;
use Illuminate\Support\Facades\Session;
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
     * Store a newly created resource in storage and update another resource.
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
        return redirect('/');
      }

      $order = new Order;
      //in form_hidden
      $order->user_id = $request->input('user_id');
      $order->dish_id = $request->input('dish_id');
      //in form
      $order->nb_servings = $request->input('nb_servings');
      $order->price = $request->input('nb_servings') * $request->input('price');
      $order->save();

      $dish = Dish::find($request->input('dish_id'));
      $dish->nb_servings = $dish->nb_servings - $request->input('nb_servings');
      $dish->save();

      Session::flash('alert-success', 'The order has been passed!');
      return redirect('/'); //donne status 302
      //return response('Success', 200); //donnera status 200  - pour tester avec postman à localhost:8000/order/new
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
