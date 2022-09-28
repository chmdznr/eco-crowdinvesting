@extends('layouts.frontend')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#my_profile" role="tab" data-toggle="tab">
                                {{ trans('global.my_profile') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#change_password" role="tab" data-toggle="tab">
                                {{ trans('global.change_password') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#delete_account" role="tab" data-toggle="tab">
                                {{ trans('global.delete_account') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-4">
                        <div class="tab-pane active" role="tabpanel" id="my_profile">
                            <form method="POST" action="{{ route("frontend.profile.update") }}">
                                @csrf
                                <div class="form-group">
                                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nik">{{ trans('cruds.user.fields.nik') }}</label>
                                    <input class="form-control {{ $errors->has('nik') ? 'is-invalid' : '' }}" type="text" name="nik" id="nik" value="{{ old('nik', auth()->user()->nik) }}">
                                    @if($errors->has('nik'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('nik') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.nik_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="photo">{{ trans('cruds.user.fields.photo') }}</label>
                                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                                    </div>
                                    @if($errors->has('photo'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('photo') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.photo_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_lahir">{{ trans('cruds.user.fields.tempat_lahir') }}</label>
                                    <input class="form-control {{ $errors->has('tempat_lahir') ? 'is-invalid' : '' }}" type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', auth()->user()->tempat_lahir) }}">
                                    @if($errors->has('tempat_lahir'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tempat_lahir') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.tempat_lahir_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">{{ trans('cruds.user.fields.tanggal_lahir') }}</label>
                                    <input class="form-control date {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}" type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', auth()->user()->tanggal_lahir) }}">
                                    @if($errors->has('tanggal_lahir'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tanggal_lahir') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.tanggal_lahir_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required">{{ trans('cruds.user.fields.jenis_kelamin') }}</label>
                                    <select class="form-control {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}" name="jenis_kelamin" id="jenis_kelamin" required>
                                        <option value disabled {{ old('jenis_kelamin', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach(App\Models\User::JENIS_KELAMIN_SELECT as $key => $label)
                                            <option value="{{ $key }}" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('jenis_kelamin'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('jenis_kelamin') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.jenis_kelamin_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">{{ trans('cruds.user.fields.alamat') }}</label>
                                    <textarea class="form-control ckeditor {{ $errors->has('alamat') ? 'is-invalid' : '' }}" name="alamat" id="alamat">{!! old('alamat', auth()->user()->alamat) !!}</textarea>
                                    @if($errors->has('alamat'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('alamat') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.alamat_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">{{ trans('cruds.user.fields.no_hp') }}</label>
                                    <input class="form-control {{ $errors->has('no_hp') ? 'is-invalid' : '' }}" type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}">
                                    @if($errors->has('no_hp'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('no_hp') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.no_hp_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="file_ktp">{{ trans('cruds.user.fields.file_ktp') }}</label>
                                    <div class="needsclick dropzone {{ $errors->has('file_ktp') ? 'is-invalid' : '' }}" id="file_ktp-dropzone">
                                    </div>
                                    @if($errors->has('file_ktp'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('file_ktp') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.file_ktp_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-warning" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="change_password">
                            <form method="POST" action="{{ route("frontend.profile.password") }}">
                                @csrf
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label class="required" for="password">New {{ trans('cruds.user.fields.password') }}</label>
                                    <input class="form-control" type="password" name="password" id="password" required>
                                    @if($errors->has('password'))
                                        <span class="help-block" role="alert">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="required" for="password_confirmation">Repeat New {{ trans('cruds.user.fields.password') }}</label>
                                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="delete_account">
                            <form method="POST" action="{{ route("frontend.profile.destroy") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">
                                @csrf
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.delete') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('frontend.users.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(auth()->user() && auth()->user()->photo)
      var file = {!! json_encode(auth()->user()->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
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
                xhr.open('POST', '{{ route('frontend.users.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ auth()->user()->id ?? 0 }}');
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

<script>
    Dropzone.options.fileKtpDropzone = {
    url: '{{ route('frontend.users.storeMedia') }}',
    maxFilesize: 10, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').find('input[name="file_ktp"]').remove()
      $('form').append('<input type="hidden" name="file_ktp" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="file_ktp"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(auth()->user() && auth()->user()->file_ktp)
      var file = {!! json_encode(auth()->user()->file_ktp) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="file_ktp" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection