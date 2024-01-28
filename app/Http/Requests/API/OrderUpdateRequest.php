<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'production_status' => 'required|integer'
        ];
    }
}
