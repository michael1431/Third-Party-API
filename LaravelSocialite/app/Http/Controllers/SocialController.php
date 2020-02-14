<?php
 namespace App\Http\Controllers;
 use Illuminate\Http\Request;
 use Validator,Redirect,Response,File;
 use Socialite;
 use App\User;
 class SocialController extends Controller
 {
 public function redirect($provider)
 {
     return Socialite::driver($provider)->redirect();
 }
 public function callback($provider)
 {
   // get all the inforamtion of the user from his social media
   $getInfo = Socialite::driver($provider)->user(); 
   // Check user account has been created or not in our site
   $user = $this->createUser($getInfo,$provider); 
   // If success, then login
   auth()->login($user); 
   return redirect()->to('/home');
 }
 function createUser($getInfo,$provider){
  //Before creating account, we check if the provider id exist or not 
  // if exist , we don't need to create any account otherwise have to create account
 $user = User::where('provider_id', $getInfo->id)->first();
 if (!$user) {
      $user = User::create([
         'name'     => $getInfo->name,
         'email'    => $getInfo->email,
         'provider' => $provider,
         'provider_id' => $getInfo->id
     ]);

   }
   return $user;
 }
 }