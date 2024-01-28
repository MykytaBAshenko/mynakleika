<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\General\FileHelper;
use App\Helpers\General\MoneyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreOrderRequest;
use App\Models\Delivery;
use App\Models\Material;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

/**
 * Class OrderController
 * @package App\Http\Controllers\Frontend
 */
class OrderController extends Controller
{
    public function create()
    {
        // Get Materials in stock
        $materials = Material::select('id', 'material_name', 'material_price')
            ->where('in_stock', true)
            ->get();

        $options = [
            'printCost' => array_map(function($item) {
                return (float) $item;
            }, json_decode(option('print_cost_guest_color'), true)),
            'euroCurrency'  => option('euro_currency'),
            'netCost' 		=> MoneyHelper::toString(option('net_cost')),
            'layoutW' 	    => option('layoutW'),
            'layoutH' 		=> option('layoutH'),
            'fieldW' 		=> option('fieldW'),
            'fieldH'		=> option('fieldH'),
            'bleed' 		=> option('bleed'),
            'minW' 		    => option('minW'),
            'minH' 		    => option('minH'),
            'maxFileSize'   => FileHelper::uploadMaxSizeInMb(),
        ];

        return view('frontend.order.create', [
            'materials'     => $materials,
            'options'       => $options,
            'uploadRoute'   => 'api.file.upload',
            'processRoute'  => 'api.file.get_processed'
        ]);
    }

    /**
     * @param StoreOrderRequest $request
     * @param OrderService $orderService
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $data = $request->validated();

        if ((int) $data['delivery']['type'] === Delivery::TYPE_PICKUP) {
            $delivery = Delivery::where('type', Delivery::TYPE_PICKUP)->first();
        } else {
            $delivery = Delivery::create($data['delivery']);
        }

        unset($data['delivery']);
        session(['order' => array_merge($data, ['delivery_id' => $delivery->id])]);

        return response()->json(['status' => 'success']);
    }
}
