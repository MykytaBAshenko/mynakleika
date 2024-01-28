<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\Traits\Method\CustomerMethod;
use App\Models\Traits\Relationship\CustomerRelationship;
use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Customer
 * @package App\Models
 * @property int    $id
 * @property int    $user_id
 * @property int    $manager_id
 * @property string $customer_name
 * @property string $customer_city
 * @property string $customer_address
 * @property int    $account
 * @property int    $credit_limit
 *
 * @property User               $user
 * @property Order[]|null       $orders
 * @property LegalEntity[]|null $legal_entities
 * @property Delivery[]         $deliveries
 * @property Invoice[]|null     $invoices
 * @property Transaction[]|null $transactions
 */
class Customer extends Model
{
    use CustomerMethod;
    use CustomerRelationship;
    use TableName;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
		'customer_name',
        'customer_city',
        'customer_address',
        'account',
        'credit_limit',
    ];
}
