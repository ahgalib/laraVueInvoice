<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function service_list(){

        $data = Service::all();
        return response([
            'message' => 'success',
            'data'    => $data,
        ]);
    }
}
