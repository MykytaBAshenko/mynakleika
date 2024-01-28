<?php

namespace App\Services;

use App\Helpers\General\MoneyHelper;
use App\Models\Income;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class IncomeService
 * @package App\Services
 */
class IncomeService
{
    /**
     * @var InvoiceService
     */
    private $invoiceService;

    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * IncomeService constructor.
     * @param InvoiceService $invoiceService
     * @param OrderService $orderService
     */
    public function __construct(InvoiceService $invoiceService, OrderService $orderService)
    {
        $this->invoiceService = $invoiceService;
        $this->orderService = $orderService;
    }

    /**
     * @param array $data
     * @return Income
     * @throws Exception
     */
    public function saveIncome(array $data): Income
    {
        DB::beginTransaction();
        try {
            $income = new Income($data);
            $income->value = MoneyHelper::parseToInt($data['value']);
            $income->create_date = Carbon::now();
            $income->payment_date = Carbon::parse($data['payment_date'])->addHours(2);

            $this->invoiceService->updateInvoiceStatusOnIncome($income);
            $this->orderService->updateOrdersStatusOnIncome($income);

            $customer = $income->invoice->legalEntity->customer;
            $customer->increaseBalance($income->value);

            Transaction::create([
                'customer_id'  => $customer->id,
                'operation_id' => Transaction::OPERATION_INCOME,
                'value'        => $income->value,
                'income_id'    => $income->id
            ]);

            $income->save();
            DB::commit();
            $this->orderService->scheduleOrdersFileTransfer($income->invoice->orders);

            return $income;
        } catch (\Exception $exception) {
            DB::rollBack();

            throw new Exception($exception->getMessage());
        }
    }

}
