<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function index()
    {
        return view('frontend.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());
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
        return redirect()->route('frontend.profile.index')->with('message', __('global.update_profile_success'));
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }

    public function password(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());

        return redirect()->route('frontend.profile.index')->with('message', __('global.change_password_success'));
    }
}
