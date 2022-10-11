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
    /**
     * @OA\Get(
     *     path="/api/v1/type-of-businesses",
     *     tags={"TypeOfBusiness"},
     *     operationId="TypeOfBusinessIndex",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function index()
    {
        abort_if(Gate::denies('type_of_business_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeOfBusinessResource(TypeOfBusiness::all());
    }
     /**
     * @OA\Post(
     *     path="/api/v1/type-of-businesses",
     *     tags={"TypeOfBusiness"},
     *     summary="",
     *     operationId="TypeOfBusinessStore",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="name",type="string")
     *            )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function store(StoreTypeOfBusinessRequest $request)
    {
        $typeOfBusiness = TypeOfBusiness::create($request->all());

        return (new TypeOfBusinessResource($typeOfBusiness))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/type-of-businesses/{id}",
     *     tags={"TypeOfBusiness"},
     *     summary="",
     *     operationId="TypeOfBusinessShow",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function show(TypeOfBusiness $typeOfBusiness)
    {
        abort_if(Gate::denies('type_of_business_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeOfBusinessResource($typeOfBusiness);
    }
    /**
     * @OA\Put(
     *     path="/api/v1/type-of-businesses/{id}",
     *     tags={"TypeOfBusiness"},
     *     summary="",
     *     operationId="TypeOfBusinessUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="name",type="string")
     *            )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function update(UpdateTypeOfBusinessRequest $request, TypeOfBusiness $typeOfBusiness)
    {
        $typeOfBusiness->update($request->all());

        return (new TypeOfBusinessResource($typeOfBusiness))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/type-of-businesses/{id}",
     *     tags={"TypeOfBusiness"},
     *     summary="",
     *     operationId="TypeOfBusinessDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function destroy(TypeOfBusiness $typeOfBusiness)
    {
        abort_if(Gate::denies('type_of_business_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfBusiness->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
