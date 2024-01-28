<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Income;
use App\Models\Invoice;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class InvoiceService
 * @package App\Services
 */
class InvoiceService
{
    /**
     * @var string
     */
    private $invoiceFileName = '';

    /**
     * @return string
     */
    public function getInvoiceFileName(): string
    {
        return $this->invoiceFileName;
    }

    /**
     * @param string $invoiceFileName
     * @return InvoiceService
     */
    public function setInvoiceFileName(string $invoiceFileName): InvoiceService
    {
        $this->invoiceFileName = $invoiceFileName;
        return $this;
    }

    /**
     * @param array $data
     * @return Invoice
     * @throws Exception
     */
    public function saveInvoice(array $data): Invoice
    {
        /* @var Customer $customer */
        $customer = Auth::user()->customer;
        DB::beginTransaction();

        try {
            $invoice = new Invoice();
            $invoice->legal_entity_id = Hashids::decode($data['legal_entity_id'])[0];
            $invoice->sum = $this->getInvoiceSum($data['orders']);
            $invoice->save();
            $invoice->orders()->attach($this->getInvoiceOrders($data['orders']));

            $customer->decreaseBalance($invoice->sum);

            Transaction::create([
                'customer_id' => $customer->id,
                'operation_id' => Transaction::OPERATION_WITHDRAWAL,
                'value' => $invoice->sum,
                'invoice_id' => $invoice->id
            ]);

            DB::commit();

            return $invoice;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param Invoice $invoice
     */
    public function saveInvoiceToPdf(Invoice $invoice): void
    {
        $amountWithVat = $invoice->orders()->sum('cost');
        $amount = round($amountWithVat / (1 + Invoice::VAT_RATE));
        $amountVat = $amountWithVat - $amount;
        $producer = (bool) $invoice->legalEntity->is_nds_payer
            ? (object) json_decode(option('tov'), true)
            : (object) json_decode(option('fop'), true);
        $orders = $invoice->orders;

        $pdf = resolve('Barryvdh\DomPDF\PDF');

        $invoiceData = [
            'invoice'       => $invoice,
            'amount'        => $amount,
            'pdv'           => $amountVat,
            'amount_wpdv'   => $amountWithVat,
            'producer'      => $producer,
            'receiver'      => $invoice->legalEntity,
            'orders'        => $orders
        ];

        $invoiceTemplate = (bool) $invoice->legalEntity->is_nds_payer
            ? 'customer.finance.invoices.tov_invoice_template'
            : 'customer.finance.invoices.fop_invoice_template'
        ;
        $pdf->loadView($invoiceTemplate, $invoiceData);
        $fileName = 'storage/invoices/' . $invoice->number .'.pdf';
        $pdf->setPaper('a4', 'portrait')->save($fileName);
        $this->setInvoiceFileName($fileName);
    }

    /**
     * @param Income $income
     * @throws Exception
     */
    public function updateInvoiceStatusOnIncome(Income $income)
    {
        try {
            $this->updateInvoiceStatus($income);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param Income $income
     * @return bool
     * @throws Exception
     */
    private function updateInvoiceStatus(Income $income): bool
    {
        $invoice = $income->invoice;

        if ($income->value === 0) {
            throw new Exception("Income sum must be greater than 0.");
        }

        if ($invoice->status === Invoice::STATUS_NOT_PAID) {
            $invoice->status = $income->value >= $invoice->sum
                ? Invoice::STATUS_PAID
                : Invoice::STATUS_PARTLY_PAID;
        } elseif ($invoice->status === Invoice::STATUS_PARTLY_PAID) {
            $payedSum = $invoice->getPayedSum();

            $invoice->status = $income->value >= $invoice->sum - $payedSum
                ? Invoice::STATUS_PAID
                : Invoice::STATUS_PARTLY_PAID;
        } else {
            throw new Exception("Invoice already payed");
        }

        return $invoice->save();
    }

    /**
     * @param array $orders
     * @return int
     */
    private function getInvoiceSum(array $orders): int
    {
        $sum = 0;
        foreach ($orders as $order) {
            $sum += $order['cost'];
        }

        return $sum;
    }

    /**
     * @param array $data
     * @return array
     */
    private function getInvoiceOrders(array $data): array
    {
        $orders = [];
        foreach ($data as $order) {
            $orders[] = (int)$order['id'];
        }

        return $orders;
    }
}
