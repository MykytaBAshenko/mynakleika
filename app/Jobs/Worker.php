<?php

namespace App\Jobs;

/**
 * Class Worker
 * @package App\Jobs
 */
class Worker extends \Illuminate\Queue\Worker
{
    protected function supportsAsyncSignals()
    {
        return false;
    }
}
