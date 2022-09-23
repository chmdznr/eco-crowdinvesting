<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFinancialAccessTypeRequest;
use App\Http\Requests\StoreFinancialAccessTypeRequest;
use App\Http\Requests\UpdateFinancialAccessTypeRequest;
use App\Models\FinancialAccessType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FinancialAccessTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('financial_access_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FinancialAccessType::query()->select(sprintf('%s.*', (new FinancialAccessType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'financial_access_type_show';
                $editGate = 'financial_access_type_edit';
                $deleteGate = 'financial_access_type_delete';
                $crudRoutePart = 'financial-access-types';

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

        return view('admin.financialAccessTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('financial_access_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.financialAccessTypes.create');
    }

    public function store(StoreFinancialAccessTypeRequest $request)
    {
        $financialAccessType = FinancialAccessType::create($request->all());

        return redirect()->route('admin.financial-access-types.index');
    }

    public function edit(FinancialAccessType $financialAccessType)
    {
        abort_if(Gate::denies('financial_access_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.financialAccessTypes.edit', compact('financialAccessType'));
    }

    public function update(UpdateFinancialAccessTypeRequest $request, FinancialAccessType $financialAccessType)
    {
        $financialAccessType->update($request->all());

        return redirect()->route('admin.financial-access-types.index');
    }

    public function show(FinancialAccessType $financialAccessType)
    {
        abort_if(Gate::denies('financial_access_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $financialAccessType->load('modeInvestasiTimeProjects');

        return view('admin.financialAccessTypes.show', compact('financialAccessType'));
    }

    public function destroy(FinancialAccessType $financialAccessType)
    {
        abort_if(Gate::denies('financial_access_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $financialAccessType->delete();

        return back();
    }

    public function massDestroy(MassDestroyFinancialAccessTypeRequest $request)
    {
        FinancialAccessType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
