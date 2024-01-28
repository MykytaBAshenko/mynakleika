<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends BaseController
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getTransactions(Request $request): LengthAwarePaginator
    {
        /* @todo validate request */
        /* @todo add default values */
        /* @var Customer $customer */
        $customer = Auth::user()->customer;
        $date = $request->get('date');

        return DB::table(Transaction::getTableName() . ' as t')
            ->where('t.customer_id', $customer->id)
            ->whereDate('t.created_at', '>=', $date)
            ->leftJoin('incomes as ic', 't.income_id', '=', 'ic.id')
            ->leftJoin('invoices as iv', 'ic.invoice_id', '=', 'iv.id')
            ->leftJoin('invoices as iv2', 't.invoice_id', '=', 'iv2.id')
            ->leftJoin('legal_entities as le', 'ic.legal_entity_id', '=', 'le.id')
            ->select('t.*', 'iv.number as iv_ic_number', 'iv2.number as iv_number', 'le.alias as legal_entity')
            ->orderBy('t.'.$request->get('orderBy'), $request->get('order'))
            ->paginate($request->get('size'));
    }
}
