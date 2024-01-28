<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $fields = [
            'orders.id',
            'orders.created_at',
            'orders.end_at',
            'orders.order_ref',
            'orders.order_comments',
            'files.name',
            'materials.material_name',
            'orders.format',
            'orders.quantity',
            'orders.chromaticity',
            'orders.lamination',
            'orders.production_status',
            'orders.finance_status',
            'orders.cost',
            'customers.customer_name',
            'deliveries.type',
            'deliveries.city',
            'deliveries.address',
            'deliveries.contact_person',
            'deliveries.contact_phone',
            'deliveries.np_organization',
            'deliveries.np_warehouse',
            'deliveries.np_payer',
        ];

        // select all customers of the manager
        $customers = \App\Models\Customer::where('manager_id',auth()->user()->manager->id)
            ->pluck('id');

        // select orders related to the manager
        $orders = \App\Models\Order::whereIn('customer_id', $customers)
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('materials', 'orders.material_id', '=', 'materials.id')
            ->join('deliveries', 'orders.delivery_id', '=', 'deliveries.id')
            ->join('files', 'orders.file_id', '=', 'files.id')
            ->get($fields);

        return view('manager.dashboard', compact(
            'orders'
        ));
    }
}
