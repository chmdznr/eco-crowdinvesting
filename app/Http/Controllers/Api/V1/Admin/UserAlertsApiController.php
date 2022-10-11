<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAlertRequest;
use App\Http\Resources\Admin\UserAlertResource;
use App\Models\UserAlert;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAlertsApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/user-alerts",
     *     tags={"UserAlert"},
     *     operationId="UserAlertIndex",
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
        abort_if(Gate::denies('user_alert_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserAlertResource(UserAlert::with(['users'])->get());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/user-alerts",
     *     tags={"UserAlert"},
     *     summary="",
     *     operationId="UserAlertStore",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="alert_text",type="string"),
     *              @OA\Property(property="nalert_linkame",type="string"),
     *              @OA\Property(property="users",type="array", @OA\Items(type="number"))
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
    public function store(StoreUserAlertRequest $request)
    {
        $userAlert = UserAlert::create($request->all());
        $userAlert->users()->sync($request->input('users', []));

        return (new UserAlertResource($userAlert))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/user-alerts/{id}",
     *     tags={"UserAlert"},
     *     summary="",
     *     operationId="UserAlertShow",
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
    public function show(UserAlert $userAlert)
    {
        abort_if(Gate::denies('user_alert_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserAlertResource($userAlert->load(['users']));
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/user-alerts/{id}",
     *     tags={"UserAlert"},
     *     summary="",
     *     operationId="UserAlertDestroy",
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
    public function destroy(UserAlert $userAlert)
    {
        abort_if(Gate::denies('user_alert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
