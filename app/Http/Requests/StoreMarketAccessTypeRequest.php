<?php

namespace App\Http\Requests;

use App\Models\MarketAccessType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMarketAccessTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('market_access_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:market_access_types',
            ],
        ];
    }
}
