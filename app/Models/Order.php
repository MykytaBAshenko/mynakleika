<?php

namespace App\Models;

use App\Models\Traits\Attribute\OrderAttribute;
use App\Models\Traits\Method\OrderMethod;
use App\Models\Traits\Relationship\OrderRelationship;
use App\Models\Traits\Scope\OrderScope;
use App\Models\Traits\TableName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App\Models
 * @property int        $id
 * @property int        $customer_id
 * @property int        $file_id
 * @property int        $delivery_id
 * @property int        $material_id
 * @property int        $quantity
 * @property int        $quantity_per_sheet
 * @property string     $format
 * @property string     $order_ref
 * @property string     $order_comments
 * @property int        $production_status
 * @property int        $finance_status
 * @property int        $chromaticity
 * @property int        $lamination
 * @property int        $cost
 * @property int        $delivery_cost
 * @property Carbon     $created_at
 * @property Carbon     $end_at
 *
 * @property Customer   $customer
 * @property Delivery   $delivery
 * @property File       $file
 * @property Material   $material
 */
class Order extends Model
{
    use OrderAttribute;
    use OrderMethod;
    use OrderRelationship;
    use OrderScope;
    use TableName;

    // Production statuses
    public const HOLD = 1;
    public const IN_PROGRESS = 2;
    public const SENT = 3;
    public const DONE = 4;
    public const CANCELED = 5;

    // Financial statuses
    public const NOT_PAID = 1;
    public const PARTLY_PAID = 2;
    public const PAID = 3;

    // Chromaticity
    public const COLOR = 1;
    public const BW = 2;

    // Lamination
    public const NONE = 1;
    public const MATT = 2;
    public const GLOSS = 3;

    public const PRODUCTION_STATUS = [
        'hold'          => self::HOLD,
        'in_progress'   => self::IN_PROGRESS,
        'sent'          => self::SENT,
        'done'          => self::DONE,
        'canceled'      => self::CANCELED,
    ];

    public const FINANCIAL_STATUS = [
        'not_paid'      => self::NOT_PAID,
        'partly_paid'   => self::PARTLY_PAID,
        'paid'          => self::PAID,
    ];

    protected $table = "orders";

    protected $fillable = [
        'order_ref',
        'order_comments',
        'created_at',
        'end_at',
        'customer_id',
        'production_status',
        'finance_status',
        'file_id',
        'format',
        'quantity',
        'chromaticity',
        'lamination',
        'material_id',
        'cost',
        'delivery_cost',
        'delivery_id'
    ];

    protected $dates = ['created_at', 'end_at'];

    public $timestamps = false;
}
