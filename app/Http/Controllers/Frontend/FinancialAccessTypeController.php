<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFinancialAccessTypeRequest;
use App\Http\Requests\StoreFinancialAccessTypeRequest;
use App\Http\Requests\UpdateFinancialAccessTypeRequest;
use App\Models\FinancialAccessType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FinancialAccessTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('financial_access_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $financialAccessTypes = FinancialAccessType::all();

        return view('frontend.financialAccessTypes.index', compact('financialAccessTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('financial_access_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.financialAccessTypes.create');
    }

    public function store(StoreFinancialAccessTypeRequest $request)
    {
        $financialAccessType = FinancialAccessType::create($request->all());

        return redirect()->route('frontend.financial-access-types.index');
    }

    public function edit(FinancialAccessType $financialAccessType)
    {
        abort_if(Gate::denies('financial_access_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.financialAccessTypes.edit', compact('financialAccessType'));
    }

    public function update(UpdateFinancialAccessTypeRequest $request, FinancialAccessType $financialAccessType)
    {
        $financialAccessType->update($request->all());

        return redirect()->route('frontend.financial-access-types.index');
    }

    public function show(FinancialAccessType $financialAccessType)
    {
        abort_if(Gate::denies('financial_access_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.financialAccessTypes.show', compact('financialAccessType'));
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
