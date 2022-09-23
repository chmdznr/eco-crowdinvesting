<?php

namespace App\Http\Controllers\Frontend;

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

class EnterpriseController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('enterprise_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterprises = Enterprise::with(['jenis_usaha', 'pemilik', 'created_by', 'media'])->get();

        return view('frontend.enterprises.index', compact('enterprises'));
    }

    public function create()
    {
        abort_if(Gate::denies('enterprise_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jenis_usahas = TypeOfBusiness::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pemiliks = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.enterprises.create', compact('jenis_usahas', 'pemiliks'));
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

        return redirect()->route('frontend.enterprises.index');
    }

    public function edit(Enterprise $enterprise)
    {
        abort_if(Gate::denies('enterprise_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jenis_usahas = TypeOfBusiness::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pemiliks = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $enterprise->load('jenis_usaha', 'pemilik', 'created_by');

        return view('frontend.enterprises.edit', compact('enterprise', 'jenis_usahas', 'pemiliks'));
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

        return redirect()->route('frontend.enterprises.index');
    }

    public function show(Enterprise $enterprise)
    {
        abort_if(Gate::denies('enterprise_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enterprise->load('jenis_usaha', 'pemilik', 'created_by');

        return view('frontend.enterprises.show', compact('enterprise'));
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
