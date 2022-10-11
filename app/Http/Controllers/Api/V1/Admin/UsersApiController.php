<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersApiController extends Controller
{
    use MediaUploadingTrait;
    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     tags={"User"},
     *     operationId="UserIndex",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['roles'])->get());
    }
    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     tags={"User"},
     *     summary="",
     *     operationId="UserStore",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="name",type="string"),
     *              @OA\Property(property="email",type="string"),
     *              @OA\Property(property="password",type="string"),
     *              @OA\Property(property="roles",type="array", @OA\Items(type="number")),
     *              @OA\Property(property="nik",type="string"),
     *              @OA\Property(property="tempat_lahir",type="string"),
     *              @OA\Property(property="tanggal_lahir",type="datetime"),
     *              @OA\Property(property="jenis_kelamin",type="string"),
     *              @OA\Property(property="no_hp",type="string")
     *            )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        if ($request->input('photo', false)) {
            $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($request->input('file_ktp', false)) {
            $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('file_ktp'))))->toMediaCollection('file_ktp');
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     tags={"User"},
     *     summary="",
     *     operationId="UserShow",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['roles']));
    }
    /**
     * @OA\Put(
     *     path="/api/v1/users/{id}",
     *     tags={"User"},
     *     summary="",
     *     operationId="UserUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="name",type="string"),
     *              @OA\Property(property="email",type="string"),
     *              @OA\Property(property="password",type="string"),
     *              @OA\Property(property="roles",type="array", @OA\Items(type="number")),
     *              @OA\Property(property="nik",type="string"),
     *              @OA\Property(property="tempat_lahir",type="string"),
     *              @OA\Property(property="tanggal_lahir",type="datetime"),
     *              @OA\Property(property="jenis_kelamin",type="string"),
     *              @OA\Property(property="no_hp",type="string")
     *            )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        if ($request->input('photo', false)) {
            if (!$user->photo || $request->input('photo') !== $user->photo->file_name) {
                if ($user->photo) {
                    $user->photo->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($user->photo) {
            $user->photo->delete();
        }

        if ($request->input('file_ktp', false)) {
            if (!$user->file_ktp || $request->input('file_ktp') !== $user->file_ktp->file_name) {
                if ($user->file_ktp) {
                    $user->file_ktp->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('file_ktp'))))->toMediaCollection('file_ktp');
            }
        } elseif ($user->file_ktp) {
            $user->file_ktp->delete();
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     tags={"User"},
     *     summary="",
     *     operationId="UserDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
