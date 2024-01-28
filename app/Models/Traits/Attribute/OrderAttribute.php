<?php

namespace App\Models\Traits\Attribute;

use Carbon\Carbon;

/**
 * Class OrderAttribute
 * @package App\Models\Traits\Attribute
 */
trait OrderAttribute
{
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->copy()->format('d.m.y');
    }

    public function getEndAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->copy()->format('d.m.y');
    }
}
