<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Users extends Controller
{   
    private $user;
    public function __construct(){
        $this->user = new User();
    }
    
    public function index(){
        $all_users = User::all();

        return view('users',['users'=>$all_users]);
    }
    
    public function register(Request $request){
        
        // $this->user = $request->all();
        // unset($this->user['_token']);
        $this->user->name = $request->name;
        $this->user->email = $request->email;
        $this->user->password = $request->password;
        $ret = $this->user->save();
        return back()->with('response', "User created. Go to login page!");
        // return DB::table('users')->insertGetId($this->user);
    }


    /* public function newPassword(Request $request){
        $this->user = $this->user->where('email',$request->email)->first();
        // $this->user->email = $request->email;
        $this->user->password = $request->password;
        $this->user->save();
        return redirect('login');
    } */

    public function updateRole(Request $request, $id)
    {
        $this->user = User::find($id);
        $this->user->role = $request->role;
        $this->user->save();

        return redirect('/users');
    }

    public function changeStatus($id)
    {
        $this->user = User::find($id);
        $this->user->status = $this->user->status == 1 ? 0 : 1;
        $this->user->save();

        return redirect('/users');
    }

    public function profile(){
        $user = Auth::user();
        return view('profile', ['user'=>$user]);
    }

    public function updateProfile(Request $request){

        $this->user = Auth::user();
        $request->validate([
            'name' => 'required',
            'password' => [
                'nullable',
                'min:8',
                'confirmed',
                function ($attribute, $value, $fail) {
                    if (Hash::check($value, $this->user->password )) {
                        $fail('The new password cannot be the same as your current password.');
                    }
                }
            ],
        ]);
        
        $this->user->name = $request->name;
        if ($request->filled('password')) {
            $this->user->password = $request->password;
        }

        if($this->user->isDirty()){
            $this->user->save();
            return redirect('/profile')->with('response', 'Profile updated successfully!');
        }else{
            return redirect('/profile')->with('response', 'No changes made!');
        }

    }
}
