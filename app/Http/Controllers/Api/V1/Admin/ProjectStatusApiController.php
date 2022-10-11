<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectStatusRequest;
use App\Http\Requests\UpdateProjectStatusRequest;
use App\Http\Resources\Admin\ProjectStatusResource;
use App\Models\ProjectStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectStatusApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/project-statuses",
     *     tags={"ProjectStatus"},
     *     operationId="ProjectStatusIndex",
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
        abort_if(Gate::denies('project_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectStatusResource(ProjectStatus::all());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/project-statuses",
     *     tags={"ProjectStatus"},
     *     summary="",
     *     operationId="ProjectStatusStore",
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
    public function store(StoreProjectStatusRequest $request)
    {
        $projectStatus = ProjectStatus::create($request->all());

        return (new ProjectStatusResource($projectStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/project-statuses/{id}",
     *     tags={"ProjectStatus"},
     *     summary="",
     *     operationId="ProjectStatusShow",
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
    public function show(ProjectStatus $projectStatus)
    {
        abort_if(Gate::denies('project_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectStatusResource($projectStatus);
    }
    /**
     * @OA\Put(
     *     path="/api/v1/project-statuses/{id}",
     *     tags={"ProjectStatus"},
     *     summary="",
     *     operationId="ProjectStatusUpdate",
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
    public function update(UpdateProjectStatusRequest $request, ProjectStatus $projectStatus)
    {
        $projectStatus->update($request->all());

        return (new ProjectStatusResource($projectStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/project-statuses/{id}",
     *     tags={"ProjectStatus"},
     *     summary="",
     *     operationId="ProjectStatusDestroy",
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
    public function destroy(ProjectStatus $projectStatus)
    {
        abort_if(Gate::denies('project_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
