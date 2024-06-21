<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DB;

class UserAccountController extends Controller
{
    public function getUserAccount(){
        return Auth::user();
    }

    public function updateUserAccount(Request $request){
        $id = Auth::user()->id;
        $validated = $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$id",
        ]);

        DB::table('users')
        ->where('id', Auth::user()->id)
        ->update([
        'name' => $request->name,
        'email' => $request->email
        ]);
        return $request->all();
    }

    public function updateUserAccountPassword(Request $request){
        $validated = $request->validate([
            'passwd' => 'required|min:8',
        ]);
        $password = bcrypt($request->passwd);
        DB::table('users')
        ->where('id', Auth::user()->id)
        ->update([
        'password' => $password
        ]);
        return;
    }
}
