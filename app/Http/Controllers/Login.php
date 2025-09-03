<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function __construct()
    {
        //
    }

    public function authenticateUser(Request $request) {
        
        $credentials = $request->validate([
            'email' => 'required|email:filter',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/Dashboard');
        }
        
        return back()->withErrors([
            'email' => 'Please enter a valid Username/Email ID',
            'password' => 'Please enter a valid Password',
        ]);

    }

    public function logoutUser(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect('login');

    }

    public function session(Request $request) {
        $data = $request->session()->all();
        return view("session", ["data"=>$data]);
    }
}
