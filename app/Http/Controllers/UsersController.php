<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Response;

class UsersController extends Controller
{


    /**
     * Affiche les informations relatives à un cuisinier en fonction de son username
     *
     * @param  string  $username
     * @return Response
     */
    public function show(string $username): Response
    {
        $user = User::findByUsername($username);
        if ($user) {
            $user->complete_address = $user->address.' - '.$user->postal_code.' - '.$user->city;
            /**
             * En attente du model Dishes
            $dishes = Dishes::where('user_id_cook', $user->id)->where('is_visible', 1)->get();
            $dishes->photos = unserialize($dishes->photos);
             */
            $dishes = []; /** Valeur par défaut */
            return response()->view('users.show', compact('user', 'dishes'), 200);
        }
        return response()->view('error.error404', [], 404);
    }

}
