<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class OrderRepository
 * @package App\Repositories
 */
class OrderRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Order::class;
    }

    /**
     * @param int $customerId
     * @param int $paged
     * @param string $orderBy
     * @param string $direction
     * @param string $filter
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getCustomerOrdersWithRelatedData(
        int $customerId,
        int $paged = 10,
        string $orderBy = 'created_at',
        string $direction = 'desc',
        string $filter = ''
    ): LengthAwarePaginator
    {
        $query = $this->model
            ->with(['file', 'material', 'delivery', 'invoice'])
            ->where('customer_id', $customerId)
            ->orderBy($orderBy, $direction)
        ;

        if (!empty($filter)) {
            $query->where('order_ref', 'like', '%'.$filter.'%');
        }

        return $query->paginate($paged);
    }
}
