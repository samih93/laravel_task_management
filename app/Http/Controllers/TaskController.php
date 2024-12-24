<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:40'], // Each rule is a separate array element
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'integer', 'between:1,5'],
        ]);
        $task =  Task::create($validatedData);
        return response()->json($task, 201);
    }



    public function update(Request $request, $id)
    {


        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $data = $request->only('title'); // Check this to ensure you get the right keys/values
        $task->update($data);

        return response()->json($task, 200);
    }
    public function show($id)
    {


        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 200);
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
