<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeOfBusinessRequest;
use App\Http\Requests\UpdateTypeOfBusinessRequest;
use App\Http\Resources\Admin\TypeOfBusinessResource;
use App\Models\TypeOfBusiness;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeOfBusinessApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_of_business_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeOfBusinessResource(TypeOfBusiness::all());
    }

    public function store(StoreTypeOfBusinessRequest $request)
    {
        $typeOfBusiness = TypeOfBusiness::create($request->all());

        return (new TypeOfBusinessResource($typeOfBusiness))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TypeOfBusiness $typeOfBusiness)
    {
        abort_if(Gate::denies('type_of_business_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeOfBusinessResource($typeOfBusiness);
    }

    public function update(UpdateTypeOfBusinessRequest $request, TypeOfBusiness $typeOfBusiness)
    {
        $typeOfBusiness->update($request->all());

        return (new TypeOfBusinessResource($typeOfBusiness))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TypeOfBusiness $typeOfBusiness)
    {
        abort_if(Gate::denies('type_of_business_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfBusiness->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
