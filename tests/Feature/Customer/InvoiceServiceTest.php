<?php

namespace Tests\Feature\Customer;

use App\Models\Auth\User;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\File;
use App\Models\Invoice;
use App\Models\LegalEntity;
use App\Models\Manager;
use App\Models\Material;
use App\Models\Order;
use App\Services\FileService;
use App\Services\IncomeService;
use App\Services\InvoiceService;
use App\Services\OrderService;
use App\Services\PriceService;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceServiceTest extends TestCase
{
    use RefreshDatabase;
    use SystemBehaviour;

    /**
     * @var User $user
     */
    private $user;

    /**
     * @var Customer $customer;
     */
    private $customer;

    /**
     * @var Manager $manager
     */
    private $manager;

    /**
     * @var LegalEntity $legalEntity
     */
    private $legalEntity;

    /**
     * @var Material $material
     */
    private $material;

    /**
     * @var File $file
     */
    private $file;

    /**
     * @var Delivery $delivery
     */
    private $delivery;

    /** @test */
    public function invoice_statuses_test()
    {
        $this->init();

        $invoiceService = new InvoiceService();
        $priceService = new PriceService();
        $fileService = new FileService();
        $orderService = new OrderService($fileService, $priceService);
        $incomeService = new IncomeService($invoiceService, $orderService);

        $orderStubs = [
            'customer_id'       => $this->customer->id,
            'material_id'       => $this->material->id,
            'file_id'           => $this->file->id,
            'delivery_id'       => $this->delivery->id,
        ];

        $order1 = factory(Order::class)->create(array_merge($orderStubs, ['cost' => 180020]));

        $invoice = $invoiceService->saveInvoice([
            "legal_entity_id" => $this->legalEntity->id,
            "status" => Invoice::STATUS_NOT_PAID,
            "create_date" => "2020-10-20 20:52:36",
            "payment_date" => null,
            "sum" => 180020,
            "orders" => [
                $order1->id
            ],
        ]);

        $incomeService->saveIncome([
            'number'            => '234EW23ER',
            'value'             => 1000,
            'description'       => '',
            'legal_entity_id'   => $invoice->legal_entity_id,
            'invoice_id'        => $invoice->id,
            'payment_date'		=> $invoice->create_date
        ]);

        /* @var Invoice $invoiceUpdated */
        $invoiceUpdated1 = Invoice::find($invoice->id);

        self::assertEquals($invoiceUpdated1->status, Invoice::STATUS_PARTLY_PAID);

        $incomeService->saveIncome([
            'number'            => '234EW23FF',
            'value'             => 500,
            'description'       => '',
            'legal_entity_id'   => $invoice->legal_entity_id,
            'invoice_id'        => $invoice->id,
            'payment_date'		=> Carbon::now()
        ]);

        $invoiceUpdated2 = Invoice::find($invoice->id);

        self::assertEquals($invoiceUpdated2->status, Invoice::STATUS_PARTLY_PAID);

        $incomeService->saveIncome([
            'number'            => '234EW23DD',
            'value'             => 300.2,
            'description'       => '',
            'legal_entity_id'   => $invoice->legal_entity_id,
            'invoice_id'        => $invoice->id,
            'payment_date'		=> Carbon::now()
        ]);

        $invoiceUpdated3 = Invoice::find($invoice->id);

        self::assertEquals($invoiceUpdated3->status, Invoice::STATUS_PAID);

        $this->expectException(Exception::class);
        $incomeService->saveIncome([
            'number'            => '234EW23EE',
            'value'             => 45.45,
            'description'       => '',
            'legal_entity_id'   => $invoice->legal_entity_id,
            'invoice_id'        => $invoice->id,
            'payment_date'		=> Carbon::now()
        ]);
    }
}
