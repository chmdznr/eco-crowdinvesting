@extends('layouts.admin')
@section('content')
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User">
            <thead>
                <tr>
                    <th width="10">

                    </th>
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
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.users.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'email', name: 'email' },
{ data: 'email_verified_at', name: 'email_verified_at' },
{ data: 'approved', name: 'approved' },
{ data: 'two_factor', name: 'two_factor' },
{ data: 'roles', name: 'roles.title' },
{ data: 'nik', name: 'nik' },
{ data: 'photo', name: 'photo', sortable: false, searchable: false },
{ data: 'is_nik_valid', name: 'is_nik_valid' },
{ data: 'tempat_lahir', name: 'tempat_lahir' },
{ data: 'tanggal_lahir', name: 'tanggal_lahir' },
{ data: 'jenis_kelamin', name: 'jenis_kelamin' },
{ data: 'no_hp', name: 'no_hp' },
{ data: 'file_ktp', name: 'file_ktp', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-User').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection