<?php

namespace App\Models;

use App\Models\Traits\TableName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Income
 * @package App\Models
 * @property int    $id
 * @property int    $legal_entity_id
 * @property int    $invoice_id
 * @property string $number
 * @property int    $value
 * @property string $description
 * @property Carbon $create_date
 * @property Carbon $payment_date
 *
 * @property LegalEntity $legalEntity
 * @property Invoice     $invoice
 */
class Income extends Model
{
    use TableName;

    protected $fillable = [
		'number',
		'payment_date',
		'value',
		'description',
		'legal_entity_id',
		'invoice_id'
	];

	protected $dates = ['create_date', 'payment_date'];

	public $timestamps = false;

    /**
     * @return BelongsTo
     */
	public function legalEntity(): BelongsTo {
		return $this->belongsTo(LegalEntity::class);
	}

    /**
     * @return BelongsTo
     */
	public function invoice(): BelongsTo {
		return $this->belongsTo(Invoice::class);
	}

	public function setPaymentDateAttribute($date)
	{
		$this->attributes['payment_date'] = Carbon::parse($date);
	}
}
