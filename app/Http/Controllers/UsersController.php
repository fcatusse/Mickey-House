<?php

namespace App\Http\Controllers;

use App\User;
use App\Dish;
use Illuminate\Http\Response;
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

}
