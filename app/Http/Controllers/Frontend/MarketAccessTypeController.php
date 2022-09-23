<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMarketAccessTypeRequest;
use App\Http\Requests\StoreMarketAccessTypeRequest;
use App\Http\Requests\UpdateMarketAccessTypeRequest;
use App\Models\MarketAccessType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarketAccessTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('market_access_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $marketAccessTypes = MarketAccessType::all();

        return view('frontend.marketAccessTypes.index', compact('marketAccessTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('market_access_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.marketAccessTypes.create');
    }

    public function store(StoreMarketAccessTypeRequest $request)
    {
        $marketAccessType = MarketAccessType::create($request->all());

        return redirect()->route('frontend.market-access-types.index');
    }

    public function edit(MarketAccessType $marketAccessType)
    {
        abort_if(Gate::denies('market_access_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.marketAccessTypes.edit', compact('marketAccessType'));
    }

    public function update(UpdateMarketAccessTypeRequest $request, MarketAccessType $marketAccessType)
    {
        $marketAccessType->update($request->all());

        return redirect()->route('frontend.market-access-types.index');
    }

    public function show(MarketAccessType $marketAccessType)
    {
        abort_if(Gate::denies('market_access_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.marketAccessTypes.show', compact('marketAccessType'));
    }

    public function destroy(MarketAccessType $marketAccessType)
    {
        abort_if(Gate::denies('market_access_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $marketAccessType->delete();

        return back();
    }

    public function massDestroy(MassDestroyMarketAccessTypeRequest $request)
    {
        MarketAccessType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
