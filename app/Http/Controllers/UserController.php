<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8'
        ]);
        $credentials=$request->only('email','password');
        if(Auth::attempt($credentials))
            {
                $request->session()->regenerate();
                $user=Auth::user();
                session([
                    'user_name'=>$user->name,
                    'user_role'=>$user->role
                ]);
                if($user->role ==='admin')
                    {
                        return redirect()->route('admin.dashboard');
                    }
                    return redirect()->route('user.dashboard');
            }
            return redirect('/');
    }
    public function register(Request $request)
    {
        
            $request->validate([
                'name'=> 'required',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:8|confirmed',
            ]);
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role'=>"user"
            ]);
            Auth::login($user);
            session([
                'user_name'=>$user->name,
                'user_role'=>$user->role,
            ]);
            return redirect()->route('userdashboard');
            
        
    }
    public function logout(Request $request)
    {
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
