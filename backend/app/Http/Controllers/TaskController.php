<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index() {
        $task = Task::all();
        return response($task);
    }

    public function create(Request $request) {
        Task::create([
            'task_name' => $request->task_name,
            'status' => 'Belum Selesai',
            'priority' => $request->priority,
            'date' => $request->date
        ]);
    }

    public function update($id) {
        $task = Task::find($id);
        $task->update([
            'status' => 'Selesai',
        ]);
    }

    public function delete($id) {
        $task = Task::find($id);
        $task->delete();
    }
}
