<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // 1. データベースからすべてのタスクを取得する
        $tasks = Task::all();

        // 2. 指示通りの形式 {"tasks": [...]} でJSONレスポンスを返す
        return response()->json([
            'tasks' => $tasks
        ]);
    }
}