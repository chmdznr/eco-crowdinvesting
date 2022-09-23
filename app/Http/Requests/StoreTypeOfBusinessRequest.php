<?php

namespace App\Http\Requests;

use App\Models\TypeOfBusiness;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTypeOfBusinessRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('type_of_business_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:type_of_businesses',
            ],
        ];
    }
}
