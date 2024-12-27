<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProfile($id)
    {
        $user =   User::find($id)->profile;
        return response()->json($user, 200);
    }
}