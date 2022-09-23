<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEnterpriseRequest;
use App\Http\Requests\StoreEnterpriseRequest;
use App\Http\Requests\UpdateEnterpriseRequest;
use App\Models\Enterprise;
use App\Models\TypeOfBusiness;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EnterpriseController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('enterprise_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Enterprise::with(['jenis_usaha', 'pemilik', 'created_by'])->select(sprintf('%s.*', (new Enterprise())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'enterprise_show';
                $editGate = 'enterprise_edit';
                $deleteGate = 'enterprise_delete';
                $crudRoutePart = 'enterprises';

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
            $table->editColumn('nib', function ($row) {
                return $row->nib ? $row->nib : '';
            });
            $table->editColumn('is_nib_valid', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_nib_valid ? 'checked' : null) . '>';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('skala_usaha', function ($row) {
                return $row->skala_usaha ? Enterprise::SKALA_USAHA_SELECT[$row->skala_usaha] : '';
            });
            $table->editColumn('alamat', function ($row) {
                return $row->alamat ? $row->alamat : '';
            });
            $table->addColumn('jenis_usaha_name', function ($row) {
                return $row->jenis_usaha ? $row->jenis_usaha->name : '';
            });

            $table->addColumn('pemilik_name', function ($row) {
                return $row->pemilik ? $row->pemilik->name : '';
            });

            $table->editColumn('pemilik.email', function ($row) {
                return $row->pemilik ? (is_string($row->pemilik) ? $row->pemilik : $row->pemilik->email) : '';
            });
            $table->editColumn('gallery', function ($row) {
                if (!$row->gallery) {
                    return '';
                }
                $links = [];
                foreach ($row->gallery as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'is_nib_valid', 'jenis_usaha', 'pemilik', 'gallery']);

            return $table->make(true);
        }

        return view('admin.enterprises.index');
    }

    public function create()
    {
        abort_if(Gate::denies('enterprise_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jenis_usahas = TypeOfBusiness::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pemiliks = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.enterprises.create', compact('jenis_usahas', 'pemiliks'));
    }

    public function store(StoreEnterpriseRequest $request)
    {
        $enterprise = Enterprise::create($request->all());

        foreach ($request->input('gallery', []) as $file) {
            $enterprise->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('gallery');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $enterprise->id]);
        }

        return redirect()->route('admin.enterprises.index');
    }

    public function edit(Enterprise $enterprise)
    {
        abort_if(Gate::denies('enterprise_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jenis_usahas = TypeOfBusiness::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pemiliks = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $enterprise->load('jenis_usaha', 'pemilik', 'created_by');

        return view('admin.enterprises.edit', compact('enterprise', 'jenis_usahas', 'pemiliks'));
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

        return redirect()->route('admin.enterprises.index');
    }

    public function show(Enterprise $enterprise)
    {
        abort_if(Gate::denies('enterprise_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterprise->load('jenis_usaha', 'pemilik', 'created_by', 'umkmPenyediaTimeProjects', 'umkmPenerimaTimeProjects', 'umkmEnterpriseDocs');

        return view('admin.enterprises.show', compact('enterprise'));
    }

    public function destroy(Enterprise $enterprise)
    {
        abort_if(Gate::denies('enterprise_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterprise->delete();

        return back();
    }

    public function massDestroy(MassDestroyEnterpriseRequest $request)
    {
        Enterprise::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('enterprise_create') && Gate::denies('enterprise_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Enterprise();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
