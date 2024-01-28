<?php

namespace App\Models;

use App\Models\Traits\Relationship\PayGateOrderRelationship;
use App\Models\Traits\TableName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class PayGateOrder
 * @package App\Models
 * @property int    $id
 * @property int    $status
 * @property int    $paygate_id
 * @property string $shop_bill_id
 * @property string $bill_amount
 * @property string $card_mask
 * @property string $approval_code
 * @property Carbon $created_at
 * @property Carbon $payed_at
 * @property Collection|Order[]|null $orders
 */
class PayGateOrder extends Model
{
    use TableName;
    use PayGateOrderRelationship;

    const PAYGATE_PROVIDER_PORTMONE = 1;

    const PAYGATE_PROVIDER_PREFIXES = [
        self::PAYGATE_PROVIDER_PORTMONE => 'PRTMN'
    ];

    const PAYGATE_PROVIDERS = [
        self::PAYGATE_PROVIDER_PORTMONE
    ];

    const STATUS_REJECTED = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 2;

    protected $dates = ['created_at', 'payed_at'];

    public $timestamps = false;
}
