<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryRequest extends FormRequest
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
            'type'              => 'required|integer',
            'np_payer'          => 'nullable|integer',
            'city'              => 'nullable|required_if:type,3|string',
            'address'           => 'nullable|required_if:type,2|string',
            'contact_person'    => 'required|string',
            'contact_phone'     => 'required|string',
            'np_organization'   => 'nullable|required_if:type,3|string',
            'np_warehouse'      => 'nullable|required_if:type,3|string',
        ];
    }
}
