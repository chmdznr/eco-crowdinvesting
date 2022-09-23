<?php

namespace App\Http\Requests;

use App\Models\EnterpriseDoc;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEnterpriseDocRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('enterprise_doc_create');
    }

    public function rules()
    {
        return [
            'umkm_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'required',
            ],
            'lampiran' => [
                'array',
                'required',
            ],
            'lampiran.*' => [
                'required',
            ],
        ];
    }
}
