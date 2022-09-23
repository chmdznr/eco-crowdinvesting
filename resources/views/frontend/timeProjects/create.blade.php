@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.timeProject.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.time-projects.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="code">{{ trans('cruds.timeProject.fields.code') }}</label>
                            <input class="form-control" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                            @if($errors->has('code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('code') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.code_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.timeProject.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="umkm_penyedia_id">{{ trans('cruds.timeProject.fields.umkm_penyedia') }}</label>
                            <select class="form-control select2" name="umkm_penyedia_id" id="umkm_penyedia_id">
                                @foreach($umkm_penyedias as $id => $entry)
                                    <option value="{{ $id }}" {{ old('umkm_penyedia_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('umkm_penyedia'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('umkm_penyedia') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.umkm_penyedia_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="umkm_penerima_id">{{ trans('cruds.timeProject.fields.umkm_penerima') }}</label>
                            <select class="form-control select2" name="umkm_penerima_id" id="umkm_penerima_id">
                                @foreach($umkm_penerimas as $id => $entry)
                                    <option value="{{ $id }}" {{ old('umkm_penerima_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('umkm_penerima'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('umkm_penerima') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.umkm_penerima_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="investors">{{ trans('cruds.timeProject.fields.investor') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="investors[]" id="investors" multiple>
                                @foreach($investors as $id => $investor)
                                    <option value="{{ $id }}" {{ in_array($id, old('investors', [])) ? 'selected' : '' }}>{{ $investor }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('investors'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('investors') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.investor_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="mode_investasi_id">{{ trans('cruds.timeProject.fields.mode_investasi') }}</label>
                            <select class="form-control select2" name="mode_investasi_id" id="mode_investasi_id">
                                @foreach($mode_investasis as $id => $entry)
                                    <option value="{{ $id }}" {{ old('mode_investasi_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('mode_investasi'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('mode_investasi') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.mode_investasi_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="mode_pembayaran_id">{{ trans('cruds.timeProject.fields.mode_pembayaran') }}</label>
                            <select class="form-control select2" name="mode_pembayaran_id" id="mode_pembayaran_id">
                                @foreach($mode_pembayarans as $id => $entry)
                                    <option value="{{ $id }}" {{ old('mode_pembayaran_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('mode_pembayaran'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('mode_pembayaran') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.mode_pembayaran_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="biaya_diajukan">{{ trans('cruds.timeProject.fields.biaya_diajukan') }}</label>
                            <input class="form-control" type="number" name="biaya_diajukan" id="biaya_diajukan" value="{{ old('biaya_diajukan', '') }}" step="0.01">
                            @if($errors->has('biaya_diajukan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('biaya_diajukan') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.biaya_diajukan_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="biaya_terpenuhi">{{ trans('cruds.timeProject.fields.biaya_terpenuhi') }}</label>
                            <input class="form-control" type="number" name="biaya_terpenuhi" id="biaya_terpenuhi" value="{{ old('biaya_terpenuhi', '') }}" step="0.01">
                            @if($errors->has('biaya_terpenuhi'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('biaya_terpenuhi') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.biaya_terpenuhi_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="remote_device">{{ trans('cruds.timeProject.fields.remote_device') }}</label>
                            <input class="form-control" type="text" name="remote_device" id="remote_device" value="{{ old('remote_device', '') }}">
                            @if($errors->has('remote_device'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('remote_device') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.remote_device_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.timeProject.fields.description') }}</label>
                            <textarea class="form-control ckeditor" name="description" id="description">{!! old('description') !!}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="status_id">{{ trans('cruds.timeProject.fields.status') }}</label>
                            <select class="form-control select2" name="status_id" id="status_id">
                                @foreach($statuses as $id => $entry)
                                    <option value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeProject.fields.status_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('frontend.time-projects.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $timeProject->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection