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
use App\Follower;
use App\Notifications\UserFollowed;

class UsersController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Users Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles functions related to the user.
  |
  | The function showBest returns the view of the best users, based on the
  | grades they got from their reviews. The 10 best users are displayed, or less
  | if there are less of them.
  |
  | The function index returns all users except the current one, for the view
  | allowing to follow/unfollow users.
  |
  | The function show returns the view of one specific user: his infos, his
  | dishes, his reviews if there are some and in this case his average grade.
  |
  | The function edit returns the view of the form allowing to edit a user.
  |
  | The function update saves the new user's data in the database.
  |
  | The function psw_edit returns the view of the form to edit one's password.
  | The function psw_update saves the new password.
  |
  | The functions follow and unfollow allow a user to follow/unfollow another
  | user. Once a user follow someone, they will get a notification when $this
  | person posts a new dish. A notification also appears when someone followss
  | you.
  |
  | The function notifications selects the 5 most recent notifications to
  | display them.
  |
  |
  */

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
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $users = User::where('id', '!=', auth()->user()->id)->get();
      return view('users.index', compact('users'));
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
      ->orderBy('created_at','desc')
      ->where([['dishes.user_id', '=', $id], ['is_visible','=',1]])
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
        }

        // Load reviews & Join them with Order & Dish
        $reviews = DB::table('users')
            ->join('dishes', 'users.id', '=', 'dishes.user_id')
            ->join('orders', 'dishes.id', '=', 'orders.dish_id')
            ->join('reviews', 'orders.id', '=', 'reviews.order_id')
            ->where('dishes.user_id','=', $id)
            ->select('users.*', 'reviews.*', 'dishes.*','orders.user_id as client_id')
            ->get();

        foreach($reviews as $review) {
          $client = DB::table('users')
          ->where('id','=',$review->client_id)
          ->get();
        //  dd($client);
          $review->client_name = $client[0]->username;
        }

        if($reviews->count() != 0) {
          $averageNote = $reviews->sum('note') / $reviews->count();
        } else {
          $averageNote = -1;
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

      // reverse geocoding of the address to get the coordinates
      $json = file_get_contents("https://nominatim.openstreetmap.org/search/reverse?email=".config('app.email')."&format=json&street=".$this->formatAddress($data['address'])."&city=".$this->formatAddress( $data['city'])."&country=france&postalcode=".$data['postal_code']."&limit=1");
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
   *
   * @param  $address string
   * @return string
   */
  public function formatAddress($address)
  {
    $arr = [' ', '-'];
    $address = str_replace ($arr , '+' , $address);
    $address = str_replace ('\'' , '' , $address);
    return $address;
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


  public function follow($userId)
  {
    $user = User::where('id', '=', $userId)->get();
  //  dd($user);
    $current = auth()->user();
    $text = "vous suit";

    $follow = new Follower;
    $follow->user_id = Auth::user()->id;
    $follow->follows_id = $userId;
    $follow->save();
    foreach($user as $followed) {
    $followed->notify(new UserFollowed($current, $text));
    //$followed->notify(new UserFollowed($current));
    }

    return back()->withSuccess("You are now following {$user[0]->username}");
    //return redirect()->action('UsersController@index');
  }


    /**
  * Remove the specified resource from storage.
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function unfollow($userId)
  {
    $follow = Follower::where([['user_id', '=', Auth::user()->id], ['follows_id', '=', $userId]]);;
    //dd($follow);
    $follow->delete();
    return redirect()->action('UsersController@index');
  }


  public function notifications()
  {
    //return last 5 unread notifications
    return Auth::user()->unreadNotifications()->limit(5)->get()->toArray();
  }

}
