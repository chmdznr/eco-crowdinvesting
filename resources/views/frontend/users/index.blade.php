@extends('layouts.frontend')
@section('subtitle', trans('cruds.user.title_singular').' '.trans('global.list'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @can('user_create')
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-success" href="{{ route('frontend.users.create') }}">
                                    {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                                </a>
                            </div>
                        </div>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.email') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.email_verified_at') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.approved') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.two_factor') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.roles') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.nik') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.photo') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.is_nik_valid') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.tempat_lahir') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.tanggal_lahir') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.jenis_kelamin') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.no_hp') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.file_ktp') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                    <tr data-entry-id="{{ $user->id }}">
                                        <td>
                                            {{ $user->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->email_verified_at ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $user->approved ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $user->approved ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $user->two_factor ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $user->two_factor ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            @foreach($user->roles as $key => $item)
                                                <span>{{ $item->title }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $user->nik ?? '' }}
                                        </td>
                                        <td>
                                            @if($user->photo)
                                                <a href="{{ $user->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $user->photo->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $user->is_nik_valid ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $user->is_nik_valid ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ $user->tempat_lahir ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->tanggal_lahir ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\User::JENIS_KELAMIN_SELECT[$user->jenis_kelamin] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->no_hp ?? '' }}
                                        </td>
                                        <td>
                                            @if($user->file_ktp)
                                                <a href="{{ $user->file_ktp->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @can('user_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.users.show', $user->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('user_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.users.edit', $user->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('user_delete')
                                                <form action="{{ route('frontend.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.users.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection