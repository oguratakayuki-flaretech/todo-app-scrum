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

    public function store(Request $request)
    {
        // バリデーション：title は必須、文字列、最大255文字
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // リクエストから title を受け取り、新規タスクを作成
        $task = Task::create([
            'title' => $validated['title'],
        ]);

        // 作成したタスクをレスポンスとして返す（ステータスコード201）
        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        // 1. 指定されたIDのタスクを探す（なければ自動で404エラー）
        $task = Task::findOrFail($id);

        // 2. バリデーションチェック
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'completed' => 'nullable|boolean',
        ]);

        // 3. 【修正のポイント】null のデータは無視して、値があるものだけを上書きする
        
        // title がリクエストに含まれている場合のみ上書き
        if ($request->has('title')) {
            $task->title = $validated['title'];
        }

        // completed がリクエストに含まれていて、かつ null ではない場合のみ上書き
        if ($request->has('completed') && !is_null($request->input('completed'))) {
            $task->completed = $validated['completed'];
        }

        // 4. 変更をデータベースに保存
        $task->save();

        // 5. 更新されたあとのタスクの情報を、200 OK で返却
        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        // 1. 指定されたIDのタスクを探す（存在しなければ自動で404エラーを返す）
        $task = Task::findOrFail($id);

        // 2. データベースからタスクを削除する
        $task->delete();

        // 3. 204 No Content（削除成功・返す中身はなし）のステータスコードを返却
        return response()->noContent();
    }
}