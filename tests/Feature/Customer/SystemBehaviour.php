<?php

namespace Tests\Feature\Customer;

use App\Models\Auth\User;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\File;
use App\Models\LegalEntity;
use App\Models\Manager;
use App\Models\Material;

/**
 * Trait SystemBehaviour
 * @package Tests\Feature\Customer
 */
trait SystemBehaviour
{
    public function init(): void
    {
        $this->user = factory(User::class)->create([
            'email'     => 'dm.reznichenko@gmail.com',
            'active'    => true,
            'confirmed' => true,
        ]);

        $this->manager = factory(Manager::class)->create();
        $this->material = factory(Material::class)->create();
        $this->file = factory(File::class)->create();
        $this->delivery = factory(Delivery::class)->create();

        $this->customer = factory(Customer::class)->create([
            'customer_name'     => 'Alex',
            'customer_city'     => 'Kiev',
            'customer_address'  => 'Lavruhina str',
            'account'           => 0,
            'credit_limit'      => 0,
            'manager_id'        => $this->manager->id,
            'user_id'           => $this->user->id,
        ]);
        $this->customer->save();
        $this->be($this->user);

        $this->legalEntity = factory(LegalEntity::class)->create([
            'customer_id' => $this->customer->id,
        ]);
    }
}
