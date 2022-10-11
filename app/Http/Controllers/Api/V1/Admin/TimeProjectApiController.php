<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreTimeProjectRequest;
use App\Http\Requests\UpdateTimeProjectRequest;
use App\Http\Resources\Admin\TimeProjectResource;
use App\Models\TimeProject;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TimeProjectApiController extends Controller
{
    use MediaUploadingTrait;
    /**
     * @OA\Get(
     *     path="/api/v1/time-projects",
     *     tags={"TimeProject"},
     *     operationId="TimeProjectIndex",
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
        abort_if(Gate::denies('time_project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TimeProjectResource(TimeProject::with(['umkm_penyedia', 'umkm_penerima', 'investors', 'mode_investasi', 'mode_pembayaran', 'status', 'created_by'])->get());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/time-projects",
     *     tags={"TimeProject"},
     *     summary="",
     *     operationId="TimeProjectStore",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="code",type="string"),
     *              @OA\Property(property="name",type="string"),
     *              @OA\Property(property="investors",type="array", @OA\Items(type="number")),
     *              @OA\Property(property="remote_device",type="string")
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
    public function store(StoreTimeProjectRequest $request)
    {
        $timeProject = TimeProject::create($request->all());
        $timeProject->investors()->sync($request->input('investors', []));

        return (new TimeProjectResource($timeProject))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/time-projects/{id}",
     *     tags={"TimeProject"},
     *     summary="",
     *     operationId="TimeProjectShow",
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
    public function show(TimeProject $timeProject)
    {
        abort_if(Gate::denies('time_project_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TimeProjectResource($timeProject->load(['umkm_penyedia', 'umkm_penerima', 'investors', 'mode_investasi', 'mode_pembayaran', 'status', 'created_by']));
    }
    /**
     * @OA\Put(
     *     path="/api/v1/time-projects/{id}",
     *     tags={"TimeProject"},
     *     summary="",
     *     operationId="TimeProjectUpdate",
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
     *              @OA\Property(property="code",type="string"),
     *              @OA\Property(property="name",type="string"),
     *              @OA\Property(property="investors",type="array", @OA\Items(type="number")),
     *              @OA\Property(property="remote_device",type="string")
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
    public function update(UpdateTimeProjectRequest $request, TimeProject $timeProject)
    {
        $timeProject->update($request->all());
        $timeProject->investors()->sync($request->input('investors', []));

        return (new TimeProjectResource($timeProject))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/time-projects/{id}",
     *     tags={"TimeProject"},
     *     summary="",
     *     operationId="TimeProjectDestroy",
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
    public function destroy(TimeProject $timeProject)
    {
        abort_if(Gate::denies('time_project_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeProject->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
