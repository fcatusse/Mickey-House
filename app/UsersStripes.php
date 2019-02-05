<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersStripes extends Model
{

    public static function findCustomerForUser(int $user_id): ?string
    {
        $record = DB::table('users_stripes')
            ->select('customer_id')
            ->where('user_id', $user_id)
            ->first();
        if ($record === null)
        {
            return null;
        }
        return $record->customer_id;
    }

}
