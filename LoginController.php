<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Users\UpdateProfileRequest;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
{
    
     public function  register(){

       return view('main.register');

     }


  public function signup(Request $request){
  
  $request->validate([
   
   'name' => 'required',
   'email' => 'required|email|unique:users',
   'password' => 'required',
  
  ]);
  $data = $request->all();
  $check = $this->create($data);
 
   return redirect('register');
   }


public function create(array $data){
  return User::create([
  'name' => $data['name'],
  'email' => $data['email'],
  'password'=> Hash::make($data['password'],['rounds' => '12'])

  ]);
}

public function login(Request $request){
$request->validate([
 'email' => 'required',
 'password' => 'required',   
]);

$credentials = $request->only('email', 'password');
if(Auth::attempt($credentials)){
	return redirect('dashboard')->with('message', 'Signed in');
}


return redirect('/signup')->with('message', 'Login or password is incorrect!');



}





public function dashboard(){
	if (Auth::check()) {
		return view('dashboard');
	}

	return redirect('/login');
}

public function kirish(){
  
  return view('welcome');

}


public function update(){
 
 return view('main.update')->with('user', Auth::user());
 
}

 public function update_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect()->back()->with('success', 'Profil yangilandi!');
    }









}
