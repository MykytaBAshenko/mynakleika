<?php

namespace App\Models\Traits\Method;

use App\Models\Customer;
use phpDocumentor\Reflection\Types\This;

/**
 * Trait CustomerMethod
 * @package App\Models\Traits\Method
 */
trait CustomerMethod
{
    /**
     * @return int
     */
    public function getAvailableBalance(): int
    {
        return $this->account + $this->credit_limit;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function increaseBalance(int $value): self
    {
        $this->account += $value;
        $this->save();

        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function decreaseBalance(int $value): self
    {
        $this->account -= $value;
        $this->save();

        return $this;
    }
}
