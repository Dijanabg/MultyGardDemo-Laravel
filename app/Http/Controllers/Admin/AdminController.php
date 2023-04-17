<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function dologin(Request $request){
        
        $request->validate([
            'email'=>'required|email|exists:admins,email',
            'password'=>'required|min:6|max:15'
        ],[
            'email.exists'=>"This email is not registred into our system!"
        ]);
        
        $check=$request->only('email','password');
        
        if(Auth::guard('admin')->attempt($check)){
            return redirect()->route('admin.home')->with('success', "Welcome to dashboard");
        }else{
            return redirect()->back()->with('error', "Login failed!");
        }
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
