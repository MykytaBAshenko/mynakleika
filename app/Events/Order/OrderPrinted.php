<?php

namespace App\Events\Order;

use App\Models\Order;
use Illuminate\Queue\SerializesModels;

/**
 * Class OrderPrinted
 * @package App\Events\Order
 */
class OrderPrinted
{
    use SerializesModels;

    /**
     * @var Order
     */
    public $order;

    /**
     * OrderPrinted constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
