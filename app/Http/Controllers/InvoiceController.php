<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Income;
use App\Models\Invoice;
use App\Models\LegalEntity;
use App\Models\Order;
use App\Services\InvoiceService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvoiceRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class InvoiceController
 * @package App\Http\Controllers
 */
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
		return view('customer.finance.invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        /* @var Customer $customer */
		$customer = Auth::user()->customer;

		// get legal_entities related to customer
		$legalEntities = $customer->legalEntities;

		// get balance
        $balance = $customer->getAvailableBalance();

		// get unpaid orders related to customer
        $notIncludedToBillsOrders = $customer->orders()
            ->with(['file', 'material', 'delivery'])
            ->notIncludedToBills()
            ->unpaidAndPartlyPaid()
            ->get();

		return view('customer.invoice.create', [
            'notIncludedToBillsOrders'  => $notIncludedToBillsOrders,
            'legalEntities'             => $legalEntities,
            'balance'                   => $balance,
            'invoiceStatus'             => Invoice::INVOICE_STATUS,
            'invoiceType'               => Invoice::INVOICE_TYPE,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInvoiceRequest $request
     * @param InvoiceService $invoiceService
     * @return JsonResponse
     * @throws Exception
     */
	public function store(StoreInvoiceRequest $request, InvoiceService $invoiceService)
    {
        $data = $request->all();
        $invoice = $invoiceService->saveInvoice($data);

        if ($invoice instanceof Invoice) {
            $invoiceService->saveInvoiceToPdf($invoice);
            session()->flash('flash_success', 'Счет успешно создан');

            return response()->json([
                'status'            => 'success',
                'redirect'          => route('customer.finance.invoices'),
                'invoiceFileName'   => $invoiceService->getInvoiceFileName()
            ]);
        } else {
            session()->flash('flash_error', 'Error while create invoice');
            return response()->json([
                'status'            => 'error'
            ]);
        }
	}

	public function getInvoices(Request $request): LengthAwarePaginator
    {
        /* @var Customer $customer */
        $customer = Auth::user()->customer;

        return DB::table(Invoice::getTableName() . ' as inv')
            ->where('c.id', $customer->id)
            ->leftJoin(LegalEntity::getTableName() . ' as le', 'inv.legal_entity_id', '=', 'le.id')
            ->leftJoin(Customer::getTableName(). ' as c', 'le.customer_id', '=', 'c.id')
            ->leftJoin('invoice_order as io', 'inv.id', '=', 'io.invoice_id')
            ->leftJoin(Order::getTableName(). ' as o', 'io.order_id', '=', 'o.id')
            ->leftJoin(Income::getTableName(). ' as inc', 'inv.id', '=', 'inc.invoice_id')
            ->select([
                'inv.id',
                'inv.number',
                'inv.create_date',
                'inv.payment_date',
                'inv.status',
                'inv.sum',
                'le.alias'
            ])
            ->selectRaw("group_concat(DISTINCT o.id ORDER BY o.id ASC SEPARATOR ', ') as orders")
            ->selectRaw("sum(inc.value) as paid")
            ->groupBy(['inv.id', 'inv.number', 'inv.create_date', 'inv.payment_date', 'inv.status', 'inv.sum', 'le.alias'])
            ->orderBy('inv.'.$request->get('orderBy'), $request->get('order'))
            ->paginate($request->get('size'));
    }
}
