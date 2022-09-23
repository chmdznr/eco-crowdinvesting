<?php

namespace App\Http\Requests;

use App\Models\TimeProject;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTimeProjectRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('time_project_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:time_projects,code,' . request()->route('time_project')->id,
            ],
            'name' => [
                'string',
                'required',
            ],
            'investors.*' => [
                'integer',
            ],
            'investors' => [
                'array',
            ],
            'remote_device' => [
                'string',
                'nullable',
            ],
        ];
    }
}
