<?php

namespace App\Services;

use App\Helpers\General\LayoutHelper;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\Yaml\Yaml;
use App\Models\Material;

/**
 * Class FileService
 * @package App\Services
 */
class FileService
{
    /**
     * @var Filesystem
     */
    private $public;

    /**
     * @var Filesystem
     */
    private $ftp;

    /**
     * @var string
     */
    private $inputFolder;

    /**
     * @var string
     */
    private $outputFolder;

    /**
     * @var string
     */
    private $impositionInFolder;

    /**
     * @var string
     */
    private $impositionOutFolder;

    /**
     * @var string
     */
    private $impositionDoneFolder;

    /**
     * @var string
     */
    private $archiveFolder;

    /**
     * @var string
     */
    private $worksDir;

    public const PREVIEW_FILE_EXTENSION = "tn.jpg";

    public const PRINT_AND_CUT_FILE_EXT = [
        '.prn.imp.pdf',
        '.cut.imp.pdf',
        '.prn.imp.plot.pdf',
        '.cut.imp.plot.pdf',
        '.cut.imp.pdf'
    ];

    /**
     * Config storage
     */
    public function __construct()
    {
        $this->public = Storage::disk('public');
        $this->ftp = Storage::disk('ftp');
        $this->inputFolder = config('app.ftp_in_directory'). '/';
        $this->outputFolder = config('app.ftp_out_directory'). '/';
        $this->impositionInFolder = config('app.ftp_imposition_in_directory'). '/';
        $this->impositionOutFolder = config('app.ftp_imposition_out_directory'). '/';
        $this->impositionDoneFolder = config('app.ftp_imposition_done_directory'). '/';
        $this->worksDir = config('app.ftp_work_directory'). '/';
        $this->archiveFolder = config('app.ftp_archive_directory'). '/';
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     * @return bool
     */
    public function isFileExist(string $fileName, string $fileExtension): bool
    {
        return $this->ftp->exists($this->outputFolder . $fileName. '.' . $fileExtension);
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     * @return bool
     */
    public function isFileNonEmpty(string $fileName, string $fileExtension): bool
    {
        return $this->ftp->size($this->outputFolder . $fileName. '.' . $fileExtension);
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function isPreviewExist(string $fileName): bool
    {
        return $this->public->exists($fileName. '.' . self::PREVIEW_FILE_EXTENSION);
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     * @return string
     * @throws FileNotFoundException
     */
    public function getFile(string $fileName, string $fileExtension): string
    {
        return $this->ftp->get($this->outputFolder. $fileName. '.' . $fileExtension);
    }

    /**
     * @param UploadedFile $file
     * @return JsonResponse $filename
     */
    public function upload(UploadedFile $file): JsonResponse
    {
        $fileName = uniqid('', true);
        try {
            $this->ftp->putFileAs(
                $this->inputFolder, $file, $fileName. "." .$file->clientExtension()
            );

            return response()->json([
                'message' => 'File uploaded',
                'status' => 'uploaded',
                'filename' => $fileName,
            ]);

        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => __('alerts.customer.ftp_connection_error'),
                'status' => 'error',
            ]);
        }
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function copyPreviewToWebServer(string $fileName): bool
    {
        try {
            $previewFileName = $fileName. '.tn.jpg';
            $previewFile = $this->ftp->get($this->outputFolder . $previewFileName);

            return $this->public->put($previewFileName, $previewFile);

        } catch (FileNotFoundException $exception) {
            return false;
        }
    }

    /**
     * @param string $fileName
     * @param $fileData
     * @return bool
     */
    public function uploadCanvasPreview(string $fileName, $fileData): bool
    {
        $data = substr($fileData, strpos($fileData, ",") + 1);

        return $this->public->put($fileName.'-canvas.png', base64_decode($data));
    }

    /**
     * @param int       $layoutW
     * @param int       $layoutH
     * @param float    $fieldH
     * @param float    $bleed
     * @param int       $orderId
     * @param string    $orderRef
     * @param int       $orderQuantity
     * @param string    $endAt
     * @param string    $material
     * @param int       $width
     * @param int       $height
     * @param int       $rotate
     */
    public function generateYmlLayoutsFile(
        int     $layoutW,
        int     $layoutH,
        float   $fieldH,
        float   $fieldW,
        float   $bleed,
        int     $orderId,
        string  $orderRef,
        int     $orderQuantity,
        string  $endAt,
        Material $material,
        int     $width,
        int     $height,
        int     $rotate
    ): void
    {
        $ymlPrnFilename = $orderId. '.prn.yml';
        $ymlCutFilename = $orderId. '.cut.yml';

        $ymlContent = [
            'PageWidth'     => $layoutW.' mm',
            'PageHeight'    => $layoutH.' mm',
            'TopMargin'     => $fieldH.' mm',
            'FitAcross'     => LayoutHelper::fitAcross($width, $layoutW, $fieldW, $bleed),
            'FitDown'       => LayoutHelper::fitDown($height, $layoutH, $fieldH, $bleed),
            'HSpace'        => $bleed * 2 .' mm',
            'VSpace'        => $bleed * 2 .' mm',
            'Rotate'        => $rotate,
            'JobID'         => $orderId,
            'JobName'       => $orderRef,
            'JobCopiesNum'  => $orderQuantity,
            'JobReadyDate'  => $endAt,
            'JobMediaType'  => $material->material_name
        ];

        $this->ftp->put($this->impositionInFolder.$ymlPrnFilename, Yaml::dump($ymlContent));
        $this->ftp->put($this->impositionInFolder.$ymlCutFilename, Yaml::dump($ymlContent));
    }

    /**
     * @param string $fileName
     * @param int $orderId
     * @return bool
     */
    public function copyFilesForGenerateLayouts(string $fileName, int $orderId): bool
    {
        $pdfPrnFilename = $fileName. '.prn.pdf';
        $pdfCutFilename = $fileName. '.cut.pdf';
        $pdfPrnNewFilename = $orderId. '.prn.pdf';
        $pdfCutNewFilename = $orderId. '.cut.pdf';

        return (
            $this->ftp->move($this->outputFolder.$pdfPrnFilename, $this->impositionInFolder.$pdfPrnNewFilename) &&
            $this->ftp->move($this->outputFolder.$pdfCutFilename, $this->impositionInFolder.$pdfCutNewFilename)
        );
    }

    /**
     * @param string $type
     * @param int $orderId
     */
    public function getLayout(string $type, int $orderId)
    {
        switch ($type) {
            case 'prn':
                return $this->ftp->download($this->worksDir . $orderId . '/' . $orderId . '.prn.imp.pdf');
            case 'cut':
                return $this->ftp->download($this->worksDir . $orderId . '/' . $orderId . '.cut.imp.pdf');
            case 'prn_plotter':
                return $this->ftp->download($this->worksDir . $orderId . '/' . $orderId . '.prn.imp.plot.pdf');
            case 'cut_plotter':
                return $this->ftp->download($this->worksDir . $orderId . '/' . $orderId . '.cut.imp.plot.pdf');
            default:
                return;
        }
    }

    /**
     * @param int $orderId
     * @return bool
     */
    public function moveLayoutsBundleToWorkFolder(int $orderId): bool
    {
        $result = true;

        if (!$this->ftp->exists($this->worksDir . $orderId)) {
            $this->ftp->makeDirectory($this->worksDir . $orderId);
        }

        foreach (self::PRINT_AND_CUT_FILE_EXT as $ext) {
            if ($this->ftp->exists($this->impositionOutFolder . $orderId . $ext)) {
                $this->ftp->move(
                    $this->impositionOutFolder . $orderId . $ext,
                    $this->worksDir . $orderId . '/' . $orderId . $ext
                );
            }

            $result &= $this->ftp->exists($this->worksDir . $orderId . '/' . $orderId . $ext);
        }

        return $result;
    }

    /**
     * @param int $orderId
     * @return bool
     */
    public function moveSourcesBundleToWorkFolder(int $orderId): bool
    {
        if (!$this->ftp->exists($this->impositionDoneFolder . $orderId . '.src')) {
            return true;
        }

        if (!$this->ftp->exists($this->worksDir . $orderId)) {
            $this->ftp->makeDirectory($this->worksDir . $orderId);
        }

        return $this->ftp->move(
            $this->impositionDoneFolder . $orderId . '.src',
            $this->worksDir . $orderId . '/' . 'source'
        );
    }

    /**
     * @param int $orderId
     * @return bool
     */
    public function removeWorkFiles(int $orderId): bool
    {
        $result = true;

        if ($this->ftp->exists($this->impositionDoneFolder . $orderId . '.src')) {
            $result &= $this->ftp->deleteDirectory($this->impositionDoneFolder . $orderId . '.src');
        }

        foreach (self::PRINT_AND_CUT_FILE_EXT as $ext) {
            if ($this->ftp->exists($this->impositionOutFolder . $orderId . $ext)) {
                $result &= $this->ftp->delete($this->impositionOutFolder . $orderId . $ext);
            }
        }

        return $result;
    }

    /**
     * @param int $orderId
     * @return bool
     */
    public function moveWorkFilesToArchive(int $orderId): bool
    {
        $result = true;

        if ($this->ftp->exists($this->worksDir . $orderId)) {
            $result = $this->ftp->move($this->worksDir . $orderId, $this->archiveFolder . $orderId);
        }

        return $result;
    }
}
