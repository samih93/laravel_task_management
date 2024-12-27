<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;

class ProfileController extends Controller
{

    public function show($id)
    {
        $profile = Profile::where('user_id', $id)->first();
        return  response()->json($profile, 200);
    }

    public function store(StoreProfileRequest $request)
    {

        $profile =  Profile::create($request->validated());
        return response()->json(['message' => 'profile created succeffully', 'profile' => $profile]);
    }
}
