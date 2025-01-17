<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        // return $request->all();
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        // Create a new task
        if(isset($request->task_id)) {
            $task = Task::find($request->task_id);
        } else {
            $task = new Task();
        }
            $task->title = $request->input('title');
            $task->description = $request->input('description');
            $task->status = 'Pending'; // Set the initial status

        // Save the task to the database
        $task->save();

        // Optionally, return a response to indicate success
        return response()->json(['id' => $task->id]);
    }


    public function index(Request $request)
    {
        // Fetch all tasks from the database
        $tasks = Task::all();

        // Optionally, return tasks as JSON for AJAX requests
        return response()->json($tasks);
    }

    public function update(Request $request, $id)
    {
        // Find the task by its ID
        $task = Task::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'title' => 'max:255',
            'status' => 'in:Pending,Completed', // Define allowed statuses
        ]);

        // Update the task properties
        if($request->input('title'))
        $task->title = $request->input('title');
        if($request->input('description'))
        $task->description = $request->input('description');
        if($request->input('status'))
        $task->status = $request->input('status');

        // Save the updated task to the database
        $task->save();

        // Optionally, return a response to indicate success
        return response()->json(['data' => $task], 200);
    }
    
    public function edit($id)
    {
        // Find the task by its ID
        $task = Task::find($id);
        
        // Optionally, return a response to indicate success
        return response()->json($task);
    }

    public function destroy($id)
    {
        // Find the task by its ID
        $task = Task::where('id', $id)->delete();
        
        // Optionally, return a response to indicate success
        return response()->json(['message' => 'Task deleted successfully'], 200);
    }
}
