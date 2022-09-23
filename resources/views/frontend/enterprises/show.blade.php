@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.enterprise.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.enterprises.index') }}">
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
                            <a class="btn btn-default" href="{{ route('frontend.enterprises.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection