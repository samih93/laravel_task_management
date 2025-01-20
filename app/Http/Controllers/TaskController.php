<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {

        $tasks = Auth::user()->tasks;
        return response()->json($tasks, 200);
    }
    public function getTasksByPriority()
    {

        $tasks = Auth::user()->tasks()->orderByRaw("FIELD(priority,'high','medium','low')")->get();
        return response()->json($tasks, 200);
    }
    public function getAllTasks()
    {

        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    public function store(StoreTaskRequest $request)
    {

        $user_id = Auth::user()->id;

        $validateData = $request->validated();
        $validateData["user_id"] = $user_id;

        $task =  Task::create($validateData);
        return response()->json($task, 201);
    }



    public function update(UpdateTaskRequest $request, $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        if ($user_id != $task->user_id)
            return response()->json(['error' => 'access denied'], 404);


        // Use validated data
        $data = array_intersect_key(
            $request->validated(),

        );
        $task->update($data);

        return response()->json($task, 200);
    }
    public function show($id)
    {

        $user_id = Auth::user()->id;

        $task = Task::with('user')->find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        if ($user_id != $task->user_id)
            return response()->json(['error' => 'access denied'], 404);


        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return  response()->json("task delete successfully", 204);
    }


    public function addCateogoriesToTask(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->categories()->attach($request->category_id);

        return  response()->json('category added successfully', 200);
    }
    public function getCategoriesByTask($taskId)
    {
        $categories = Task::with('categories')->findOrFail($taskId);

        return  response()->json($categories, 200);
    }

    public function addToFavorites($taskId)
    {
        $user_id = Auth::user()->id;
        $task = Task::find($taskId);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // $task->favorites()->attach($taskId);
        //! or

        Auth::user()->favorites()->syncWithoutDetaching($taskId); // not throwing an exception if already favorite
        return response()->json(["message" => "task added to favorite",], 200);
    }
    public function removeFromFavorites($taskId)
    {
        $user_id = Auth::user()->id;
        $task = Task::find($taskId);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        Auth::user()->favorites()->detach($taskId); // not throwing an exception if already favorite
        return response()->json(["message" => "task removed from favorite",], 200);
    }
    public function getFavoriteTasks()
    {
        $tasks = Auth::user()->favorites()->orderByRaw("FIELD(priority,'high','medium','low')")->get();
        return response()->json(["message" => "tasks fetched successfully", "data" => $tasks], 200);
    }
}
