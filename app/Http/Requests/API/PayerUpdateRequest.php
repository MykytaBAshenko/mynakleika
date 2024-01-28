<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PayerUpdateRequest
 * @package App\Http\Requests\API
 */
class PayerUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'verification_status' => 'required|integer'
        ];
    }
}
