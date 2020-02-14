<?php

namespace App\Services;
use App\SocialFacebookAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        // Check this social user already exist in our database
      $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();
            
        if ($account) {
            // if exist then bring all his information for login
            return $account->user;
        } else {
            // Otherwise create a new account for this soical user in socialfbaccount table
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' =>'facebook'
            ]);

            // Check if the email already exist in our database in user table 
            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                // jodi na takhe tahole user table e account create korbo
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
                ]);
            }
            // otherwise bring all his info
            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
