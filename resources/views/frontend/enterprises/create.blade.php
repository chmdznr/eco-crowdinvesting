@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.enterprise.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.enterprises.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="nib">{{ trans('cruds.enterprise.fields.nib') }}</label>
                            <input class="form-control" type="text" name="nib" id="nib" value="{{ old('nib', '') }}" required>
                            @if($errors->has('nib'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nib') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.enterprise.fields.nib_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.enterprise.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.enterprise.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.enterprise.fields.skala_usaha') }}</label>
                            <select class="form-control" name="skala_usaha" id="skala_usaha" required>
                                <option value disabled {{ old('skala_usaha', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Enterprise::SKALA_USAHA_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('skala_usaha', 'mikro') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('skala_usaha'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('skala_usaha') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.enterprise.fields.skala_usaha_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="alamat">{{ trans('cruds.enterprise.fields.alamat') }}</label>
                            <textarea class="form-control" name="alamat" id="alamat">{{ old('alamat') }}</textarea>
                            @if($errors->has('alamat'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('alamat') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.enterprise.fields.alamat_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="jenis_usaha_id">{{ trans('cruds.enterprise.fields.jenis_usaha') }}</label>
                            <select class="form-control select2" name="jenis_usaha_id" id="jenis_usaha_id">
                                @foreach($jenis_usahas as $id => $entry)
                                    <option value="{{ $id }}" {{ old('jenis_usaha_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('jenis_usaha'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('jenis_usaha') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.enterprise.fields.jenis_usaha_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="pemilik_id">{{ trans('cruds.enterprise.fields.pemilik') }}</label>
                            <select class="form-control select2" name="pemilik_id" id="pemilik_id" required>
                                @foreach($pemiliks as $id => $entry)
                                    <option value="{{ $id }}" {{ old('pemilik_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('pemilik'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('pemilik') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.enterprise.fields.pemilik_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.enterprise.fields.description') }}</label>
                            <textarea class="form-control ckeditor" name="description" id="description">{!! old('description') !!}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.enterprise.fields.description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="gallery">{{ trans('cruds.enterprise.fields.gallery') }}</label>
                            <div class="needsclick dropzone" id="gallery-dropzone">
                            </div>
                            @if($errors->has('gallery'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gallery') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.enterprise.fields.gallery_helper') }}</span>
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
                xhr.open('POST', '{{ route('frontend.enterprises.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $enterprise->id ?? 0 }}');
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
    var uploadedGalleryMap = {}
Dropzone.options.galleryDropzone = {
    url: '{{ route('frontend.enterprises.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="gallery[]" value="' + response.name + '">')
      uploadedGalleryMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedGalleryMap[file.name]
      }
      $('form').find('input[name="gallery[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($enterprise) && $enterprise->gallery)
      var files = {!! json_encode($enterprise->gallery) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="gallery[]" value="' + file.file_name + '">')
        }
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