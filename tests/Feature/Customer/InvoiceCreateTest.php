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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class InvoiceCreateTest
 * @package Tests\Feature\Customer
 */
class InvoiceCreateTest extends TestCase
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
    public function the_invoice_can_be_created()
    {
        $invoice = factory(Invoice::class)->create([
            'legal_entity_id'   => 1,
            'sum'               => 25000,
        ]);

        $invoice->save();
        self::assertInstanceOf(Invoice::class, $invoice);
    }

    /** @test */
    public function the_invoice_has_count_by_day()
    {
        $invoice1 = factory(Invoice::class)->create([
            'legal_entity_id'   => 1,
            'sum'               => 25000,
        ]);

        $invoice1->save();

        $invoice2 = factory(Invoice::class)->create([
            'legal_entity_id'   => 1,
            'sum'               => 55000,
        ]);

        $invoice2->save();

        self::assertEquals(2, Invoice::today()->get()->count());
    }

    /** @test */
    public function the_invoice_can_be_saved_by_service()
    {
        $this->init();

        /* @var Order $order1 */

        $orderStubs = [
            'customer_id'       => $this->customer->id,
            'material_id'       => $this->material->id,
            'file_id'           => $this->file->id,
            'delivery_id'       => $this->delivery->id,
        ];

        $order1 = factory(Order::class)->create(array_merge($orderStubs, ['cost' => 180020]));

        $invoiceService = new InvoiceService();

        $invoice = $invoiceService->saveInvoice([
            "legal_entity_id" => $this->legalEntity->id,
            "type" => 1,
            "status" => 1,
            "create_date" => "2020-10-20 20:52:36",
            "payment_date" => null,
            "sum" => 1800.20,
            "specification" => null,
            "orders" => [
                $order1->id
            ],
        ]);

        $priceService = new PriceService();
        $fileService = new FileService();

        $orderService = new OrderService($fileService, $priceService);
        $incomeService = new IncomeService($invoiceService, $orderService);

        $income = $incomeService->saveIncome([
            'number'            => '234EW23ER',
            'value'             => 1000.00,
            'description'       => '',
            'legal_entity_id'   => $invoice->legal_entity_id,
            'invoice_id'        => $invoice->id,
            'payment_date'		=> $invoice->create_date
        ]);

        self::assertInstanceOf(Invoice::class, $invoice);
    }

}
