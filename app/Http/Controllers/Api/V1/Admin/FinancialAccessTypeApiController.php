<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFinancialAccessTypeRequest;
use App\Http\Requests\UpdateFinancialAccessTypeRequest;
use App\Http\Resources\Admin\FinancialAccessTypeResource;
use App\Models\FinancialAccessType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FinancialAccessTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('financial_access_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FinancialAccessTypeResource(FinancialAccessType::all());
    }

    public function store(StoreFinancialAccessTypeRequest $request)
    {
        $financialAccessType = FinancialAccessType::create($request->all());

        return (new FinancialAccessTypeResource($financialAccessType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FinancialAccessType $financialAccessType)
    {
        abort_if(Gate::denies('financial_access_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FinancialAccessTypeResource($financialAccessType);
    }

    public function update(UpdateFinancialAccessTypeRequest $request, FinancialAccessType $financialAccessType)
    {
        $financialAccessType->update($request->all());

        return (new FinancialAccessTypeResource($financialAccessType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FinancialAccessType $financialAccessType)
    {
        abort_if(Gate::denies('financial_access_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $financialAccessType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
