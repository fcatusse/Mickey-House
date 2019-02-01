<?php

namespace App\Http\Controllers;

use DB;
use App\Dish;
use App\User;
use App\Reviews;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function showBest()
  {
    $users = DB::table('users')
    ->join('dishes', 'users.id', '=', 'dishes.user_id')
    ->join('orders', 'dishes.id', '=', 'orders.dish_id')
    ->join('reviews', 'orders.id', '=', 'reviews.order_id')
    ->selectRaw('avg(note) as avg_note, users.*')
    ->orderBy('avg_note','desc')
    ->groupBy('users.id')
    ->limit(10)
    ->get();

    return view('users.best', [
      'users' => $users,
    ]);
  }



  /**
  * Affiche les informations relatives à un cuisinier en fonction de son id
  *
  * @param  string  $id
  * @return Response
  */
  public function show(string $id): Response
  {
    $user = User::findById($id);
    if ($user) {
      $user->complete_address = $user->address.' - '.$user->postal_code.' - '.$user->city;
      // find dishes that are made by this cook
      $dishes = DB::table('dishes')
      ->where('dishes.user_id', $id)
      ->get();
      // converts json to string
      foreach ($dishes as $dish) {
        $dish->photos = json_decode($dish->photos);
        $dish->categories = json_decode($dish->categories);

        //find categories that are linked to this dish
        $cat = DB::table('categories')
        ->whereIn('id', $dish->categories)
        ->get();
        $dish->categories = $cat;

        // ------ HABIB ------ //
        // Load reviews & Join them with Order & Dish
        $reviews = DB::table('users')
            ->join('dishes', 'users.id', '=', 'dishes.user_id')
            ->join('orders', 'dishes.id', '=', 'orders.dish_id')
            ->join('reviews', 'orders.id', '=', 'reviews.order_id')
            ->get();

        if($reviews->count() != 0) {
          $averageNote = $reviews->sum('note') / $reviews->count();
        } else {
          // $averageNote = 'Pas de note';
        }

      }
      return response()->view('users.show', compact('user', 'dishes', 'reviews', 'averageNote'), 200);
    }
    return response()->view('error.error404', [], 404);
  }

  /**
  * Show the form for editing the current user's data.
  *
  *
  * @return \Illuminate\Http\Response
  */
  public function edit()
  {
    $user = User::find(Auth::user()->id);
    if ($user) {
        $data = [
          'user' => $user,
        ];
        return view('users.edit')->with('data', $data);
      } else {
        return response()->view('error.error404', [], 404);
      }
  }

  /**
   * Update the current user's data.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
      // Check & Collect the request data
      $data = $request->validate([
        'username' => 'required|string',
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'address' => 'required|string',
        'postal_code' => 'required|numeric|digits:5',
        'city' => 'required|string',
        'email' => 'required|string|email',
      ]);

      $json = file_get_contents("https://nominatim.openstreetmap.org/search/reverse?email=".config('app.email')."&format=json&street=".str_replace (' ' , '+' , $data['address']) ."&city=".$data['city']."&country=france&postalcode=".$data['postal_code']."&limit=1");
      $decoded = json_decode($json);
      $data['lat'] = $decoded[0]->lat;
      $data['long'] = $decoded[0]->lon;

      //Change the updated user in the database
      $user = User::find(Auth::user()->id);
      $user->update($data);

      Session::flash('alert-success', 'Profil édité avec succès');
      return redirect()->action('UsersController@show', [$user->id]);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function psw_edit()
  {
    $user = User::find(Auth::user()->id);
  //  dd($user);
    if ($user) {
      $data = [
        'user' => $user,
      ];
      return view('users.password')->with('data', $data);
    } else {
      return response()->view('error.error404', [], 404);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function psw_update(Request $request)
  {
      $user = User::find(Auth::user()->id);
      // Check & Collect the request data

      if ($request->new_psw == $request->new_psw_repeat && strlen($request->new_psw)>=6) {
        if (Hash::check($request->old_psw, $user->password)) {
          $user->password = Hash::make($request->new_psw);
          $user->save();
          Session::flash('alert-success', 'Mot de passe édité avec succès');
          return redirect()->action('UsersController@show', [$user->id]);
        } else {
          Session::flash('alert-danger', 'Le mot de passe actuel n\'est pas le bon');
          return redirect()->action('UsersController@psw_edit', [$user->id]);
        }
      } else {
        Session::flash('alert-danger', 'Le nouveau mot de passe n\'est pas valide');
        return redirect()->action('UsersController@psw_edit', [$user->id]);
      //return redirect()->action('HomeController@pindex');
      }

  }

}
