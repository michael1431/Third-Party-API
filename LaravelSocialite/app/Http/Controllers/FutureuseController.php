<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FutureuseController extends Controller
{
    
	  /*
      // This code only used when we have separate table and we create reletionship to user and provider table 
        $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
                ]);

         $user->socialProviders()->create(

           ['provider_id'=> $getInfo->getId(), 'provider'=>$provider]
         );

         // Reletion build in SocialFacebook account Model

         protected $fillable = ['user_id', 'provider_id', 'provider'];

        public function user()
        {
            return $this->belongsTo(User::class);
        }
        // Reletion build in user model
        
         protected $fillable = [
        'name', 'email', 'password',
          ];

        public function socialProviders()
        {
            return $this->hasMany(SocialFacebookAccount::class);
        }

        // Database Schema

         Schema::create('social_facebook_accounts', function (Blueprint $table) {
          $table->integer('user_id')->unsinged()->references('id')->on('users');
          $table->string('provider_id');
          $table->string('provider');
          $table->timestamps();
        });

      */

}
