<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, $id){
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $list = Lists::findOrFail($id);
        if ($list->user_id !== auth()->id())
            return response()->json(['message' => 'Unauthorized'], 403);

        $task = Task::create([
            'list_id' => $list->id,
            'title' => $request->title,
            "is_done" => false,
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }
    public function updateTask(Request $request, $id){
        $task = Task::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'is_done' => 'required|boolean',
        ]);
        $task->update([
            'title' => $request->title ?? $task->title,
            'is_done' => $request->is_done ?? $task->is_done,
        ]);
        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }
    public function delete($id){
        Task::findOrFail($id)->delete();
        return response()->json([
            "message"=>"Task deleted successfully"
        ]);
    }
    public function getAuthorizedUserTasks(){
        $user_id = auth()->id();
        $lists = Lists::where('user_id', $user_id)->get();
        $tasks = Task::whereIn('list_id', $lists->pluck('id'))->where('is_done', false)->get();
        return response()->json(["tasks" => $tasks]);
    }
    public function search(Request $request){
        $query = $request->input('query');
        $tasks = Task::where('title', 'like', "%{$query}%")->get();
        return response()->json(["tasks" => $tasks]);
    }
}
