<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function show($id)
    {
        $user_id = Auth::user()->id;
        $profile = Profile::where('user_id', $id)->first();

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }
        if ($user_id != $profile->user_id)
            return response()->json(['error' => 'access denied'], 404);

        return  response()->json($profile, 200);
    }

    public function store(StoreProfileRequest $request)
    {
        $user_id = Auth::user()->id;

        $validateData = $request->validated();
        $validateData["user_id"] = $user_id;
        $profile =  Profile::create($validateData);
        return response()->json(['message' => 'profile created succeffully', 'profile' => $profile]);
    }
}
