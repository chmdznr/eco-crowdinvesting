<?php

namespace App\Http\Requests;

use App\Models\Enterprise;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEnterpriseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('enterprise_edit');
    }

    public function rules()
    {
        return [
            'nib' => [
                'string',
                'max:14',
                'required',
                'unique:enterprises,nib,' . request()->route('enterprise')->id,
            ],
            'name' => [
                'string',
                'required',
            ],
            'skala_usaha' => [
                'required',
            ],
            'pemilik_id' => [
                'required',
                'integer',
            ],
            'gallery' => [
                'array',
            ],
        ];
    }
}
