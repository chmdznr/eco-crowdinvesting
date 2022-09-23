<?php

namespace App\Http\Requests;

use App\Models\TypeOfBusiness;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTypeOfBusinessRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('type_of_business_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:type_of_businesses,id',
        ];
    }
}
