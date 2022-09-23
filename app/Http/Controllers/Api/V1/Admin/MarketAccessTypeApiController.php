<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMarketAccessTypeRequest;
use App\Http\Requests\UpdateMarketAccessTypeRequest;
use App\Http\Resources\Admin\MarketAccessTypeResource;
use App\Models\MarketAccessType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarketAccessTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('market_access_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MarketAccessTypeResource(MarketAccessType::all());
    }

    public function store(StoreMarketAccessTypeRequest $request)
    {
        $marketAccessType = MarketAccessType::create($request->all());

        return (new MarketAccessTypeResource($marketAccessType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MarketAccessType $marketAccessType)
    {
        abort_if(Gate::denies('market_access_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MarketAccessTypeResource($marketAccessType);
    }

    public function update(UpdateMarketAccessTypeRequest $request, MarketAccessType $marketAccessType)
    {
        $marketAccessType->update($request->all());

        return (new MarketAccessTypeResource($marketAccessType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MarketAccessType $marketAccessType)
    {
        abort_if(Gate::denies('market_access_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $marketAccessType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
