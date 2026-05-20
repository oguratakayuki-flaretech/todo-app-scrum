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

    public function store(\Illuminate\Http\Request $request)
    {
        // バリデーション：title は必須、文字列、最大255文字
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // リクエストから title を受け取り、新規タスクを作成
        $task = \App\Models\Task::create([
            'title' => $validated['title'],
        ]);

        // 作成したタスクをレスポンスとして返す（ステータスコード201）
        return response()->json($task, 201);
    }
}