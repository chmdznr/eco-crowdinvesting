<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTypeOfBusinessRequest;
use App\Http\Requests\StoreTypeOfBusinessRequest;
use App\Http\Requests\UpdateTypeOfBusinessRequest;
use App\Models\TypeOfBusiness;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeOfBusinessController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_of_business_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfBusinesses = TypeOfBusiness::all();

        return view('frontend.typeOfBusinesses.index', compact('typeOfBusinesses'));
    }

    public function create()
    {
        abort_if(Gate::denies('type_of_business_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.typeOfBusinesses.create');
    }

    public function store(StoreTypeOfBusinessRequest $request)
    {
        $typeOfBusiness = TypeOfBusiness::create($request->all());

        return redirect()->route('frontend.type-of-businesses.index');
    }

    public function edit(TypeOfBusiness $typeOfBusiness)
    {
        abort_if(Gate::denies('type_of_business_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.typeOfBusinesses.edit', compact('typeOfBusiness'));
    }

    public function update(UpdateTypeOfBusinessRequest $request, TypeOfBusiness $typeOfBusiness)
    {
        $typeOfBusiness->update($request->all());

        return redirect()->route('frontend.type-of-businesses.index');
    }

    public function show(TypeOfBusiness $typeOfBusiness)
    {
        abort_if(Gate::denies('type_of_business_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.typeOfBusinesses.show', compact('typeOfBusiness'));
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
