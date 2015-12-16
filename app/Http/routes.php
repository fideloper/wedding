<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/charge', function(Illuminate\Http\Request $request)
{
    $stripe = array(
        "secret_key"      => env('STRIPE_SECRET'),
        "publishable_key" => env('STRIPE_PUBLIC'),
    );

    \Stripe\Stripe::setApiKey($stripe['secret_key']);

    $error = false;

    try {
        $customer = \Stripe\Customer::create(array(
            'email' => $request->email,
            'card'  => $request->token,
        ));

        $charge = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount'   => $request->cents,
            'currency' => 'usd'
        ));
    } catch( \Stripe\Error\Base $e ) {
        $body = $e->getJsonBody();
        $error  = $body['error'];
    }

    if( $error )
    {
        return view('error', ['error' => $error]);
    }

    // success page
    return view('success');
});
