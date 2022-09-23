@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('enterprise_doc_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.enterprise-docs.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.enterpriseDoc.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.enterpriseDoc.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-EnterpriseDoc">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.enterpriseDoc.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.enterpriseDoc.fields.umkm') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.enterpriseDoc.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.enterpriseDoc.fields.lampiran') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enterpriseDocs as $key => $enterpriseDoc)
                                    <tr data-entry-id="{{ $enterpriseDoc->id }}">
                                        <td>
                                            {{ $enterpriseDoc->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $enterpriseDoc->umkm->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $enterpriseDoc->name ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($enterpriseDoc->lampiran as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            @can('enterprise_doc_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.enterprise-docs.show', $enterpriseDoc->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('enterprise_doc_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.enterprise-docs.edit', $enterpriseDoc->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('enterprise_doc_delete')
                                                <form action="{{ route('frontend.enterprise-docs.destroy', $enterpriseDoc->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('enterprise_doc_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.enterprise-docs.massDestroy') }}",
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
  let table = $('.datatable-EnterpriseDoc:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection