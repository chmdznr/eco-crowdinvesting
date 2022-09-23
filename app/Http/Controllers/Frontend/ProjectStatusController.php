<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProjectStatusRequest;
use App\Http\Requests\StoreProjectStatusRequest;
use App\Http\Requests\UpdateProjectStatusRequest;
use App\Models\ProjectStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectStatusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('project_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectStatuses = ProjectStatus::all();

        return view('frontend.projectStatuses.index', compact('projectStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('project_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.projectStatuses.create');
    }

    public function store(StoreProjectStatusRequest $request)
    {
        $projectStatus = ProjectStatus::create($request->all());

        return redirect()->route('frontend.project-statuses.index');
    }

    public function edit(ProjectStatus $projectStatus)
    {
        abort_if(Gate::denies('project_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.projectStatuses.edit', compact('projectStatus'));
    }

    public function update(UpdateProjectStatusRequest $request, ProjectStatus $projectStatus)
    {
        $projectStatus->update($request->all());

        return redirect()->route('frontend.project-statuses.index');
    }

    public function show(ProjectStatus $projectStatus)
    {
        abort_if(Gate::denies('project_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.projectStatuses.show', compact('projectStatus'));
    }

    public function destroy(ProjectStatus $projectStatus)
    {
        abort_if(Gate::denies('project_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyProjectStatusRequest $request)
    {
        ProjectStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
