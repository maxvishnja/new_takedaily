<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'mollie' => [
	    'client_id'     => env('MOLLIE_KEY'),
	    'client_secret' => env('MOLLIE_SECRET'),
//	    'redirect'      => env('MOLLIE_REDIRECT_URI'),
    ],


    'fbApi' => [
        'nl_active'     => 23842780430620212,
        'dk_active'     => 23842780326590212,
        'nl_not_active' => 23842780430740212,
        'dk_not_active' => 23842780327320212,
        'almost_nl'     => 23842780325910212,
        'almost_dk'     => 23842780323780212,
    ],

    'fbKey' => [
        'app_id'     => 734512456744699,
        'app_secret' => 'dbbe270880be0b26bb4df0d2a3df3ff7',
        'app_token' => 'EAAKcCQIRPvsBAJkwc5sAl0OW4YrleHtRUrjx1JcZCdTMFVz2WMjtnE3j0eYD8c5jc2hStzu8dp3ZB3i09NGmVMFvhjEucArFWRciSSGFZBpudgein6iihfpwXoee1AHtU3PMZAQOoXawXSZBO8BFLWOWi1M6y5DZBjxB3ZCkoXZCylzq7G5XgcciQ1EJwrZBveN0WKvpQA4tC3A6aGvNHgsVue6OYi2h3xJAZD',
    ],

];
