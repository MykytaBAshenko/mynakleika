<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreOrderRequest
 * @package App\Http\Requests\Frontend
 */
class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_ref'         => 'required|string',
            'order_comments'    => 'max:1000',
            'file_name'         => 'string',
            'width' 		    => 'required|numeric',
            'height' 		    => 'required|numeric',
            'rotate'            => 'required|numeric',
            'quantity' 		    => 'required|numeric',
            'material_id' 		=> 'required|numeric',
            'lamination' 	    => 'required',
            'chromaticity' 	    => 'required',
            'days' 			    => 'required|numeric',
            'canvas_data'       => 'required',
            'token'             => 'string',

            'delivery.type'              => 'required|numeric',
            'delivery.np_payer'          => 'nullable|numeric',
            'delivery.city'              => 'nullable|required_if:delivery.type,3|string',
            'delivery.address'           => 'nullable|required_if:delivery.type,2|string',
            'delivery.contact_person'    => 'nullable|required_unless:delivery.type,1|string',
            'delivery.contact_phone'     => 'nullable|required_unless:delivery.type,1|string',
            'delivery.np_warehouse'      => 'nullable|required_if:delivery.type,3|string',
        ];
    }
}
