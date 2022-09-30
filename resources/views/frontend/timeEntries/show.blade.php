@extends('layouts.frontend')
@section('subtitle', trans('global.show').' '.trans('cruds.timeEntry.title'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <a class="btn btn-default" href="{{ route('frontend.time-entries.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeEntry.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $timeEntry->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeEntry.fields.work_type') }}
                                    </th>
                                    <td>
                                        {{ $timeEntry->work_type->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeEntry.fields.project') }}
                                    </th>
                                    <td>
                                        {{ $timeEntry->project->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeEntry.fields.start_time') }}
                                    </th>
                                    <td>
                                        {{ $timeEntry->start_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeEntry.fields.end_time') }}
                                    </th>
                                    <td>
                                        {{ $timeEntry->end_time }}
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