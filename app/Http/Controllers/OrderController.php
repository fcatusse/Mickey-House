<?php

namespace App\Http\Controllers;

use App\Api\Stripe;
use App\UsersStripes;
use Illuminate\Http\Request;
use App\Order;
use App\Dish;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Stripe\Card;
use Stripe\Charge;
use Stripe\Customer;

class OrderController extends Controller
{

    /**
     * @var Stripe
     */
    private $stripe;

    public function __construct()
    {
        $this->stripe = new Stripe(env('STRIPE_SECRET'));
    }

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
      // find dish corresponding to order and update the number of servings
      // remove the nb of servings that has just been ordered
      $dish = Dish::find($request->input('dish_id'));
      if ($dish->nb_servings > 0) {

        $total_price = (float) $request->input('nb_servings') * $request->input('price');
        $token = $request->input('stripeToken');
        $chargeId = null;
        if ($token) {
            $chargeId = $this->process($token, $total_price);
        }

        $dish->nb_servings = $dish->nb_servings - $request->input('nb_servings');
        $dish->save();

        $order = new Order;
        $order->user_id = $request->input('user_id');
        $order->dish_id = $request->input('dish_id');
        $order->nb_servings = $request->input('nb_servings');
        $order->price = $total_price;
        $order->sent = 0;
        if ($chargeId) {
            $order->charge_id = $chargeId;
        }
        $order->save();

        Session::flash('alert-success', 'Votre commande a été passée');
        return redirect('/dishes'); //donne status 302
      } else {
        Session::flash('alert-danger', 'Il y a eu un problème avec votre commande');
        return response()->view('dish.show.all', [], 400);
      }
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
      if ($orders) {
        //converts json into string
        foreach ($orders as $order) {
            $order->photos = json_decode($order->photos);
        }

        return view('users.orders', [
          'orders' => $orders,
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

    public function process(string $token, float $price)
    {
        $id = Auth::id();
        $card = $this->stripe->getCardFromToken($token);
        $customer = $this->findCustomerForUser($id, $token);
        if (!$this->hasCard($customer, $card))
        {
            var_dump("creation carte");
            $card = $this->stripe->createCardForCustomer($customer, $token);
        }
        /** @var Charge $charge */
        $charge = $this->stripe->createCharge([
            "amount" => $price * 100,
            "currency" => "eur",
            "source" => $card->id,
            "customer" => $customer->id,
            "description" => "Achat sur le site Mickey House"
        ]);
        return $charge->id;
    }

    /**
     * @param Customer $customer
     * @param Card $card
     * @return bool
     */
    private function hasCard(Customer $customer, Card $card): bool
    {
        $fingerprints = array_map(function($source) {
            return $source->fingerprint;
        }, $customer->sources->data);
        return in_array($card->fingerprint, $fingerprints);
    }

    /**
     * Get the client from the user id
     * @param int $id
     * @param string $token
     * @return Customer
     */
    private function findCustomerForUser(int $id, string $token): Customer
    {
        $custumerId = UsersStripes::findCustomerForUser($id);
        if ($custumerId)
        {
            $customer = $this->stripe->getCustomer($custumerId);
        } else {
            $user = User::findById($id);
            $customer = $this->stripe->createCustomer([
                'email' => $user->email,
                'source' => $token
            ]);
            $user_stripe = new UsersStripes();
            $user_stripe->user_id = $id;
            $user_stripe->customer_id = $customer->id;
            $user_stripe->created_at = date("Y-m-d H:i:s");
            $user_stripe->updated_at = date("Y-m-d H:i:s");
            $user_stripe->save();
        }
        /** @var Customer $customer */
        return $customer;
    }
}
