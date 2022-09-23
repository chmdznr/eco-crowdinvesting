@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.financialAccessType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.financial-access-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
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
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.financial-access-types.index') }}">
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
            <a class="nav-link" href="#mode_investasi_time_projects" role="tab" data-toggle="tab">
                {{ trans('cruds.timeProject.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="mode_investasi_time_projects">
            @includeIf('admin.financialAccessTypes.relationships.modeInvestasiTimeProjects', ['timeProjects' => $financialAccessType->modeInvestasiTimeProjects])
        </div>
    </div>
</div>

@endsection