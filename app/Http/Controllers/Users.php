<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
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


    public function newPassword(Request $request){
        $user = $this->user->where('email',$request->email)->first();
        // $this->user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return redirect('login');
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::find($id);
        $user->role = $request->role;
        $user->save();

        return redirect('/users');
    }
}
