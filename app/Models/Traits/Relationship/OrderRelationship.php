<?php

namespace App\Models\Traits\Relationship;

use App\Models\Customer;
use App\Models\Delivery;
use App\Models\File;
use App\Models\Invoice;
use App\Models\Material;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Trait OrderRelationship
 * @package App\Models\Traits\Relationship
 */
trait OrderRelationship
{
    /**
     * @return mixed
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    /**
     * @return mixed
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return mixed
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * @return mixed
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class)->withTrashed();
    }

    /**
     * @return mixed
     */
    public function invoice(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class);
    }
}
