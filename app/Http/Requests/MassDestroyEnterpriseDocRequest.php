<?php

namespace App\Http\Requests;

use App\Models\EnterpriseDoc;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEnterpriseDocRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('enterprise_doc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:enterprise_docs,id',
        ];
    }
}
