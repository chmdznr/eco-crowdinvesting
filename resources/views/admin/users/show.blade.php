@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $user->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.two_factor') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->two_factor ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.nik') }}
                        </th>
                        <td>
                            {{ $user->nik }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.photo') }}
                        </th>
                        <td>
                            @if($user->photo)
                                <a href="{{ $user->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $user->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.is_nik_valid') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" checked>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.tempat_lahir') }}
                        </th>
                        <td>
                            {{ $user->tempat_lahir }}&nbsp;&nbsp;&nbsp;<input type="checkbox" disabled="disabled" checked>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.tanggal_lahir') }}
                        </th>
                        <td>
                            {{ $user->tanggal_lahir }}&nbsp;&nbsp;&nbsp;<input type="checkbox" disabled="disabled" checked>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.jenis_kelamin') }}
                        </th>
                        <td>
                            {{ App\Models\User::JENIS_KELAMIN_SELECT[$user->jenis_kelamin] ?? '' }}&nbsp;&nbsp;&nbsp;<input type="checkbox" disabled="disabled" checked>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.alamat') }}
                        </th>
                        <td>
                            {!! $user->alamat !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.no_hp') }}
                        </th>
                        <td>
                            {{ $user->no_hp }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.file_ktp') }}
                        </th>
                        <td>
                            @if($user->file_ktp)
                                <a href="{{ $user->file_ktp->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
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
            <a class="nav-link" href="#pemilik_enterprises" role="tab" data-toggle="tab">
                {{ trans('cruds.enterprise.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_user_alerts" role="tab" data-toggle="tab">
                {{ trans('cruds.userAlert.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#investor_time_projects" role="tab" data-toggle="tab">
                {{ trans('cruds.timeProject.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="pemilik_enterprises">
            @includeIf('admin.users.relationships.pemilikEnterprises', ['enterprises' => $user->pemilikEnterprises])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_user_alerts">
            @includeIf('admin.users.relationships.userUserAlerts', ['userAlerts' => $user->userUserAlerts])
        </div>
        <div class="tab-pane" role="tabpanel" id="investor_time_projects">
            @includeIf('admin.users.relationships.investorTimeProjects', ['timeProjects' => $user->investorTimeProjects])
        </div>
    </div>
</div>

@endsection
