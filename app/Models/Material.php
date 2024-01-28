<?php

namespace App\Models;

use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Attribute\MaterialAttribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Material
 * @package App\Models
 * @property int            $id
 * @property string         $material_name
 * @property string         $material_ref
 * @property double            $material_price
 * @property boolean        $in_stock
 * @property Order[]|null   $orders
 */
class Material extends Model
{
    use MaterialAttribute;
    use TableName;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'material_name',
        'material_ref',
        'material_price',
        'in_stock',
        'layoutW',
        'layoutH',
        'fieldW',
        'fieldH',
        'bleed',
        'cost_printing',
        'cost_cut',
        'quantity_factor',
        'mat_glanec_covering',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'in_stock' => 'boolean',
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
