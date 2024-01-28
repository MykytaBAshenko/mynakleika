<?php

namespace App\Http\Controllers\Dtp;

use App\Http\Controllers\Controller;
use App\Services\FileService;

/**
 * Class FileController
 * @package App\Http\Controllers\Dtp
 */
class FileController extends Controller
{
    /**
     * @var FileService $fileService
     */
    private $fileService;

    /**
     * FileController constructor.
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param string $type
     * @param int $orderId
     */
    public function getLayout(string $type, int $orderId)
    {
        return $this->fileService->getLayout($type, $orderId);
    }
}
