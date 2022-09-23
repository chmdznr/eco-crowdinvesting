<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProjectDocRequest;
use App\Http\Requests\StoreProjectDocRequest;
use App\Http\Requests\UpdateProjectDocRequest;
use App\Models\ProjectDoc;
use App\Models\TimeProject;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ProjectDocController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('project_doc_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectDocs = ProjectDoc::with(['project', 'created_by', 'media'])->get();

        return view('frontend.projectDocs.index', compact('projectDocs'));
    }

    public function create()
    {
        abort_if(Gate::denies('project_doc_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = TimeProject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.projectDocs.create', compact('projects'));
    }

    public function store(StoreProjectDocRequest $request)
    {
        $projectDoc = ProjectDoc::create($request->all());

        foreach ($request->input('lampiran', []) as $file) {
            $projectDoc->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lampiran');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $projectDoc->id]);
        }

        return redirect()->route('frontend.project-docs.index');
    }

    public function edit(ProjectDoc $projectDoc)
    {
        abort_if(Gate::denies('project_doc_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = TimeProject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projectDoc->load('project', 'created_by');

        return view('frontend.projectDocs.edit', compact('projectDoc', 'projects'));
    }

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

        return redirect()->route('frontend.project-docs.index');
    }

    public function show(ProjectDoc $projectDoc)
    {
        abort_if(Gate::denies('project_doc_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectDoc->load('project', 'created_by');

        return view('frontend.projectDocs.show', compact('projectDoc'));
    }

    public function destroy(ProjectDoc $projectDoc)
    {
        abort_if(Gate::denies('project_doc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectDoc->delete();

        return back();
    }

    public function massDestroy(MassDestroyProjectDocRequest $request)
    {
        ProjectDoc::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('project_doc_create') && Gate::denies('project_doc_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ProjectDoc();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
