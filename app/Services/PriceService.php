<?php

namespace App\Services;

use App\Helpers\General\LayoutHelper;
use App\Models\Material;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

/**
 * Class PriceService
 * @package App\Services
 */
class PriceService
{
    /**
     * @param int $quantity
     * @param int $width
     * @param int $height
     * @param int $rotate
     * @param int $days
     * @param int $materialId
     * @param int $chromaticity
     * @return float
     */
    public function calculatePrice(int $quantity, int $width, int $height, int $rotate, int $days, int $materialId, int $lamination)
    {
        $euroCurrency = (float) option('euro_currency');
        $material = Material::find($materialId);


        // Log::info($speedIndex);
        // Log::info($euroCurrency);


        if ($rotate) {
            [$width, $height] = [$height, $width];
        }

        $numberOfArtworks = LayoutHelper::quantityPerSheet($width, $height, $material);
        $numberOfSheets = ceil($quantity / $numberOfArtworks);


        return $this->getPriceByDate(($numberOfSheets
        * ($this->getValueBetweenKeys($material->cost_printing, $numberOfSheets)
        + ($this->getValueBetweenKeys($material->cost_cut, $numberOfSheets) 
        * $this->getValueBetweenKeys($material->quantity_factor, $numberOfArtworks)
        + $this->getLamination($material->mat_glanec_covering,$numberOfSheets, $lamination)) 
        + $material->material_price * $euroCurrency)), $days);


    }

    /**
     * @param int $quantity
     * @param int $chromaticity
     * @return float
     */
    public function getLamination(string $materialLamination, int $quantity, int $lamination): float
    {
       if($lamination > 0) {
           return $this->getValueBetweenKeys($materialLamination, $quantity)[$lamination - 1];
       } 

        return 0;
    }

    /**
     * @param string $set
     * @param int $value
     * @return bool
     */
    private function isInSet(string $set, int $value): bool
    {
        $range = explode('-', $set);
        if ($range[1] === '') {
            $range[1] = PHP_INT_MAX;
        }
        return $value >= $range[0] && $value <= $range[1];
    }


    private function getValueBetweenKeys(string $object, int $number) {
        $keys = array_keys(json_decode($object, true)); // Get keys as an array
        sort($keys, SORT_NUMERIC); // Sort keys numerically
    
        foreach ($keys as $i => $currentKey) {
            $nextKey = isset($keys[$i + 1]) ? $keys[$i + 1] : null;
    
            if ($nextKey === null || ($number >= $currentKey && $number < $nextKey)) {
                $decodedObject = json_decode($object, true);
                return $decodedObject[$currentKey];
            }
        }
    
        return null; // If the number doesn't fall within any key range
    }
    /**
     * @param int $days
     * @param float $price
     * @return float
     */
    private function getPriceByDate(float $price, int $days): float
    {
        $speedIndex = $this->getValueBetweenKeys(option('speed_index'), $days);
        return ceil($price * $speedIndex);
    }
}
