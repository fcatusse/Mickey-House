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

        $averageNote = $reviews->sum('note') / $reviews->count();
        
      }
      return response()->view('users.show', compact('user', 'dishes', 'reviews', 'averageNote'), 200);
    }
    return response()->view('error.error404', [], 404);
  }

  /**
  * Show the form for editing the current user's data.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $user = User::find($id);
    if ($user) {
      if (Auth::user()->id == $user->id) {
        $data = [
          'user' => $user,
        ];
        return view('users.edit')->with('data', $data);
      } else {
        return redirect()->action('HomeController@index');
      }
    } else {
      return response()->view('error.error404', [], 404);
    }
  }

  /**
   * Update the current user's data.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
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

      //Change the updated user in the database
      $user->update($data);

      Session::flash('alert-success', 'Profil édité avec succès');
      return redirect()->action('UsersController@show', [$user->id]);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function psw_edit($id)
  {
    $user = User::find($id);
  //  dd($user);
    if (Auth::user()->id == $user->id) {
      $data = [
        'user' => $user,
      ];
      return view('users.password')->with('data', $data);
    } else {
      return redirect()->action(['UserController@show', $user->id ]);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function psw_update(Request $request, User $user)
  {
      // Check & Collect the request data

      if ($request->new_psw == $request->new_psw_repeat && strlen($request->new_psw)>=6) {
        if (Hash::check($request->old_psw, $user->password)) {
          $user->password = Hash::make($request->new_psw);
          $user->save();
          Session::flash('alert-success', 'Profil édité avec succès');
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
