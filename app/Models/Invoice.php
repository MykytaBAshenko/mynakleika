<?php

namespace App\Models;

use App\Models\Traits\Attribute\InvoiceAttribute;
use App\Models\Traits\Method\InvoiceMethod;
use App\Models\Traits\Relationship\InvoiceRelationship;
use App\Models\Traits\Scope\InvoiceScope;
use App\Models\Traits\TableName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Invoice
 * @package App\Models
 * @property int    $id
 * @property int    $legal_entity_id
 * @property string $number
 * @property int    $status
 * @property int    $sum
 * @property Carbon $create_date
 * @property Carbon $payment_date
 *
 * @property LegalEntity                $legalEntity
 * @property Collection|Order[]|null    $orders
 * @property Collection|Income[]|null   $incomes
 */
class Invoice extends Model
{
	use InvoiceRelationship;
	use InvoiceAttribute;
	use InvoiceScope;
	use InvoiceMethod;
    use TableName;

	public const STATUS_NOT_PAID = 1;
	public const STATUS_PARTLY_PAID = 2;
    public const STATUS_PAID = 3;

    public const VAT_RATE = 0.2;

    public const INVOICE_STATUS = [
        'not_paid'          => self::STATUS_NOT_PAID,
        'partly_paid'       => self::STATUS_PARTLY_PAID,
        'paid'              => self::STATUS_PAID,
    ];

    protected $fillable = [
		'legal_entity_id',
		'status',
		'create_date',
		'payment_date',
		'sum'
	];

    // Return array that consists of ['payed', 'left'] values by invoice
    protected $appends = [
        'payments'
    ];

	protected $dates = ['create_date', 'payment_date'];

	public $timestamps = false;

	public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->number = config('app.invoice_prefix') .'-'.
                Carbon::now()->format(config('app.invoice_date_prefix')) .'-'.
                (string)((int)config('app.invoice_daystart_num') + self::getCountOfInvoicesForToday());
            $model->status = self::STATUS_NOT_PAID;
            $model->create_date = Carbon::now();
        });

        static::updating(function ($model) {
            $model->payment_date = Carbon::now();
        });
    }

	public function createDate()
	{
		return Carbon::now()->locale('uk')->isoFormat('DD MMMM YYYY', 'Do MMMM');
	}
}
