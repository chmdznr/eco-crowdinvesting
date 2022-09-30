@extends('layouts.frontend')
@section('subtitle', trans('global.show').' '.trans('cruds.contentCategory.title'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-default" href="{{ route('frontend.content-categories.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contentCategory.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $contentCategory->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contentCategory.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $contentCategory->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.contentCategory.fields.slug') }}
                                    </th>
                                    <td>
                                        {{ $contentCategory->slug }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection