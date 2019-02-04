<?php

namespace App\Http\Controllers;

use App\Dish;
use App\User;
use App\Order;
use App\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($order_id)
    {
        return view('reviews.index', [
            'order_id' => $order_id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|integer',
            'note' => 'required|integer',
            'comment' => 'required|string'
            ]);
            
        // dd($data);
        //Add the new review in the database
        $category = Reviews::create($data);
        Session::flash('alert-success', 'Thank you for your review !');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function show(Reviews $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function edit(Reviews $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reviews $reviews)
    {
        $orders = Order::all();
        foreach ($orders as $key => $value) {
            // Calculer en heures la différence entre today et la date de la commande
            $hours = (time() - strtotime($value->created_at)) / 3600;
            if($hours > 24 && !$value->sent)
            {
                // Mettre à jour la base de donnée
                $order = Order::find($value->id);
                $order->sent = 1;
                $order->save();

                // Send mail
                // $to = "reviews@mickeyhouse.com";
                // $subject = "Review your order";
                $msg = "http://localhost:8000/user/review/" . $value->id;
                // $headers = "From: webmaster@example.com";
                // mail($to,$subject,$msg,$headers);
                return $msg;
        //
    }
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reviews $reviews)
    {
        //
    }

    public function admin()
    {

        $reviews = DB::table('reviews')
        ->join('orders', 'orders.id', '=', 'reviews.order_id')
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->select('reviews.id as review_id', 'reviews.*', 'users.*')
        ->get();

        return view('admin.reviews.index', [
            'reviews' => $reviews
        ]);
    }

    public function delete($review)
    {
        $review = Reviews::find($review);
        $review->delete();
        Session::flash('alert-danger', 'The review has been deleted with success.');
        return redirect()->action('ReviewsController@admin');
    }
}