<?php

namespace App\Models;

use App\Models\Traits\Relationship\TransactionRelationship;
use App\Models\Traits\TableName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * @package App\Models
 *
 * @property int    $id
 * @property int    $customer_id
 * @property int    $operation_id
 * @property int    $value
 * @property int    $invoice_id
 * @property int    $income_id
 * @property Carbon $created_at
 *
 * @property Income|null  $income
 * @property Invoice|null $invoice
 */
class Transaction extends Model
{
    use TransactionRelationship;
    use TableName;

    const OPERATION_WITHDRAWAL = 1;
    const OPERATION_INCOME = 2;

    protected $fillable = [
        'customer_id',
        'operation_id',
        'value',
        'invoice_id',
        'income_id',
        'entity_id',
    ];

    protected $dates = ['created_at'];

    public $timestamps = false;
}
