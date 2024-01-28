<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLegalEntityRequest extends FormRequest
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
            'type'             => 'required|integer',
            'doc_flow_type'    => 'required|integer',
            'name'             => 'required|string',
			'alias'            => 'required|string',
			'edrpou'           => 'string|nullable',
			'director_fio'     => 'required|string',
			'is_nds_payer'     => 'required',
			'nds_payer_num'    => 'string|nullable',
			'ipn'              => 'required|string',
//			'bank_name'      => 'required|string',
//			'bank_account'   => 'required|string',
			'legal_address'    => 'string|nullable',
			'actual_address'   => 'string|nullable',
			'tel'              => 'string|nullable',
			'accountant_email' => 'string|nullable',
        ];
    }
}
