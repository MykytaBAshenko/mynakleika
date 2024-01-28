<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\General\MoneyHelper;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Material::all();
        return view('backend.material.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.material.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* @todo rewrite, validate data  */
        Material::create($request->all());
        return redirect()->route('admin.material.index')->withFlashSuccess(__('alerts.backend.material.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        return view('backend.material.edit')->with('material', $material);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {

        $data = $request->all();

        $data['material_price'] = floatval($data['material_price']);
        $data['layoutW'] = intval($data['layoutW']);
        $data['layoutH'] = intval($data['layoutH']);
        $data['fieldW'] = floatval($data['fieldW']);
        $data['fieldH'] = floatval($data['fieldH']);
        $data['bleed'] = floatval($data['bleed']);
        // $data['minW'] = MoneyHelper::parseToInt($data['minW']);
        // $data['minH'] = MoneyHelper::parseToInt($data['minH']);
        
        $combinedCostPrinting = array_combine(array_map(function ($value) {
            return intval($value);
        }, $data['cost_printing_keys']), array_map(function ($value) {
            return intval($value);
        }, $data['cost_printing_values']));
        $combinedCutPrinting = array_combine(array_map(function ($value) {
            return intval($value);
        }, $data['cost_cut_keys']), array_map(function ($value) {
            return intval($value);
        }, $data['cost_cut_values']));
        $quantityFactorPrinting = array_combine(array_map(function ($value) {
            return intval($value);
        }, $data['quantity_factor_keys']), array_map(function ($value) {
            return intval($value);
        }, $data['quantity_factor_values']));
        $mat_glanec_covering_glanec = [];

        foreach ($data['mat_glanec_covering_keys'] as $key => $value) {
          $mat_glanec_covering_glanec[$value] = [
            intval($data['mat_glanec_covering_mat_values'][$key]),
            intval($data['mat_glanec_covering_glanec_values'][$key])
          ];
        }
        // Encode the combined array into JSON format
        $data['cost_printing'] = json_encode($combinedCostPrinting);
        $data['cost_cut'] = json_encode($combinedCutPrinting);
        $data['quantity_factor'] = json_encode($quantityFactorPrinting);
        $data['mat_glanec_covering'] = json_encode($mat_glanec_covering_glanec);

        unset($data['cost_printing_keys']);
        unset($data['cost_printing_values']);
        unset($data['cost_cut_keys']);
        unset($data['cost_cut_values']);
        unset($data['quantity_factor_keys']);
        unset($data['quantity_factor_values']);

        unset($data['mat_glanec_covering_keys']);
        unset($data['mat_glanec_covering_mat_values']);
        unset($data['mat_glanec_covering_glanec_values']);


        $material->update($data);
//         dump($material);
//         dump($data);
// exit;
        return redirect()->route('admin.material.index')->withFlashSuccess(__('alerts.backend.material.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.material.index')->withFlashSuccess(__('alerts.backend.material.deleted'));
    }
}
