<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class EnterpriseDocController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('enterprise_doc_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EnterpriseDoc::with(['umkm', 'created_by'])->select(sprintf('%s.*', (new EnterpriseDoc())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'enterprise_doc_show';
                $editGate = 'enterprise_doc_edit';
                $deleteGate = 'enterprise_doc_delete';
                $crudRoutePart = 'enterprise-docs';

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
            $table->addColumn('umkm_name', function ($row) {
                return $row->umkm ? $row->umkm->name : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('lampiran', function ($row) {
                if (!$row->lampiran) {
                    return '';
                }
                $links = [];
                foreach ($row->lampiran as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'umkm', 'lampiran']);

            return $table->make(true);
        }

        return view('admin.enterpriseDocs.index');
    }

    public function create()
    {
        abort_if(Gate::denies('enterprise_doc_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $umkms = Enterprise::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.enterpriseDocs.create', compact('umkms'));
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

        return redirect()->route('admin.enterprise-docs.index');
    }

    public function edit(EnterpriseDoc $enterpriseDoc)
    {
        abort_if(Gate::denies('enterprise_doc_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $umkms = Enterprise::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $enterpriseDoc->load('umkm', 'created_by');

        return view('admin.enterpriseDocs.edit', compact('enterpriseDoc', 'umkms'));
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

        return redirect()->route('admin.enterprise-docs.index');
    }

    public function show(EnterpriseDoc $enterpriseDoc)
    {
        abort_if(Gate::denies('enterprise_doc_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterpriseDoc->load('umkm', 'created_by');

        return view('admin.enterpriseDocs.show', compact('enterpriseDoc'));
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
