<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function getAllTasks()
    {
        $tasks = DB::table('tasks')->paginate(5);
        return json_encode($tasks);
    }

    public function insertTask(Request $request, Task $task)
    {
        $task->name = $request->name;
        $task->created_at = date('Y-m-d H:i:s');
        $task->updated_at = date('Y-m-d H:i:s');
        $task->save();
        $response = array('status' => 'success', 'code' => 201);
        return $response;
    }

    public function deleteTask(Request $request)
    {
        $id = $request->id;

        $task = Task::find($id);
        $task->delete();
    }

    public function updateTask(Request $request)
    {
        $id = $request->id;

        $task = Task::find($id);

        $task->name = $request->name;
        $task->udpated_at = date('Y-m-d H:i:s');
    }
}


