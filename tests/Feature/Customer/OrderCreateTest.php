<?php

namespace Tests\Feature\Customer;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\File;
use App\Models\Income;
use App\Models\Invoice;
use App\Models\LegalEntity;
use App\Models\Manager;
use App\Models\Material;
use App\Models\Order;
use App\Services\InvoiceService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_order_can_be_created()
    {
        /**
         * @var User $user
         * @var Customer $customer
         * @var Manager $manager
         * @var Material $material
         * @var File $file
         * @var Delivery $delivery
         * @var LegalEntity $legalEntity
         */

        $user = factory(User::class)->create([
            'email'     => 'dm.reznichenko@gmail.com',
            'active'    => true,
            'confirmed' => true,
        ]);

        $manager = factory(Manager::class)->create();
        $material = factory(Material::class)->create();
        $file = factory(File::class)->create();
        $delivery = factory(Delivery::class)->create();

        $customer = factory(Customer::class)->create([
            'customer_name'     => 'Alex',
            'customer_city'     => 'Kiev',
            'customer_address'  => 'Lavruhina str',
            'account'           => 0,
            'credit_limit'      => 0,
            'manager_id'        => $manager->id,
            'user_id'           => $user->id,
        ]);

        $customer->save();
        $this->be($user);

        /* @var Order $order1 */
        $order1 = factory(Order::class)->create([
            'customer_id'       => $customer->id,
            'material_id'       => $material->id,
            'file_id'           => $file->id,
            'delivery_id'       => $delivery->id,
            'cost'              => 21550,
        ]);

        /* @var Order $order2 */
        $order2 = factory(Order::class)->create([
            'customer_id'       => $customer->id,
            'material_id'       => $material->id,
            'file_id'           => $file->id,
            'delivery_id'       => $delivery->id,
            'cost'              => 23450,
        ]);

        $legalEntity = factory(LegalEntity::class)->create([
            'customer_id' => $customer->id,
        ]);

        $invoiceService = new InvoiceService();

        $invoice = $invoiceService->saveInvoice([
            'legal_entity_id'   => $legalEntity->id,
            'sum'               => 45000,
            'status'            => Invoice::STATUS_NOT_PAID,
            'orders'            => [
                $order1->id, $order2->id
            ]
        ]);

        $income1 = new Income();
        $income1->number = 1;
        $income1->payment_date = Carbon::now();
        $income1->invoice_id = $invoice->id;
        $income1->legal_entity_id = $legalEntity->id;
        $income1->value = 20000;
        $income1->save();

        $income2 = new Income();
        $income2->number = 2;
        $income2->payment_date = Carbon::now();
        $income2->invoice_id = $invoice->id;
        $income2->legal_entity_id = $legalEntity->id;
        $income2->value = 25000;
        $income2->save();

        $orderService = $this->app->make(OrderService::class);
//        $orderService->updateOrdersStatusOnIncome($income2);
//        dd($income2->invoice->orders);
//        $invoiceService->updateInvoiceStatusOnIncome($income2);

        $this->assertEquals(Invoice::STATUS_PAID, $income1->invoice->status);
//        $this->assertEquals(Invoice::STATUS_PAID, $income2->invoice->status);
    }

}
