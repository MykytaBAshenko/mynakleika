<?php

namespace App\Models\Traits\Relationship;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Trait PayGateOrderRelationship
 * @package App\Models\Traits\Relationship
 */
trait PayGateOrderRelationship
{
    /**
     * @return mixed
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
