@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.enterpriseDoc.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.enterprise-docs.update", [$enterpriseDoc->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="umkm_id">{{ trans('cruds.enterpriseDoc.fields.umkm') }}</label>
                <select class="form-control select2 {{ $errors->has('umkm') ? 'is-invalid' : '' }}" name="umkm_id" id="umkm_id" required>
                    @foreach($umkms as $id => $entry)
                        <option value="{{ $id }}" {{ (old('umkm_id') ? old('umkm_id') : $enterpriseDoc->umkm->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('umkm'))
                    <div class="invalid-feedback">
                        {{ $errors->first('umkm') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.enterpriseDoc.fields.umkm_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.enterpriseDoc.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $enterpriseDoc->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.enterpriseDoc.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="lampiran">{{ trans('cruds.enterpriseDoc.fields.lampiran') }}</label>
                <div class="needsclick dropzone {{ $errors->has('lampiran') ? 'is-invalid' : '' }}" id="lampiran-dropzone">
                </div>
                @if($errors->has('lampiran'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lampiran') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.enterpriseDoc.fields.lampiran_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.enterpriseDoc.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $enterpriseDoc->description) !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.enterpriseDoc.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    var uploadedLampiranMap = {}
Dropzone.options.lampiranDropzone = {
    url: '{{ route('admin.enterprise-docs.storeMedia') }}',
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lampiran[]" value="' + response.name + '">')
      uploadedLampiranMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLampiranMap[file.name]
      }
      $('form').find('input[name="lampiran[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($enterpriseDoc) && $enterpriseDoc->lampiran)
          var files =
            {!! json_encode($enterpriseDoc->lampiran) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lampiran[]" value="' + file.file_name + '">')
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
                xhr.open('POST', '{{ route('admin.enterprise-docs.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $enterpriseDoc->id ?? 0 }}');
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