<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function to_login(Request $request){
        $phone = $request->phone;
        // return $phone;
        $sms = $request->sms;
        $user = User::firstOrCreate(['phone' => 18600611497]);
        return $user;

        $username = $request->username;
        $possword = $request->possword;
    }
}
