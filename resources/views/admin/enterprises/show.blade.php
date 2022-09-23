@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.enterprise.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.enterprises.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.id') }}
                        </th>
                        <td>
                            {{ $enterprise->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.nib') }}
                        </th>
                        <td>
                            {{ $enterprise->nib }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.is_nib_valid') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $enterprise->is_nib_valid ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.name') }}
                        </th>
                        <td>
                            {{ $enterprise->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.skala_usaha') }}
                        </th>
                        <td>
                            {{ App\Models\Enterprise::SKALA_USAHA_SELECT[$enterprise->skala_usaha] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.alamat') }}
                        </th>
                        <td>
                            {{ $enterprise->alamat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.jenis_usaha') }}
                        </th>
                        <td>
                            {{ $enterprise->jenis_usaha->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.pemilik') }}
                        </th>
                        <td>
                            {{ $enterprise->pemilik->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.description') }}
                        </th>
                        <td>
                            {!! $enterprise->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enterprise.fields.gallery') }}
                        </th>
                        <td>
                            @foreach($enterprise->gallery as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.enterprises.index') }}">
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
            <a class="nav-link" href="#umkm_penyedia_time_projects" role="tab" data-toggle="tab">
                {{ trans('cruds.timeProject.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#umkm_penerima_time_projects" role="tab" data-toggle="tab">
                {{ trans('cruds.timeProject.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#umkm_enterprise_docs" role="tab" data-toggle="tab">
                {{ trans('cruds.enterpriseDoc.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="umkm_penyedia_time_projects">
            @includeIf('admin.enterprises.relationships.umkmPenyediaTimeProjects', ['timeProjects' => $enterprise->umkmPenyediaTimeProjects])
        </div>
        <div class="tab-pane" role="tabpanel" id="umkm_penerima_time_projects">
            @includeIf('admin.enterprises.relationships.umkmPenerimaTimeProjects', ['timeProjects' => $enterprise->umkmPenerimaTimeProjects])
        </div>
        <div class="tab-pane" role="tabpanel" id="umkm_enterprise_docs">
            @includeIf('admin.enterprises.relationships.umkmEnterpriseDocs', ['enterpriseDocs' => $enterprise->umkmEnterpriseDocs])
        </div>
    </div>
</div>

@endsection