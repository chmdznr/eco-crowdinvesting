<?php

namespace App\Http\Requests;

use App\Models\FinancialAccessType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFinancialAccessTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('financial_access_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:financial_access_types,name,' . request()->route('financial_access_type')->id,
            ],
        ];
    }
}
