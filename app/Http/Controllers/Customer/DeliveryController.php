<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\StoreDeliveryRequest;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class DeliveryController.
 */
class DeliveryController extends Controller
{

	/**
	 * @return View
	 */
	public function index(): View
	{
		return view('customer.account.deliveries')->withDeliveries(
			auth()->user()->customer->deliveries
		);
	}

    /**
     * @param StoreDeliveryRequest $request
     * @return JsonResponse
     */
	public function store(StoreDeliveryRequest $request): JsonResponse
    {
        $validatedData = $request->all();

        $delivery = Delivery::create([
            'type'              => $validatedData['type'],
            'city'              => $validatedData['city'],
            'address'           => $validatedData['address'],
            'contact_person'    => $validatedData['contact_person'],
            'contact_phone'     => $validatedData['contact_phone'],
            'np_organization'   => $validatedData['np_organization'],
            'np_warehouse'      => $validatedData['np_warehouse'],
            'np_payer'          => $validatedData['np_payer'],
        ]);

        $delivery->save();
        auth()->user()->customer->deliveries()->attach($delivery);
        return response()->json(['status'=>'true']);
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return response()->json(['status'=>'true']);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get_customer_deliveries()
	{
		return auth()->user()->customer->deliveries;
	}
}
