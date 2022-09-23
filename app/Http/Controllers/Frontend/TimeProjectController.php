<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTimeProjectRequest;
use App\Http\Requests\StoreTimeProjectRequest;
use App\Http\Requests\UpdateTimeProjectRequest;
use App\Models\Enterprise;
use App\Models\FinancialAccessType;
use App\Models\MarketAccessType;
use App\Models\ProjectStatus;
use App\Models\TimeProject;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TimeProjectController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('time_project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeProjects = TimeProject::with(['umkm_penyedia', 'umkm_penerima', 'investors', 'mode_investasi', 'mode_pembayaran', 'status', 'created_by'])->get();

        return view('frontend.timeProjects.index', compact('timeProjects'));
    }

    public function create()
    {
        abort_if(Gate::denies('time_project_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $umkm_penyedias = Enterprise::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $umkm_penerimas = Enterprise::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $investors = User::pluck('name', 'id');

        $mode_investasis = FinancialAccessType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mode_pembayarans = MarketAccessType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = ProjectStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.timeProjects.create', compact('investors', 'mode_investasis', 'mode_pembayarans', 'statuses', 'umkm_penerimas', 'umkm_penyedias'));
    }

    public function store(StoreTimeProjectRequest $request)
    {
        $timeProject = TimeProject::create($request->all());
        $timeProject->investors()->sync($request->input('investors', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $timeProject->id]);
        }

        return redirect()->route('frontend.time-projects.index');
    }

    public function edit(TimeProject $timeProject)
    {
        abort_if(Gate::denies('time_project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $umkm_penyedias = Enterprise::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $umkm_penerimas = Enterprise::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $investors = User::pluck('name', 'id');

        $mode_investasis = FinancialAccessType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mode_pembayarans = MarketAccessType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = ProjectStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $timeProject->load('umkm_penyedia', 'umkm_penerima', 'investors', 'mode_investasi', 'mode_pembayaran', 'status', 'created_by');

        return view('frontend.timeProjects.edit', compact('investors', 'mode_investasis', 'mode_pembayarans', 'statuses', 'timeProject', 'umkm_penerimas', 'umkm_penyedias'));
    }

    public function update(UpdateTimeProjectRequest $request, TimeProject $timeProject)
    {
        $timeProject->update($request->all());
        $timeProject->investors()->sync($request->input('investors', []));

        return redirect()->route('frontend.time-projects.index');
    }

    public function show(TimeProject $timeProject)
    {
        abort_if(Gate::denies('time_project_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeProject->load('umkm_penyedia', 'umkm_penerima', 'investors', 'mode_investasi', 'mode_pembayaran', 'status', 'created_by');

        return view('frontend.timeProjects.show', compact('timeProject'));
    }

    public function destroy(TimeProject $timeProject)
    {
        abort_if(Gate::denies('time_project_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeProject->delete();

        return back();
    }

    public function massDestroy(MassDestroyTimeProjectRequest $request)
    {
        TimeProject::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('time_project_create') && Gate::denies('time_project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new TimeProject();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
