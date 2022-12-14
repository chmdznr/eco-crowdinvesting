@extends('layouts.frontend')
@section('subtitle', trans('global.create').' '.trans('cruds.timeEntry.title_singular'))
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
                    <form method="POST" action="{{ route("frontend.time-entries.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="work_type_id">{{ trans('cruds.timeEntry.fields.work_type') }}</label>
                            <select class="form-control select2" name="work_type_id" id="work_type_id">
                                @foreach($work_types as $id => $entry)
                                    <option value="{{ $id }}" {{ old('work_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('work_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('work_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeEntry.fields.work_type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="project_id">{{ trans('cruds.timeEntry.fields.project') }}</label>
                            <select class="form-control select2" name="project_id" id="project_id">
                                @foreach($projects as $id => $entry)
                                    <option value="{{ $id }}" {{ old('project_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('project'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('project') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeEntry.fields.project_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="start_time">{{ trans('cruds.timeEntry.fields.start_time') }}</label>
                            <input class="form-control datetime" type="text" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
                            @if($errors->has('start_time'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('start_time') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeEntry.fields.start_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="end_time">{{ trans('cruds.timeEntry.fields.end_time') }}</label>
                            <input class="form-control datetime" type="text" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                            @if($errors->has('end_time'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('end_time') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeEntry.fields.end_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection