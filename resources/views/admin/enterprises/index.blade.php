@extends('layouts.admin')
@section('content')
@can('enterprise_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.enterprises.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.enterprise.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.enterprise.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Enterprise">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.enterprise.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.enterprise.fields.nib') }}
                    </th>
                    <th>
                        {{ trans('cruds.enterprise.fields.is_nib_valid') }}
                    </th>
                    <th>
                        {{ trans('cruds.enterprise.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.enterprise.fields.skala_usaha') }}
                    </th>
                    <th>
                        {{ trans('cruds.enterprise.fields.alamat') }}
                    </th>
                    <th>
                        {{ trans('cruds.enterprise.fields.jenis_usaha') }}
                    </th>
                    <th>
                        {{ trans('cruds.enterprise.fields.pemilik') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.enterprise.fields.gallery') }}
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
@can('enterprise_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.enterprises.massDestroy') }}",
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
    ajax: "{{ route('admin.enterprises.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'nib', name: 'nib' },
{ data: 'is_nib_valid', name: 'is_nib_valid' },
{ data: 'name', name: 'name' },
{ data: 'skala_usaha', name: 'skala_usaha' },
{ data: 'alamat', name: 'alamat' },
{ data: 'jenis_usaha_name', name: 'jenis_usaha.name' },
{ data: 'pemilik_name', name: 'pemilik.name' },
{ data: 'pemilik.email', name: 'pemilik.email' },
{ data: 'gallery', name: 'gallery', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Enterprise').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection