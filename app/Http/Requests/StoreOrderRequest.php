<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'order_ref'         => 'string',
            'order_comments'    => 'string',
            'file_name'         => 'string',
            'width' 		    => 'numeric',
            'height' 		    => 'numeric',
            'rotate'            => 'numeric',
            'quantity' 		    => 'numeric',
            'material_id' 		=> 'numeric',
            'lamination'        => 'numeric',
            'chromaticity' 	    => 'numeric',
            'days' 			    => 'numeric',
            'delivery_id'       => 'numeric',
            'canvas_data'       => 'string'
        ];
    }
}
