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
        // Check if the profile already exists for the user
        $profile = Profile::where('user_id', $user_id)->first();

        if ($profile) {
            // If an old image exists, delete it
            if ($profile->image) {
                // Correct path to check if file exists
                $oldImagePath = public_path('storage/' . $profile->image); // Path in the public directory
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image
                }
            }

            // Update the profile with new image if provided
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('my photo', 'public');
                $validateData['image'] = $path;
            }

            // Update the profile with the new data
            $profile->update($validateData);

            return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile]);
        } else {
            // If profile does not exist, create a new one
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('my photo', 'public');
                $validateData['image'] = $path;
            }
        }
        $profile =  Profile::create($validateData);
        return response()->json(['message' => 'profile created succeffully', 'profile' => $profile]);
    }
}
