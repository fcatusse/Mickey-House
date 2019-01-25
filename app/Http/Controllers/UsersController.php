<?php

namespace App\Http\Controllers;

use App\User;
use App\Dish;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

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

      $dishes = DB::table('dishes')
      ->where('dishes.user_id', $id)
      ->get();
      foreach ($dishes as $dish) {
        $dish->photos = json_decode($dish->photos); // transfom json in string
        $dish->categories = json_decode($dish->categories); // transfom json in string

        //bget categories names
        $cat = DB::table('categories')
        ->whereIn('id', $dish->categories)
        ->get();
        $dish->categories = $cat;
      }

      //$dishes = []; /** Valeur par défaut */
      return response()->view('users.show', compact('user', 'dishes'), 200);
    }
    return response()->view('error.error404', [], 404);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $user = User::find($id);
  //  dd($user);
    if (Auth::user()->id == $user->id) {
      $data = [
        'user' => $user,
      ];
      return view('users.edit')->with('data', $data);
    } else {
      return redirect()->action('HomeController@index');
    }
  }

  /**
   * Update the specified resource in storage.
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

      //Add the new task in the database
      $user->update($data);

      Session::flash('alert-success', 'Profil édité avec succès');
      return redirect()->action('HomeController@index');
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
