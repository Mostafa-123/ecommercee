<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        return view('home.userpage');
    }
    public function redirect(){
        if(Auth::user()){
            $userType=Auth::user()->user_type;
            if($userType== 1){
                return view('admin.home');
            }else{
                return view('home.userpage');
            }
        }else{
            return redirect('/');
        }
        
    }
    public function logout(Request $request){
        Auth::guard(config('fortify.guard', 'web'))->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
