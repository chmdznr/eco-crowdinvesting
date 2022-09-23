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
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-pemilikEnterprises">
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
                <tbody>
                    @foreach($enterprises as $key => $enterprise)
                        <tr data-entry-id="{{ $enterprise->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $enterprise->id ?? '' }}
                            </td>
                            <td>
                                {{ $enterprise->nib ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $enterprise->is_nib_valid ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $enterprise->is_nib_valid ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $enterprise->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Enterprise::SKALA_USAHA_SELECT[$enterprise->skala_usaha] ?? '' }}
                            </td>
                            <td>
                                {{ $enterprise->alamat ?? '' }}
                            </td>
                            <td>
                                {{ $enterprise->jenis_usaha->name ?? '' }}
                            </td>
                            <td>
                                {{ $enterprise->pemilik->name ?? '' }}
                            </td>
                            <td>
                                {{ $enterprise->pemilik->email ?? '' }}
                            </td>
                            <td>
                                @foreach($enterprise->gallery as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @can('enterprise_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.enterprises.show', $enterprise->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('enterprise_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.enterprises.edit', $enterprise->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('enterprise_delete')
                                    <form action="{{ route('admin.enterprises.destroy', $enterprise->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('enterprise_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.enterprises.massDestroy') }}",
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
  let table = $('.datatable-pemilikEnterprises:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection