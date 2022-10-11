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
    /**
     * @OA\Get(
     *     path="/api/v1/market-access-types",
     *     tags={"MarketAccessType"},
     *     operationId="MarketAccessTypeIndex",
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
        abort_if(Gate::denies('market_access_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MarketAccessTypeResource(MarketAccessType::all());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/market-access-types",
     *     tags={"MarketAccessType"},
     *     summary="",
     *     operationId="MarketAccessTypeStore",
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
    public function store(StoreMarketAccessTypeRequest $request)
    {
        $marketAccessType = MarketAccessType::create($request->all());

        return (new MarketAccessTypeResource($marketAccessType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/market-access-types/{id}",
     *     tags={"MarketAccessType"},
     *     summary="",
     *     operationId="MarketAccessTypeShow",
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
    public function show(MarketAccessType $marketAccessType)
    {
        abort_if(Gate::denies('market_access_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MarketAccessTypeResource($marketAccessType);
    }
    /**
     * @OA\Put(
     *     path="/api/v1/market-access-types/{id}",
     *     tags={"MarketAccessType"},
     *     summary="",
     *     operationId="MarketAccessTypeUpdate",
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
    public function update(UpdateMarketAccessTypeRequest $request, MarketAccessType $marketAccessType)
    {
        $marketAccessType->update($request->all());

        return (new MarketAccessTypeResource($marketAccessType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/market-access-types/{id}",
     *     tags={"MarketAccessType"},
     *     summary="",
     *     operationId="MarketAccessTypeDestroy",
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
    public function destroy(MarketAccessType $marketAccessType)
    {
        abort_if(Gate::denies('market_access_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $marketAccessType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
