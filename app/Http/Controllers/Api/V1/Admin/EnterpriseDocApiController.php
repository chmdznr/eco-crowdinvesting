<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEnterpriseDocRequest;
use App\Http\Requests\UpdateEnterpriseDocRequest;
use App\Http\Resources\Admin\EnterpriseDocResource;
use App\Models\EnterpriseDoc;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnterpriseDocApiController extends Controller
{
    use MediaUploadingTrait;
     /**
     * @OA\Get(
     *     path="/api/v1/enterprise-docs",
     *     tags={"EnterpriseDoc"},
     *     operationId="EnterpriseDocIndex",
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
        abort_if(Gate::denies('enterprise_doc_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EnterpriseDocResource(EnterpriseDoc::with(['umkm', 'created_by'])->get());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/enterprise-docs",
     *     tags={"EnterpriseDoc"},
     *     summary="",
     *     operationId="EnterpriseDocStore",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="umkm_id",type="number"),
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
    public function store(StoreEnterpriseDocRequest $request)
    {
        $enterpriseDoc = EnterpriseDoc::create($request->all());

        foreach ($request->input('lampiran', []) as $file) {
            $enterpriseDoc->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lampiran');
        }

        return (new EnterpriseDocResource($enterpriseDoc))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/enterprise-docs/{id}",
     *     tags={"EnterpriseDoc"},
     *     summary="",
     *     operationId="EnterpriseDocShow",
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
    public function show(EnterpriseDoc $enterpriseDoc)
    {
        abort_if(Gate::denies('enterprise_doc_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EnterpriseDocResource($enterpriseDoc->load(['umkm', 'created_by']));
    }
    /**
     * @OA\Put(
     *     path="/api/v1/enterprise-docs/{id}",
     *     tags={"EnterpriseDoc"},
     *     summary="",
     *     operationId="EnterpriseDocUpdate",
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
     *              @OA\Property(property="umkm_id",type="number"),
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
    public function update(UpdateEnterpriseDocRequest $request, EnterpriseDoc $enterpriseDoc)
    {
        $enterpriseDoc->update($request->all());

        if (count($enterpriseDoc->lampiran) > 0) {
            foreach ($enterpriseDoc->lampiran as $media) {
                if (!in_array($media->file_name, $request->input('lampiran', []))) {
                    $media->delete();
                }
            }
        }
        $media = $enterpriseDoc->lampiran->pluck('file_name')->toArray();
        foreach ($request->input('lampiran', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $enterpriseDoc->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lampiran');
            }
        }

        return (new EnterpriseDocResource($enterpriseDoc))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/enterprise-docs/{id}",
     *     tags={"EnterpriseDoc"},
     *     summary="",
     *     operationId="EnterpriseDocDestroy",
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
    public function destroy(EnterpriseDoc $enterpriseDoc)
    {
        abort_if(Gate::denies('enterprise_doc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterpriseDoc->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
