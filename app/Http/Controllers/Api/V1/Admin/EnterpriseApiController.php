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

    public function index()
    {
        abort_if(Gate::denies('enterprise_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EnterpriseResource(Enterprise::with(['jenis_usaha', 'pemilik', 'created_by'])->get());
    }

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

    public function show(Enterprise $enterprise)
    {
        abort_if(Gate::denies('enterprise_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EnterpriseResource($enterprise->load(['jenis_usaha', 'pemilik', 'created_by']));
    }

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

    public function destroy(Enterprise $enterprise)
    {
        abort_if(Gate::denies('enterprise_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterprise->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
