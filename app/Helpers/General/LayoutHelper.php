<?php

namespace App\Helpers\General;
use Illuminate\Support\Facades\Log;
use App\Models\Material;

/**
 * Class LayoutHelper
 * @package App\Helpers\General
 */
class LayoutHelper
{
    /**
     * @param int $width
     * @return int
     */
    public static function fitAcross(int $width, float $layoutW, float $fieldW, float  $bleed): int
    {
        return (int) floor(
            ($layoutW - $fieldW * 2 + $bleed * 2) / ($width + ($bleed * 2))
        );
    }

    /**
     * @param int $height
     * @return int
     */
    public static function fitDown(int $height, float $layoutH, float $fieldH, float $bleed): int
    {
        return (int) floor(
            ($layoutH - $fieldH * 2 + $bleed * 2) / ($height + ($bleed * 2))
        );
    }

    /**
     * @param int $width
     * @param int $height
     * @return int
     */
    public static function quantityPerSheet(int $width, int $height, Material $material): int
    {
        return self::fitAcross($width, $material->layoutW, $material->fieldW, $material->bleed) 
        * self::fitDown($height, $material->layoutH, $material->fieldH, $material->bleed);
    }
}
