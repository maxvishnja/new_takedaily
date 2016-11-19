<?php

namespace App\Http\Requests;

class CheckoutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    	if( \Auth::check())
	    {
	    	return [
			    'payment_method'  => 'required',
			    'stripeToken'     => 'required_if:payment_method,stripe'
		    ];
	    }

	    return [
		    'email'           => 'email|required|unique:users,email',
		    'name'            => 'required',
		    'address_street'  => 'required',
		    'address_zipcode' => 'required',
		    'address_city'    => 'required',
		    'address_country' => 'required',
		    'payment_method'  => 'required',
		    'stripeToken'     => 'required_if:payment_method,stripe',
		    'user_data'       => 'required'
	    ];
    }
}
