<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function to_login(Request $request){

        if(isset($request->phone)) {
            $phone = $request->phone;
            $sms = $request->sms;
            //短信验证成功后 执行
            $user = User::firstOrCreate(['phone' =>  $phone]);
            
        } 
        // return $request;
        if(isset($request->username)){
            $username = $request->username;  
            $password = $request->password;
            $user = User::where('username',$username)->get();
            if($user!=null){
                $user = User::where('id',$user->id)->where('password',$password)->get();
            }else{
                $user = new User;
                $user->username = $username;
                $user->password = encrypt($password);
                $user->token = $username;
        
                $flight->save();
            }
           
        
        }  
        return $user;
    }
}
