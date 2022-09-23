@can('time_project_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.time-projects.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.timeProject.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.timeProject.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-modePembayaranTimeProjects">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.umkm_penyedia') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.umkm_penerima') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.investor') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.mode_investasi') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.mode_pembayaran') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.biaya_diajukan') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.biaya_terpenuhi') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.remote_device') }}
                        </th>
                        <th>
                            {{ trans('cruds.timeProject.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($timeProjects as $key => $timeProject)
                        <tr data-entry-id="{{ $timeProject->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $timeProject->id ?? '' }}
                            </td>
                            <td>
                                {{ $timeProject->code ?? '' }}
                            </td>
                            <td>
                                {{ $timeProject->name ?? '' }}
                            </td>
                            <td>
                                {{ $timeProject->umkm_penyedia->name ?? '' }}
                            </td>
                            <td>
                                {{ $timeProject->umkm_penerima->name ?? '' }}
                            </td>
                            <td>
                                @foreach($timeProject->investors as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $timeProject->mode_investasi->name ?? '' }}
                            </td>
                            <td>
                                {{ $timeProject->mode_pembayaran->name ?? '' }}
                            </td>
                            <td>
                                {{ $timeProject->biaya_diajukan ?? '' }}
                            </td>
                            <td>
                                {{ $timeProject->biaya_terpenuhi ?? '' }}
                            </td>
                            <td>
                                {{ $timeProject->remote_device ?? '' }}
                            </td>
                            <td>
                                {{ $timeProject->status->name ?? '' }}
                            </td>
                            <td>
                                @can('time_project_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.time-projects.show', $timeProject->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('time_project_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.time-projects.edit', $timeProject->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('time_project_delete')
                                    <form action="{{ route('admin.time-projects.destroy', $timeProject->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('time_project_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.time-projects.massDestroy') }}",
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
  let table = $('.datatable-modePembayaranTimeProjects:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection