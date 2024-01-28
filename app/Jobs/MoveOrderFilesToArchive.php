<?php

namespace App\Jobs;

use App\Services\FileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class MoveOrderFilesToArchive
 * @package App\Jobs
 */
class MoveOrderFilesToArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * @var int
     */
    private $orderId;

    /**
     * Create a new job instance.
     *
     * @param int $orderId
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @param FileService $fileService
     * @return void
     */
    public function handle(FileService $fileService)
    {
        try {
            $fileService->moveWorkFilesToArchive($this->orderId) ?: $this->release(60);
        } catch (\ErrorException $exception) {
            Log::error("[moveWorkFilesToArchive][order: " . $this->orderId . "] " . $exception->getMessage());
        }
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Log::error("[moveWorkFilesToArchive][order: " . $this->orderId . "] " . $exception->getMessage());
    }
}
