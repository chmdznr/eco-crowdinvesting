@extends('layouts.frontend')
@section('subtitle', trans('global.show').' '.trans('cruds.financialAccessType.title'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <a class="btn btn-default" href="{{ route('frontend.financial-access-types.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.financialAccessType.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $financialAccessType->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.financialAccessType.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $financialAccessType->name }}
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