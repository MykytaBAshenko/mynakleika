<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileUploadRequest;
use App\Services\FileProcessService;
use App\Services\FileService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;

/**
 * Class FileController.
 */
class FileController extends Controller
{
    /**
     * @param FileUploadRequest $request
     * @param FileService $fileService
     * @return string
     */
    public function upload(FileUploadRequest $request, FileService $fileService)
    {
        // Retrieve the validated input data...
        $validatedData = $request->validated();
        $file = $validatedData['file'];
        return $fileService->upload($file);
    }

    /**
     * @param Request $request
     * @param FileProcessService $fileProcessService
     * @return false|string|null
     * @throws FileNotFoundException
     */
    public function getProcessed(Request $request, FileProcessService $fileProcessService)
    {
        // Get uploaded filename
        $fileName = $request->input('filename');
        return $fileProcessService->processFile($fileName);
    }

    /**
     * @param Request $request
     * @param FileProcessService $fileProcessService
     * @return string|null
     * @throws FileNotFoundException
     */
    public function getProcessedXml(Request $request, FileProcessService $fileProcessService)
    {
        // Get uploaded filename
        $fileName = $request->input('filename');
        return $fileProcessService->processFileTest($fileName);
    }

    /**
     * @param Request $request
     * @param FileService $fileService
     * @return bool
     */
    public function copyPreviewToWebServer(Request $request, FileService $fileService)
    {
        $fileName = $request->input('fileName');
        return $fileService->copyPreviewToWebServer($fileName);
    }
}
