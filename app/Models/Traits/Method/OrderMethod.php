<?php

namespace App\Models\Traits\Method;

/**
 * Trait OrderMethod
 * @package App\Models\Traits\Method
 */
trait OrderMethod
{
    /**
     * @param string $status
     * @return $this
     */
    public function setFinancialStatus(string $status)
    {
        $this->finance_status = $status;

        return $this;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setProductionStatus(string $status)
    {
        $this->production_status = $status;

        return $this;
    }
}
