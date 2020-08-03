<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AppController extends Controller
{
    public function init(Request $request)
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }

    public function login(Request $request)
    {
        $input = request()->all();
        $user = User::where('username', $input['username']);
        $user->remember_token = bcrypt($request->username);

        if (Auth::attempt(['username' => $input['username'], 'password' => $input['password']])) {
            return response()->json(Auth::user(), 200);
        } else {
            return response()->json(['error' => 'Could not log you in.'], 401);
        }
    }
    public function register(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if (isset($user->id)) {
            return response()->json(['error' => 'Username already exists.'], 401);
        }
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->remember_token = bcrypt($request->username);
        $user->save();

        Auth::login($user);
        return response()->json($user, 200);
    }
    public function logout()
    {
        Auth::logout();
    }
    /*public function setCookie(Request $request)
    {
        $data =  Hash::make($request->username);
        
        return response()->json($data, 200);
        // return response('UserID')->cookie('UserID',$data, 60);
    }*/

    public function getCookie(Request $request)
    {
        $input = request()->all();
        if (Auth::attempt(['username' => $input['username'], 'password' => $input['password']])) {
            return response()->json(Auth::user(), 200);
        } else {
            return response()->json(['error' => 'Could not log you in.'], 401);
        }      
        
    }
}
