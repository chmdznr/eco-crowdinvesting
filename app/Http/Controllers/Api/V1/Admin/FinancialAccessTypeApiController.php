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
    /**
     * @OA\Get(
     *     path="/api/v1/financial-access-types",
     *     tags={"FinancialAccessType"},
     *     operationId="FinancialAccessTypeIndex",
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
        abort_if(Gate::denies('financial_access_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FinancialAccessTypeResource(FinancialAccessType::all());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/financial-access-types",
     *     tags={"FinancialAccessType"},
     *     summary="",
     *     operationId="FinancialAccessTypeStore",
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
    public function store(StoreFinancialAccessTypeRequest $request)
    {
        $financialAccessType = FinancialAccessType::create($request->all());

        return (new FinancialAccessTypeResource($financialAccessType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/financial-access-types/{id}",
     *     tags={"FinancialAccessType"},
     *     summary="",
     *     operationId="FinancialAccessTypeShow",
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
    public function show(FinancialAccessType $financialAccessType)
    {
        abort_if(Gate::denies('financial_access_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FinancialAccessTypeResource($financialAccessType);
    }
    /**
     * @OA\Put(
     *     path="/api/v1/financial-access-types/{id}",
     *     tags={"FinancialAccessType"},
     *     summary="",
     *     operationId="FinancialAccessTypeUpdate",
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
    public function update(UpdateFinancialAccessTypeRequest $request, FinancialAccessType $financialAccessType)
    {
        $financialAccessType->update($request->all());

        return (new FinancialAccessTypeResource($financialAccessType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/financial-access-types/{id}",
     *     tags={"FinancialAccessType"},
     *     summary="",
     *     operationId="FinancialAccessTypeDestroy",
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
    public function destroy(FinancialAccessType $financialAccessType)
    {
        abort_if(Gate::denies('financial_access_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $financialAccessType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
