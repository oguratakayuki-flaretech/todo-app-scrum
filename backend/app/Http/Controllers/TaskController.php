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

    public function update(Request $request, $id)
    {
        // 1. 指定されたIDのタスクを探す（なければ自動で404エラーになる優れもの）
        $task = Task::findOrFail($id);

        // 2. バリデーションチェック
        // titleは空でもOK(nullable)だけど、文字数は255文字まで
        // completedは空でもOKだけど、中身はtrueかfalse(boolean)
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'completed' => 'nullable|boolean',
        ]);

        // 3. 安全にチェックを通ったデータ（$validated）だけでタスクを更新
        $task->update($validated);

        // 4. 更新されたあとのタスクの情報を、200 OK で返却
        return response()->json($task, 200);
    }
}