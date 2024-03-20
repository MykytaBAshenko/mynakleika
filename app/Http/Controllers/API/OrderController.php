<?php

namespace App\Http\Controllers\API;

use App\Events\Order\OrderPrinted;
use App\Http\Requests\API\OrderUpdateRequest;
use App\Jobs\MoveOrderFilesToArchive;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\File;
use App\Models\Material;
use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends BaseController
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function list(Request $request): LengthAwarePaginator
    {
        /* @todo validate request */
        /* @var Customer $customer */
        $customer = Auth::user()->customer;

        return $customer->orders()
            ->with(['file', 'material', 'delivery', 'invoice'])
            ->where('order_ref', 'like', '%'.$request->get('filter').'%')
            ->orderBy($request->get('orderBy'), $request->get('order'))
            ->paginate($request->get('size'));
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function listForDtp(Request $request): LengthAwarePaginator
    {
        return DB::table(Order::getTableName() . ' as o')
            ->whereIn('o.production_status', [Order::IN_PROGRESS])
            ->leftJoin(File::getTableName() . ' as f', 'o.file_id', '=', 'f.id')
            ->leftJoin(Material::getTableName() . ' as m', 'o.material_id', '=', 'm.id')
            ->leftJoin(Delivery::getTableName() . ' as d', 'o.delivery_id', '=', 'd.id')
            ->select([
                'o.id',
                'o.order_ref',
                'o.order_comments',
                'o.format',
                'o.quantity',
                'o.lamination',
                'o.chromaticity',
                'o.production_status',
                'o.quantity_per_sheet',
                'o.end_at',
                'm.material_name',
                'f.name as file_name',
                'd.type as delivery_type',
                'd.address as delivery_address',
                'd.city as delivery_city',
                'd.np_warehouse as delivery_np_warehouse',
                'd.np_organization as delivery_np_organization',
                'd.np_payer as delivery_np_payer',
                'd.contact_person as delivery_contact_person',
                'd.contact_phone as delivery_contact_phone',
                'd.np_payer as delivery_np_payer',
            ])
            ->orderBy($request->get('orderBy'), $request->get('order'))
            ->paginate($request->get('size'));
    }

    public function listForPayment(Request $request): LengthAwarePaginator
    {
        /* @var Customer $customer */
        $customer = Auth::user()->customer;

        // get unpaid orders related to customer
        return $customer->orders()
            ->with(['file', 'material', 'delivery'])
            ->notIncludedToBills()
            ->unpaidAndPartlyPaid()
            ->paginate(15);
    }

    /**
     * @param OrderUpdateRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function update(OrderUpdateRequest $request, Order $order): JsonResponse
    {
        try {
            $order->update($request->validated());

            if ($order->production_status === Order::DONE && App::environment('production')) {
                event(new OrderPrinted($order));
                MoveOrderFilesToArchive::dispatch($order->id);
            }
            /* @todo send mail when job done or sended */
            return response()->json( ['status' => 'success'] );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json( ['status' => 'error'] );
        }
    }
}
