<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request){
        // Validate the request data
     $incomingFields =   $request->validate([
            'name' => ['required', 'min:3', 'max:50',Rule::unique('users', 'name')],
            'email' => ['required', 'email', 'max:100',Rule::unique('users', 'email')],
            'password' => ['required', 'min:6', 'max:50'],
        ]);
        //hash the password and create the user
        $incomingFields['password'] = bcrypt($incomingFields['password']);
      $user=  User::create($incomingFields);
      auth()->login($user);

      return redirect('/');
        
    }

    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function login(Request $request){
        $incomingFields = $request->validate([
            'loginemail' => ['required', 'email'],
            'loginpassword' => ['required', 'min:6', 'max:50'],
        ]);

        if(auth()->attempt([
            'email' => $incomingFields['loginemail'],
            'password' => $incomingFields['loginpassword']
        ])){
            
$request->session()->regenerate();
        }

        return redirect('/');
        
    }
}
