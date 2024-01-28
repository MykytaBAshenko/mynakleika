<?php

namespace App\Http\Controllers\Customer;
use Illuminate\Support\Facades\Log;
use App\Helpers\General\FileHelper;
use App\Helpers\General\MoneyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Jobs\RemoveOrderFilesOnDelete;
use App\Models\Material;
use App\Models\Order;
use App\Services\FileService;
use App\Services\OrderService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

/**
 * Class OrderController.
 */
class OrderController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('customer.dashboard');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        // Get Materials in stock
        $materials = Material::select('id', 'material_name', 'material_price', 'layoutW', 'layoutH', 'fieldW', 'fieldH', 'bleed', 'cost_printing', 'cost_cut', 'quantity_factor', 'mat_glanec_covering')
        ->where('in_stock', true)
        ->get();
    
    Log::warning('This is a warning message.');
    
    $materials->transform(function ($item) {
        $item['mat_glanec_covering'] = json_decode($item['mat_glanec_covering']);
        $item['quantity_factor'] = json_decode($item['quantity_factor']);
        $item['cost_cut'] = json_decode($item['cost_cut']);
        $item['cost_printing'] = json_decode($item['cost_printing']);
    
        return $item;
    });
        $options = [
            "speedIndex" => array_map(function($item) {
                                    return (float) $item;
                                }, json_decode(option('speed_index'), true)),
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

        return view('customer.order.create', [
            'materials'     => $materials,
            'options'       => $options,
            'uploadRoute'   => 'customer.file.upload',
            'processRoute'  => 'customer.file.get_processed'
        ]);
    }

    /**
     * @param StoreOrderRequest $request
     * @param OrderService $orderService
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        Log::info($request);
        $orderService->create($request->validated());
        session()->flash('flash_success', __('alerts.customer.created'));

        return response()->json( ['redirect' => route('customer.dashboard')] );
    }

    /**
     * @param Order $order
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Order $order)
    {
        if ($order->production_status === Order::HOLD && $order->delete()) {
            session()->flash('flash_success', __('alerts.customer.deleted'));
            RemoveOrderFilesOnDelete::dispatch($order->id);

            return response()->json( ['redirect' => route('customer.dashboard')] );
        }

        return response()->json([null, 404]);
    }

}
