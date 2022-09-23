<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTimeEntryRequest;
use App\Http\Requests\StoreTimeEntryRequest;
use App\Http\Requests\UpdateTimeEntryRequest;
use App\Models\TimeEntry;
use App\Models\TimeProject;
use App\Models\TimeWorkType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TimeEntryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('time_entry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TimeEntry::with(['work_type', 'project', 'created_by'])->select(sprintf('%s.*', (new TimeEntry())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'time_entry_show';
                $editGate = 'time_entry_edit';
                $deleteGate = 'time_entry_delete';
                $crudRoutePart = 'time-entries';

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
            $table->addColumn('work_type_name', function ($row) {
                return $row->work_type ? $row->work_type->name : '';
            });

            $table->addColumn('project_name', function ($row) {
                return $row->project ? $row->project->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'work_type', 'project']);

            return $table->make(true);
        }

        return view('admin.timeEntries.index');
    }

    public function create()
    {
        abort_if(Gate::denies('time_entry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $work_types = TimeWorkType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = TimeProject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.timeEntries.create', compact('projects', 'work_types'));
    }

    public function store(StoreTimeEntryRequest $request)
    {
        $timeEntry = TimeEntry::create($request->all());

        return redirect()->route('admin.time-entries.index');
    }

    public function edit(TimeEntry $timeEntry)
    {
        abort_if(Gate::denies('time_entry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $work_types = TimeWorkType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = TimeProject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $timeEntry->load('work_type', 'project', 'created_by');

        return view('admin.timeEntries.edit', compact('projects', 'timeEntry', 'work_types'));
    }

    public function update(UpdateTimeEntryRequest $request, TimeEntry $timeEntry)
    {
        $timeEntry->update($request->all());

        return redirect()->route('admin.time-entries.index');
    }

    public function show(TimeEntry $timeEntry)
    {
        abort_if(Gate::denies('time_entry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeEntry->load('work_type', 'project', 'created_by');

        return view('admin.timeEntries.show', compact('timeEntry'));
    }

    public function destroy(TimeEntry $timeEntry)
    {
        abort_if(Gate::denies('time_entry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeEntry->delete();

        return back();
    }

    public function massDestroy(MassDestroyTimeEntryRequest $request)
    {
        TimeEntry::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
