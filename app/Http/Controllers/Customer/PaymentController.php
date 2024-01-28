<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\General\MoneyHelper;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PayGateOrder;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class PaymentController
 * @package App\Http\Controllers\Customer
 */
class PaymentController
{
    public function index()
    {
        /* @var Customer $customer */
        $customer = Auth::user()->customer;

        $legalEntities = $customer->legalEntities()
            ->select()
            ->verified()
            ->get()
            ->toArray();

        foreach ($legalEntities as &$legalEntity) {
            $legalEntity['id'] = Hashids::encode($legalEntity['id']);
        }
        unset($legalEntity);

        $systemLegalEntities = [
            'tov' => json_decode(option('tov'), true),
            'fop' => json_decode(option('fop'), true)
        ];

        return view('customer.finance.payments.index', [
            'legalEntities'         => $legalEntities,
            'systemLegalEntities'   => $systemLegalEntities
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function payByCard(Request $request): JsonResponse
    {
        $orders = array_column($request->post('orders', []), 'id');

        if (!empty($orders)) {
            $payGateOrder = new PayGateOrder();
            $payGateOrder->paygate_id = PayGateOrder::PAYGATE_PROVIDER_PORTMONE;
            $payGateOrder->save();
            $payGateOrder->orders()->attach($orders);

            return response()->json(['orderId' => Hashids::encode($payGateOrder->id)]);
        }

        return response()->json('error');
    }

    public function redirectToPaymentGate(Request $request)
    {
        $orderId = Hashids::decode($request->get('orderId', 0));

        if ($orderId) {
            /* @var PayGateOrder $payGateOrder */
            $payGateOrder = PayGateOrder::find($orderId)->first();

            $shopOrderNumber = sprintf(
                PayGateOrder::PAYGATE_PROVIDER_PREFIXES[$payGateOrder->paygate_id].'%09d',
                $payGateOrder->id
            );
            $billAmount = MoneyHelper::toString($payGateOrder->orders()->sum('cost'));

            return view('customer.finance.payments.portmone', [
                'shopOrderNumber'   => $shopOrderNumber,
                'billAmount'        => $billAmount,
            ]);
        }

        session()->flash('alert-error', 'Something bad happened');

        return redirect(route('customer.finance.payments'));
    }

    public function onSuccess(Request $request)
    {
        $shopOrderNumber = $request->post('SHOPORDERNUMBER', null);

        if ($shopOrderNumber) {
            $orderId = (int) filter_var($shopOrderNumber, FILTER_SANITIZE_NUMBER_INT);

            /* @var PayGateOrder $payGateOrder */
            $payGateOrder = PayGateOrder::find($orderId);
            $payGateOrder->status = PayGateOrder::STATUS_SUCCESS;
            $payGateOrder->bill_amount = $request->post('BILL_AMOUNT');
            $payGateOrder->shop_bill_id = $request->post('SHOPBILLID');
            $payGateOrder->card_mask = $request->post('CARD_MASK');
            $payGateOrder->approval_code = $request->post('APPROVALCODE');
            $payGateOrder->payed_at = Carbon::now();
            $payGateOrder->save();

            foreach ($payGateOrder->orders as $order) {
                $order->finance_status = Order::PAID;
                $order->production_status = Order::IN_PROGRESS;
                $order->save();
            }
        }

        return view('customer.finance.payments.success-payment', [
            'orders' => isset($payGateOrder) ? $payGateOrder->orders : []
        ]);
    }

    public function onFailure(Request $request)
    {
        return view('customer.finance.payments.rejected-payment');
    }
}
