<?php

namespace App\Http\Controllers;
 use Illuminate\Http\Request;
 use Validator,Redirect,Response,File;
 use Socialite;
 use App\User;
 use App\SocialFacebookAccount;
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
 
   $account = SocialFacebookAccount::where('provider_user_id', $getInfo->id)->first();
   //$user = User::where('provider_id', $getInfo->id)->first();
   if ($account) {
            // if exist then bring all his information for login
            return $account->user;
        }else{
          // otherwise create user information in socialaccount table
        	$account = new SocialFacebookAccount([
                'provider_user_id' => $getInfo->id,
                'provider' =>$provider
            ]);
          // check the user email already exist in user table or not
            $user = User::where('email',$getInfo->email)->first();

             if (!$user) {
                // jodi na takhe tahole user table e account create korbo
                $user = User::create([
                    'email' => $getInfo->email,
                    'name' => $getInfo->name,
                    'password' => md5(rand(1,10000)),
                ]);
            }

            return $user;
     }

  }
}
