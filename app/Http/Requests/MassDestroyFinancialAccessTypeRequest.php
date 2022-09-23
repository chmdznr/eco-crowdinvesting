<?php

namespace App\Http\Requests;

use App\Models\FinancialAccessType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFinancialAccessTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('financial_access_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:financial_access_types,id',
        ];
    }
}
