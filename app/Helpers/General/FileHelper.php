<?php

namespace App\Helpers\General;

/**
 * Class FileHelper
 * @package App\Helpers\General
 */
class FileHelper
{
    /**
     * Returns a file size limit in bytes based on the PHP upload_max_filesize and post_max_size
     *
     * @return int
     */

    public function fileUploadMaxSize(): int
    {
        $maxSize = -1;

        if ($maxSize < 0) {
            // Start with post_max_size.
            $postMaxSize = $this->parseSize(ini_get('post_max_size'));
            if ($postMaxSize > 0) {
                $maxSize = $postMaxSize;
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $uploadMax = $this->parseSize(ini_get('upload_max_filesize'));
            if ($uploadMax > 0 && $uploadMax < $maxSize) {
                $maxSize = $uploadMax;
            }
        }


        return $maxSize;
    }

    /**
     * @param $size
     * @return float
     */
    private function parseSize($size): float
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }

        return round($size);
    }

    /**
     * @return int
     */
    public static function uploadMaxSizeInKb(): int
    {
        return min((int) ((new self)->fileUploadMaxSize()/1024), (int) (config('app.max_upload_file_size')));
    }

    /**
     * @return int
     */
    public static function uploadMaxSizeInMb(): int
    {
        return min((int) ((new self)->fileUploadMaxSize()/1024/1024), (int) (config('app.max_upload_file_size')/1024));
    }
}
