<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEnterpriseDocRequest;
use App\Http\Requests\StoreEnterpriseDocRequest;
use App\Http\Requests\UpdateEnterpriseDocRequest;
use App\Models\Enterprise;
use App\Models\EnterpriseDoc;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EnterpriseDocController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('enterprise_doc_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterpriseDocs = EnterpriseDoc::with(['umkm', 'created_by', 'media'])->get();

        return view('frontend.enterpriseDocs.index', compact('enterpriseDocs'));
    }

    public function create()
    {
        abort_if(Gate::denies('enterprise_doc_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $umkms = Enterprise::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.enterpriseDocs.create', compact('umkms'));
    }

    public function store(StoreEnterpriseDocRequest $request)
    {
        $enterpriseDoc = EnterpriseDoc::create($request->all());

        foreach ($request->input('lampiran', []) as $file) {
            $enterpriseDoc->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lampiran');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $enterpriseDoc->id]);
        }

        return redirect()->route('frontend.enterprise-docs.index');
    }

    public function edit(EnterpriseDoc $enterpriseDoc)
    {
        abort_if(Gate::denies('enterprise_doc_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $umkms = Enterprise::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $enterpriseDoc->load('umkm', 'created_by');

        return view('frontend.enterpriseDocs.edit', compact('enterpriseDoc', 'umkms'));
    }

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

        return redirect()->route('frontend.enterprise-docs.index');
    }

    public function show(EnterpriseDoc $enterpriseDoc)
    {
        abort_if(Gate::denies('enterprise_doc_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterpriseDoc->load('umkm', 'created_by');

        return view('frontend.enterpriseDocs.show', compact('enterpriseDoc'));
    }

    public function destroy(EnterpriseDoc $enterpriseDoc)
    {
        abort_if(Gate::denies('enterprise_doc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterpriseDoc->delete();

        return back();
    }

    public function massDestroy(MassDestroyEnterpriseDocRequest $request)
    {
        EnterpriseDoc::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('enterprise_doc_create') && Gate::denies('enterprise_doc_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EnterpriseDoc();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
