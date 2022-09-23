<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTypeOfBusinessRequest;
use App\Http\Requests\StoreTypeOfBusinessRequest;
use App\Http\Requests\UpdateTypeOfBusinessRequest;
use App\Models\TypeOfBusiness;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TypeOfBusinessController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('type_of_business_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TypeOfBusiness::query()->select(sprintf('%s.*', (new TypeOfBusiness())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'type_of_business_show';
                $editGate = 'type_of_business_edit';
                $deleteGate = 'type_of_business_delete';
                $crudRoutePart = 'type-of-businesses';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.typeOfBusinesses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('type_of_business_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeOfBusinesses.create');
    }

    public function store(StoreTypeOfBusinessRequest $request)
    {
        $typeOfBusiness = TypeOfBusiness::create($request->all());

        return redirect()->route('admin.type-of-businesses.index');
    }

    public function edit(TypeOfBusiness $typeOfBusiness)
    {
        abort_if(Gate::denies('type_of_business_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeOfBusinesses.edit', compact('typeOfBusiness'));
    }

    public function update(UpdateTypeOfBusinessRequest $request, TypeOfBusiness $typeOfBusiness)
    {
        $typeOfBusiness->update($request->all());

        return redirect()->route('admin.type-of-businesses.index');
    }

    public function show(TypeOfBusiness $typeOfBusiness)
    {
        abort_if(Gate::denies('type_of_business_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfBusiness->load('jenisUsahaEnterprises');

        return view('admin.typeOfBusinesses.show', compact('typeOfBusiness'));
    }

    public function destroy(TypeOfBusiness $typeOfBusiness)
    {
        abort_if(Gate::denies('type_of_business_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfBusiness->delete();

        return back();
    }

    public function massDestroy(MassDestroyTypeOfBusinessRequest $request)
    {
        TypeOfBusiness::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
