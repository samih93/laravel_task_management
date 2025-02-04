<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategoryTasks($categoryId)
    {
        $tasks = Category::with('tasks')->findOrFail($categoryId);

        return  response()->json($tasks, 200);
    }
}
