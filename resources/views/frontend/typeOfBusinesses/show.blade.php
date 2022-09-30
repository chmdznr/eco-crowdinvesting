@extends('layouts.frontend')
@section('subtitle', trans('global.show').' '.trans('cruds.typeOfBusiness.title'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <a class="btn btn-default" href="{{ route('frontend.type-of-businesses.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="form-group">
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
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection