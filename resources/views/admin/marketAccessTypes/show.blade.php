@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.marketAccessType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.market-access-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.marketAccessType.fields.id') }}
                        </th>
                        <td>
                            {{ $marketAccessType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.marketAccessType.fields.name') }}
                        </th>
                        <td>
                            {{ $marketAccessType->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.market-access-types.index') }}">
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
            <a class="nav-link" href="#mode_pembayaran_time_projects" role="tab" data-toggle="tab">
                {{ trans('cruds.timeProject.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="mode_pembayaran_time_projects">
            @includeIf('admin.marketAccessTypes.relationships.modePembayaranTimeProjects', ['timeProjects' => $marketAccessType->modePembayaranTimeProjects])
        </div>
    </div>
</div>

@endsection