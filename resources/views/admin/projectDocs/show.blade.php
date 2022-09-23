@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.projectDoc.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.project-docs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.projectDoc.fields.id') }}
                        </th>
                        <td>
                            {{ $projectDoc->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectDoc.fields.project') }}
                        </th>
                        <td>
                            {{ $projectDoc->project->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectDoc.fields.name') }}
                        </th>
                        <td>
                            {{ $projectDoc->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectDoc.fields.lampiran') }}
                        </th>
                        <td>
                            @foreach($projectDoc->lampiran as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectDoc.fields.description') }}
                        </th>
                        <td>
                            {!! $projectDoc->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.project-docs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection