<?php

namespace App\Http\Requests;

use App\Helpers\General\FileHelper;
use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
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
            'file' => 'required|file|mimes:pdf|max:' . FileHelper::uploadMaxSizeInKb(),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file.max' => 'Размер файла не должен превышать '. FileHelper::uploadMaxSizeInMb() .' Mb',
        ];
    }
}
