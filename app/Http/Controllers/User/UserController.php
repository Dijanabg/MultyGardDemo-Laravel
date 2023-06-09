<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(Request $request){
        
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:15',
            'cpassword'=>'required|same:password'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $data = $user->save();
        if($data){
return redirect()->back()->with('success', "You have registered successfully!");
        }else{
            return redirect()->back()->with('error', "Registration failed!");
        }
    }
    public function dologin(Request $request){
        
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6|max:15'
        ]);
        
        $check = $request->only('email','password');
        
        if(Auth::guard('web')->attempt($check)){
            return redirect()->route('user.home')->with('success', "Welcome to dashboard");
        }else{
            return redirect()->back()->with('error', "Login failed!");
        }
    }
    public function logout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
