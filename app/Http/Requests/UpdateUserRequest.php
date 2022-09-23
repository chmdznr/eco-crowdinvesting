<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
            'nik' => [
                'string',
                'min:16',
                'max:16',
                'nullable',
            ],
            'tempat_lahir' => [
                'string',
                'nullable',
            ],
            'tanggal_lahir' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'jenis_kelamin' => [
                'required',
            ],
            'no_hp' => [
                'string',
                'max:12',
                'nullable',
            ],
        ];
    }
}
