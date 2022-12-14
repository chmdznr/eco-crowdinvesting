<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProjectDocRequest;
use App\Http\Requests\UpdateProjectDocRequest;
use App\Http\Resources\Admin\ProjectDocResource;
use App\Models\ProjectDoc;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectDocApiController extends Controller
{
    use MediaUploadingTrait;
    /**
     * @OA\Get(
     *     path="/api/v1/project-docs",
     *     tags={"ProjectDoc"},
     *     operationId="ProjectDocIndex",
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
        abort_if(Gate::denies('project_doc_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectDocResource(ProjectDoc::with(['project', 'created_by'])->get());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/project-docs",
     *     tags={"ProjectDoc"},
     *     summary="",
     *     operationId="ProjectDocStore",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="project_id",type="number"),
     *              @OA\Property(property="name",type="string"),
     *              @OA\Property(property="lampiran",type="array", @OA\Items(type="object"))
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
    public function store(StoreProjectDocRequest $request)
    {
        $projectDoc = ProjectDoc::create($request->all());

        foreach ($request->input('lampiran', []) as $file) {
            $projectDoc->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lampiran');
        }

        return (new ProjectDocResource($projectDoc))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/project-docs/{id}",
     *     tags={"ProjectDoc"},
     *     summary="",
     *     operationId="ProjectDocShow",
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
    public function show(ProjectDoc $projectDoc)
    {
        abort_if(Gate::denies('project_doc_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectDocResource($projectDoc->load(['project', 'created_by']));
    }
    /**
     * @OA\Put(
     *     path="/api/v1/project-docs/{id}",
     *     tags={"ProjectDoc"},
     *     summary="",
     *     operationId="ProjectDocUpdate",
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
     *              @OA\Property(property="project_id",type="number"),
     *              @OA\Property(property="name",type="string"),
     *              @OA\Property(property="lampiran",type="array", @OA\Items(type="object"))
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
    public function update(UpdateProjectDocRequest $request, ProjectDoc $projectDoc)
    {
        $projectDoc->update($request->all());

        if (count($projectDoc->lampiran) > 0) {
            foreach ($projectDoc->lampiran as $media) {
                if (!in_array($media->file_name, $request->input('lampiran', []))) {
                    $media->delete();
                }
            }
        }
        $media = $projectDoc->lampiran->pluck('file_name')->toArray();
        foreach ($request->input('lampiran', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $projectDoc->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lampiran');
            }
        }

        return (new ProjectDocResource($projectDoc))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/project-docs/{id}",
     *     tags={"ProjectDoc"},
     *     summary="",
     *     operationId="ProjectDocDestroy",
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
    public function destroy(ProjectDoc $projectDoc)
    {
        abort_if(Gate::denies('project_doc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectDoc->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
