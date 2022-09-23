<?php

namespace App\Http\Requests;

use App\Models\FinancialAccessType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFinancialAccessTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('financial_access_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:financial_access_types',
            ],
        ];
    }
}
