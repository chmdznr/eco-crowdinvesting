@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.timeProject.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.time-projects.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.id') }}
                        </th>
                        <td>
                            {{ $timeProject->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.code') }}
                        </th>
                        <td>
                            {{ $timeProject->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.name') }}
                        </th>
                        <td>
                            {{ $timeProject->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.umkm_penyedia') }}
                        </th>
                        <td>
                            {{ $timeProject->umkm_penyedia->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.umkm_penerima') }}
                        </th>
                        <td>
                            {{ $timeProject->umkm_penerima->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.investor') }}
                        </th>
                        <td>
                            @foreach($timeProject->investors as $key => $investor)
                                <span class="label label-info">{{ $investor->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.mode_investasi') }}
                        </th>
                        <td>
                            {{ $timeProject->mode_investasi->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.mode_pembayaran') }}
                        </th>
                        <td>
                            {{ $timeProject->mode_pembayaran->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.biaya_diajukan') }}
                        </th>
                        <td>
                            {{ $timeProject->biaya_diajukan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.biaya_terpenuhi') }}
                        </th>
                        <td>
                            {{ $timeProject->biaya_terpenuhi }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.remote_device') }}
                        </th>
                        <td>
                            {{ $timeProject->remote_device }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.description') }}
                        </th>
                        <td>
                            {!! $timeProject->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeProject.fields.status') }}
                        </th>
                        <td>
                            {{ $timeProject->status->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.time-projects.index') }}">
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
            <a class="nav-link" href="#project_project_docs" role="tab" data-toggle="tab">
                {{ trans('cruds.projectDoc.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#project_tasks" role="tab" data-toggle="tab">
                {{ trans('cruds.task.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="project_project_docs">
            @includeIf('admin.timeProjects.relationships.projectProjectDocs', ['projectDocs' => $timeProject->projectProjectDocs])
        </div>
        <div class="tab-pane" role="tabpanel" id="project_tasks">
            @includeIf('admin.timeProjects.relationships.projectTasks', ['tasks' => $timeProject->projectTasks])
        </div>
    </div>
</div>

@endsection