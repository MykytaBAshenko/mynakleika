<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class FileProcessService
 * @package App\Services
 */
class FileProcessService
{
    private const BEFORE_CHECK_FILE_EXISTENCE_TIMEOUT = 5;
    private const CHECK_FILE_EXISTENCE_TIMEOUT = 2;
    private const CHECK_PREVIEW_EXISTENCE_TIMEOUT = 1;
    private const CHECK_FILE_EXISTENCE_RETRIES = 240;

    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var XmlProcessService
     */
    private $xmlProcessService;

    /**
     * @var string
     */
    private $fileName;

    /**
     * FileProcessService constructor.
     * @param FileService $fileService
     * @param XmlProcessService $xmlProcessService
     */
    public function __construct(FileService $fileService, XmlProcessService $xmlProcessService)
    {
        $this->fileService = $fileService;
        $this->xmlProcessService = $xmlProcessService;
    }

    /**
     * @param string $fileName
     * @return string|null
     * @throws FileNotFoundException
     * @throws \JsonException
     */
    public function processFile(string $fileName): ?string
    {
        $this->fileName = $fileName;
        sleep(self::BEFORE_CHECK_FILE_EXISTENCE_TIMEOUT);

        for ($i = 0; $i < self::CHECK_FILE_EXISTENCE_RETRIES; $i++) {
            if ($this->fileService->isFileExist($this->fileName, 'msgs.xml')) {
                sleep(self::CHECK_FILE_EXISTENCE_TIMEOUT);
                $this->xmlProcessService->setSxml(
                    $this->fileService->getFile($this->fileName, 'msgs.xml')
                );

                return $this->generateResponse();
            }

            sleep(self::CHECK_FILE_EXISTENCE_TIMEOUT);
        }

        return json_encode([
            'status'    => 'error',
            'message'   => __('alerts.customer.processing_timeout')
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * @return false|string
     * @throws \JsonException
     */
    private function generateResponse()
    {
        try {
            $processInfo = $this->xmlProcessService->processXmlPreflightData();
            $errors = $this->checkSizes($processInfo);

            if ($this->xmlProcessService->isErrors()) {
                $errors = array_merge($errors, $this->xmlProcessService->processXmlErrors());
            }

            if (!empty($errors)) {
                return json_encode([
                    'status'    => 'process_errors',
                    'errors'    => $errors,
                    'warnings'  => $this->xmlProcessService->processXmlWarnings()
                ], JSON_THROW_ON_ERROR);
            }

            for ($i = 0; $i < self::CHECK_FILE_EXISTENCE_RETRIES; $i++) {
                if ($this->checkProcessBundleExist()) {
                    $this->fileService->copyPreviewToWebServer($this->fileName);

                    return json_encode([
                        'process_info'      => $processInfo,
                        'preview_filename'  => $this->fileName,
                        'warnings'          => $this->xmlProcessService->processXmlWarnings(),
                    ], JSON_THROW_ON_ERROR);
                }

                sleep(self::CHECK_FILE_EXISTENCE_TIMEOUT);
            }

        } catch (FileNotFoundException $exception) {
            return json_encode([
                'status'    => 'error',
                'message'   => 'Something went wrong',
            ], JSON_THROW_ON_ERROR);
        }
    }

    /**
     * @return bool
     */
    private function checkProcessBundleExist(): bool
    {
        return $this->fileService->isFileExist($this->fileName, 'tn.jpg')
            && $this->fileService->isFileNonEmpty($this->fileName, 'tn.jpg')
            && $this->fileService->isFileExist($this->fileName, 'yml')
            && $this->fileService->isFileNonEmpty($this->fileName, 'yml')
            && $this->fileService->isFileExist($this->fileName, 'cut.pdf')
            && $this->fileService->isFileNonEmpty($this->fileName, 'cut.pdf')
            && $this->fileService->isFileExist($this->fileName, 'prn.pdf')
            && $this->fileService->isFileNonEmpty($this->fileName, 'prn.pdf');
    }

    /**
     * @param array $processInfo
     * @return array
     */
    private function checkSizes(array $processInfo): array
    {
        $errors = [];

        if (isset($processInfo['width']) && ($processInfo['width'] > (float) option('layoutW') - (float) option('fieldW') * 2)) {
            $errors[] = __('alerts.pitstop.errors.width');
        }

        if (isset($processInfo['height']) && ($processInfo['height'] > (float) option('layoutH') - (float) option('fieldH') * 2)) {
            $errors[] = __('alerts.pitstop.errors.height');
        }

        return $errors;
    }
}
