<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function getAllTasks()
    {
        if(Session::get('logged'))
        {
            $tasks = DB::table('tasks')->paginate(5);
            return json_encode($tasks);
        }

    }

    public function insertTask(Request $request, Task $task)
    {
        if(Session::get('logged')) {
            $task->name = $request->name;
            $task->created_at = date('Y-m-d H:i:s');
            $task->updated_at = date('Y-m-d H:i:s');
            $task->save();
            $id = $task->id;
            $response = array('status' => 'success', 'code' => 201,'id' => $id);
            return $response;
        }
    }

    public function deleteTask(Request $request)
    {
        if(Session::get('logged')) {
            $id = $request->id;

            $task = Task::find($id);
            $task->delete();

            return ['status' => 'success', 'code' => 200];
        }
    }

    public function updateTask(Request $request)
    {
        if(Session::get('logged')) {
            $id = $request->id;
            $task = Task::find($id);

            $task->name = $request->name;
            $task->updated_at = date('Y-m-d H:i:s');

            $task->save();
            return ['status' => 'success', 'code' => 201];
        }
    }
}


