<?php

namespace App\Events\Income;

use App\Models\Income;
use Illuminate\Queue\SerializesModels;

/**
 * Class IncomeCreated
 * @package App\Events\Income
 */
class IncomeCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $income;

    /**
     * @param $income
     */
    public function __construct(Income $income)
    {
        $this->income = $income;
    }
}
