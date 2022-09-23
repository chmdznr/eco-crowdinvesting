@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.typeOfBusiness.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.type-of-businesses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.typeOfBusiness.fields.id') }}
                        </th>
                        <td>
                            {{ $typeOfBusiness->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.typeOfBusiness.fields.name') }}
                        </th>
                        <td>
                            {{ $typeOfBusiness->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.type-of-businesses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#jenis_usaha_enterprises" role="tab" data-toggle="tab">
                {{ trans('cruds.enterprise.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="jenis_usaha_enterprises">
            @includeIf('admin.typeOfBusinesses.relationships.jenisUsahaEnterprises', ['enterprises' => $typeOfBusiness->jenisUsahaEnterprises])
        </div>
    </div>
</div>

@endsection