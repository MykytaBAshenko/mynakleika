<?php

namespace App\Models;

use App\Models\Traits\TableName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Delivery
 * @package App\Models
 *
 * @property int    $id
 * @property int    $type
 * @property string $city
 * @property string $address
 * @property string $contact_person
 * @property string $contact_phone
 * @property string $np_organization
 * @property string $np_warehouse
 * @property int    $np_payer
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Order[]|null $orders
 * @property Customer[]   $customers
 */
class Delivery extends Model
{
    use TableName, SoftDeletes;

	public const TYPE_PICKUP  = 1;
    public const TYPE_COURIER = 2;
    public const TYPE_SERVICE = 3;

    public const TYPES = [
        self::TYPE_PICKUP,
        self::TYPE_COURIER,
        self::TYPE_SERVICE
    ];

    public const PAYER_SENDER   = 1;
    public const PAYER_RECEIVER = 2;

    public const PAYERS = [
        self::PAYER_SENDER,
        self::PAYER_RECEIVER
    ];

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'type',
		'city',
		'address',
		'contact_person',
		'contact_phone',
		'np_organization',
		'np_warehouse',
		'np_payer'
	];

    /**
     * @return HasMany
     */
	public function orders(): HasMany
	{
		return $this->hasMany(Order::class);
	}

    /**
     * @return BelongsToMany
     */
	public function customers(): BelongsToMany
	{
		return $this->belongsToMany(Customer::class);
	}
}
