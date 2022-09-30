@extends('layouts.frontend')
@section('subtitle', trans('cruds.typeOfBusiness.title_singular').' '.trans('global.list'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @can('type_of_business_create')
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-success" href="{{ route('frontend.type-of-businesses.create') }}">
                                    {{ trans('global.add') }} {{ trans('cruds.typeOfBusiness.title_singular') }}
                                </a>
                            </div>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-TypeOfBusiness">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.typeOfBusiness.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.typeOfBusiness.fields.name') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($typeOfBusinesses as $key => $typeOfBusiness)
                                    <tr data-entry-id="{{ $typeOfBusiness->id }}">
                                        <td>
                                            {{ $typeOfBusiness->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $typeOfBusiness->name ?? '' }}
                                        </td>
                                        <td>
                                            @can('type_of_business_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.type-of-businesses.show', $typeOfBusiness->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('type_of_business_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.type-of-businesses.edit', $typeOfBusiness->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('type_of_business_delete')
                                                <form action="{{ route('frontend.type-of-businesses.destroy', $typeOfBusiness->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('type_of_business_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.type-of-businesses.massDestroy') }}",
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
  let table = $('.datatable-TypeOfBusiness:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection