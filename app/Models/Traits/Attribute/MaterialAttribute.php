<?php

namespace App\Models\Traits\Attribute;

use App\Helpers\General\MoneyHelper;

/**
 * Trait MaterialAttribute.
 */
trait MaterialAttribute
{
    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if ($this->in_stock) {
            return '<span class="badge badge-success">'.__('labels.general.yes').'</span>';
        }

        return '<span class="badge badge-danger">'.__('labels.general.no').'</span>';
    }
}
