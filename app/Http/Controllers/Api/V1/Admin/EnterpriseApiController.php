<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEnterpriseRequest;
use App\Http\Requests\UpdateEnterpriseRequest;
use App\Http\Resources\Admin\EnterpriseResource;
use App\Models\Enterprise;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnterpriseApiController extends Controller
{
    use MediaUploadingTrait;
     /**
     * @OA\Get(
     *     path="/api/v1/enterprises",
     *     tags={"Enterprise"},
     *     operationId="EnterpriseIndex",
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
        abort_if(Gate::denies('enterprise_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EnterpriseResource(Enterprise::with(['jenis_usaha', 'pemilik', 'created_by'])->get());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/enterprises",
     *     tags={"Enterprise"},
     *     summary="",
     *     operationId="EnterpriseStore",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="nib",type="string"),
     *              @OA\Property(property="name",type="string"),
     *              @OA\Property(property="skala_usaha",type="string"),
     *              @OA\Property(property="pemilik_id",type="number"),
     *              @OA\Property(property="gallery",type="array", @OA\Items(type="string")),
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
    public function store(StoreEnterpriseRequest $request)
    {
        $enterprise = Enterprise::create($request->all());

        foreach ($request->input('gallery', []) as $file) {
            $enterprise->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('gallery');
        }

        return (new EnterpriseResource($enterprise))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/enterprises/{id}",
     *     tags={"Enterprise"},
     *     summary="",
     *     operationId="EnterpriseShow",
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
    public function show(Enterprise $enterprise)
    {
        abort_if(Gate::denies('enterprise_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EnterpriseResource($enterprise->load(['jenis_usaha', 'pemilik', 'created_by']));
    }
    /**
     * @OA\Put(
     *     path="/api/v1/enterprises/{id}",
     *     tags={"Enterprise"},
     *     summary="",
     *     operationId="EnterpriseUpdate",
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
     *              @OA\Property(property="nib",type="string"),
     *              @OA\Property(property="name",type="string"),
     *              @OA\Property(property="skala_usaha",type="string"),
     *              @OA\Property(property="pemilik_id",type="number"),
     *              @OA\Property(property="gallery",type="array", @OA\Items(type="string")),
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
    public function update(UpdateEnterpriseRequest $request, Enterprise $enterprise)
    {
        $enterprise->update($request->all());

        if (count($enterprise->gallery) > 0) {
            foreach ($enterprise->gallery as $media) {
                if (!in_array($media->file_name, $request->input('gallery', []))) {
                    $media->delete();
                }
            }
        }
        $media = $enterprise->gallery->pluck('file_name')->toArray();
        foreach ($request->input('gallery', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $enterprise->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('gallery');
            }
        }

        return (new EnterpriseResource($enterprise))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/enterprises/{id}",
     *     tags={"Enterprise"},
     *     summary="",
     *     operationId="EnterpriseDestroy",
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
    public function destroy(Enterprise $enterprise)
    {
        abort_if(Gate::denies('enterprise_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterprise->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
