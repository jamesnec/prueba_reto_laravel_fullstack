<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    public static function saveCreate($request) {
        $new_exchange                   = new Exchange;
        $new_exchange->amount           = $request['amount'];
        $new_exchange->origin           = $request['origin'];
        $new_exchange->destination      = $request['destination'];

        if ($new_exchange->save()) {
            return $new_exchange;
        }
    }

    public static function saveUpdate($request, $id) {
        $my_exchange                   = Exchange::find($id);
        $my_exchange->amount           = $request['amount'];
        $my_exchange->origin           = $request['origin'];
        $my_exchange->destination      = $request['destination'];

        if ($my_exchange->save()) {
            return $my_exchange;
        }
    }    
}
