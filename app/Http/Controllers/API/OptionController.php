<?php

namespace App\Http\Controllers\API;

use App\Helpers\General\MoneyHelper;
use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\JsonResponse;

/**
 * Class OptionController
 * @package App\Http\Controllers\API
 */
class OptionController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getOptions(): JsonResponse
    {
        // Get Materials in stock
        $materials = Material::select('id', 'material_name', 'material_price')
            ->where('in_stock', true)
            ->get();

        return response()->json([
            'euroCurrency'  => option('euro_currency'),
            'netCost' 		=> MoneyHelper::toString(option('net_cost')),
            'layoutW' 	    => option('layoutW'),
            'layoutH' 		=> option('layoutH'),
            'fieldW' 		=> option('fieldW'),
            'fieldH'		=> option('fieldH'),
            'bleed' 		=> option('bleed'),
            'minW' 		    => option('minW'),
            'minH' 		    => option('minH'),
            'materials'     => $materials,
        ]);
    }
}
