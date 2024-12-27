<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(StoreProfileRequest $request)
    {

        $task =  StoreProfileRequest::create($request->validated());
        return response()->json($task, 201);
    }
}
