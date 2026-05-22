<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController; // ★ use宣言は上にまとめておくときれいです

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

// --- タスクAPIのルート一覧 ---
Route::get('/tasks', [TaskController::class, 'index']);      // 一覧取得
Route::post('/tasks', [TaskController::class, 'store']);     // 新規作成
Route::put('/tasks/{id}', [TaskController::class, 'update']); // タスク更新
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // タスク削除

