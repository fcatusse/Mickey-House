<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Dish;
use App\User;


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
      //check the inputs
      if (!is_int($request->input('user_id')) || !is_int($request->input('dish_id')) || !is_int($request->input('nb_servings')) || !is_numeric($request->input('price'))) {
        return response('One or more inputs have the wrong type', 400);
      }

      $order = new Order;
      //in form_hidden
      $order->user_id = $request->input('user_id');
      $order->dish_id = $request->input('dish_id');
      //in form
      $order->nb_servings = $request->input('nb_servings');
      $order->price = $request->input('nb_servings') * $request->input('price');
      $order->save();
      return redirect(''); //donne status 302
      //return response('Success', 200); donnera status 200  - pour tester avec postamn à localhost:8000/order/new
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
