<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function user_list(){

        $data = User::all();
        return response([
            'message' => 'success',
            'data'    => $data,
        ]);
    }

}
