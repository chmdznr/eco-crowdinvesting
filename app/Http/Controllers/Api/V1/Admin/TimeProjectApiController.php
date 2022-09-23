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

    public function index()
    {
        abort_if(Gate::denies('time_project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TimeProjectResource(TimeProject::with(['umkm_penyedia', 'umkm_penerima', 'investors', 'mode_investasi', 'mode_pembayaran', 'status', 'created_by'])->get());
    }

    public function store(StoreTimeProjectRequest $request)
    {
        $timeProject = TimeProject::create($request->all());
        $timeProject->investors()->sync($request->input('investors', []));

        return (new TimeProjectResource($timeProject))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TimeProject $timeProject)
    {
        abort_if(Gate::denies('time_project_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TimeProjectResource($timeProject->load(['umkm_penyedia', 'umkm_penerima', 'investors', 'mode_investasi', 'mode_pembayaran', 'status', 'created_by']));
    }

    public function update(UpdateTimeProjectRequest $request, TimeProject $timeProject)
    {
        $timeProject->update($request->all());
        $timeProject->investors()->sync($request->input('investors', []));

        return (new TimeProjectResource($timeProject))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TimeProject $timeProject)
    {
        abort_if(Gate::denies('time_project_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeProject->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
