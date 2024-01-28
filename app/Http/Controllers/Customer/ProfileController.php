<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('customer.account.profile');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function update(Request $request)
    {
    	Auth::user()->update(
    		$request->only('first_name', 'last_name', 'mobile')
    	);

    	Auth::user()->customer->update(
    		$request->only('customer_name', 'customer_city', 'customer_address')
    	);

        return redirect()
        	->route('customer.profile.edit')
        	->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }
}
