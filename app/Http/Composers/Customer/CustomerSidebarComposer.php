<?php

namespace App\Http\Composers\Customer;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Repositories\Backend\Auth\UserRepository;

/**
 * Class CustomerSidebarComposer
 */
class CustomerSidebarComposer
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * CustomerSidebarComposer constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param View $view
     *
     * @return bool|mixed
     */
    public function compose(View $view)
    {
        /**
         * Get manager info of current customer
         */
        $customer = Auth::user()->customer;

        /**
         * Production and Financial statuses view
         */
        $out = [
            'new'         => 0,
            'in_progress' => 0,
            'done'        => 0,
            'delivered'   => 0,
            'paid'        => 0,
            'not_paid'    => 0,
        ];

        $orders = \App\Models\Order::select('production_status', 'finance_status')
            ->where('customer_id', $customer->id)->get();

        foreach ($orders as $order) {
            switch ($order->production_status) {
                case Order::HOLD:
                    $out['new']++;
                    break;
                case Order::IN_PROGRESS:
                    $out['in_progress']++;
                    break;
                case Order::DONE:
                    $out['done']++;
                    break;
                case Order::SENT :
                    $out['delivered']++;
                    break;
            }

            switch ($order->finance_status) {
                case Order::PAID:
                    $out['paid']++;
                    break;
                case Order::NOT_PAID:
                    $out['not_paid']++;
                    break;
            }
        }
        $view->with('orders', (object) $out);
    }
}
