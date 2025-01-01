<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    public function store(StoreTaskRequest $request)
    {

        $task =  Task::create($request->validated());
        return response()->json($task, 201);
    }



    public function update(UpdateTaskRequest $request, $id)
    {


        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Use validated data
        $data = array_intersect_key(
            $request->validated(),

        );
        $task->update($data);

        return response()->json($task, 200);
    }
    public function show($id)
    {


        $task = Task::with('user')->find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return  response()->json("task delete successfully", 204);
    }
}
