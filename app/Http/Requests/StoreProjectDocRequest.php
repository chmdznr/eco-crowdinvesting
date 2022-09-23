<?php

namespace App\Http\Requests;

use App\Models\ProjectDoc;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProjectDocRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_doc_create');
    }

    public function rules()
    {
        return [
            'project_id' => [
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
