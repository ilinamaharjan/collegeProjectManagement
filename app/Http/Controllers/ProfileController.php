<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Alert;
use App\Models\Company;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->all();
        try {
            $user = User::where('id', auth()->id())->with('media')->first();
            $user->update($data);
            if (array_key_exists('photo', $data)) {
                if ($user->hasMedia('profile-photo')) {
                    $user->deleteMedia($user->media[0]['id']);
                }
                $user->addMedia($data['photo'])->toMediaCollection('profile-photo');
            }
            Alert::success('Success', 'Profile Updated');
            return back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function store(Request $request)
    {
    }

    public function userPage(Company $company)
    {
        return view('backend.profile.userPage', compact('company'));
    }
}
