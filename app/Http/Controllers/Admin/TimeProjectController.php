<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class TimeProjectController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('time_project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TimeProject::with(['umkm_penyedia', 'umkm_penerima', 'investors', 'mode_investasi', 'mode_pembayaran', 'status', 'created_by'])->select(sprintf('%s.*', (new TimeProject())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'time_project_show';
                $editGate = 'time_project_edit';
                $deleteGate = 'time_project_delete';
                $crudRoutePart = 'time-projects';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('umkm_penyedia_name', function ($row) {
                return $row->umkm_penyedia ? $row->umkm_penyedia->name : '';
            });

            $table->addColumn('umkm_penerima_name', function ($row) {
                return $row->umkm_penerima ? $row->umkm_penerima->name : '';
            });

            $table->editColumn('investor', function ($row) {
                $labels = [];
                foreach ($row->investors as $investor) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $investor->name);
                }

                return implode(' ', $labels);
            });
            $table->addColumn('mode_investasi_name', function ($row) {
                return $row->mode_investasi ? $row->mode_investasi->name : '';
            });

            $table->addColumn('mode_pembayaran_name', function ($row) {
                return $row->mode_pembayaran ? $row->mode_pembayaran->name : '';
            });

            $table->editColumn('biaya_diajukan', function ($row) {
                return $row->biaya_diajukan ? $row->biaya_diajukan : '';
            });
            $table->editColumn('biaya_terpenuhi', function ($row) {
                return $row->biaya_terpenuhi ? $row->biaya_terpenuhi : '';
            });
            $table->editColumn('remote_device', function ($row) {
                return $row->remote_device ? $row->remote_device : '';
            });
            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'umkm_penyedia', 'umkm_penerima', 'investor', 'mode_investasi', 'mode_pembayaran', 'status']);

            return $table->make(true);
        }

        return view('admin.timeProjects.index');
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

        return view('admin.timeProjects.create', compact('investors', 'mode_investasis', 'mode_pembayarans', 'statuses', 'umkm_penerimas', 'umkm_penyedias'));
    }

    public function store(StoreTimeProjectRequest $request)
    {
        $timeProject = TimeProject::create($request->all());
        $timeProject->investors()->sync($request->input('investors', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $timeProject->id]);
        }

        return redirect()->route('admin.time-projects.index');
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

        return view('admin.timeProjects.edit', compact('investors', 'mode_investasis', 'mode_pembayarans', 'statuses', 'timeProject', 'umkm_penerimas', 'umkm_penyedias'));
    }

    public function update(UpdateTimeProjectRequest $request, TimeProject $timeProject)
    {
        $timeProject->update($request->all());
        $timeProject->investors()->sync($request->input('investors', []));

        return redirect()->route('admin.time-projects.index');
    }

    public function show(TimeProject $timeProject)
    {
        abort_if(Gate::denies('time_project_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeProject->load('umkm_penyedia', 'umkm_penerima', 'investors', 'mode_investasi', 'mode_pembayaran', 'status', 'created_by', 'projectProjectDocs', 'projectTasks');

        return view('admin.timeProjects.show', compact('timeProject'));
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
