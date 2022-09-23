<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMarketAccessTypeRequest;
use App\Http\Requests\StoreMarketAccessTypeRequest;
use App\Http\Requests\UpdateMarketAccessTypeRequest;
use App\Models\MarketAccessType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MarketAccessTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('market_access_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MarketAccessType::query()->select(sprintf('%s.*', (new MarketAccessType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'market_access_type_show';
                $editGate = 'market_access_type_edit';
                $deleteGate = 'market_access_type_delete';
                $crudRoutePart = 'market-access-types';

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

        return view('admin.marketAccessTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('market_access_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.marketAccessTypes.create');
    }

    public function store(StoreMarketAccessTypeRequest $request)
    {
        $marketAccessType = MarketAccessType::create($request->all());

        return redirect()->route('admin.market-access-types.index');
    }

    public function edit(MarketAccessType $marketAccessType)
    {
        abort_if(Gate::denies('market_access_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.marketAccessTypes.edit', compact('marketAccessType'));
    }

    public function update(UpdateMarketAccessTypeRequest $request, MarketAccessType $marketAccessType)
    {
        $marketAccessType->update($request->all());

        return redirect()->route('admin.market-access-types.index');
    }

    public function show(MarketAccessType $marketAccessType)
    {
        abort_if(Gate::denies('market_access_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $marketAccessType->load('modePembayaranTimeProjects');

        return view('admin.marketAccessTypes.show', compact('marketAccessType'));
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
