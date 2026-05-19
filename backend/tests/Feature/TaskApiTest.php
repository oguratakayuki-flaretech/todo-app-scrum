<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    // テストを実行するたびにデータベースを綺麗にする設定
    use RefreshDatabase;

    /**
     * タスク一覧API（GET /api/tasks）が正しく空のリストを返すかテスト
     */
    public function test_can_get_empty_task_list(): void
    {
        // 1. 指定したURLにGETリクエストを送る
        $response = $this->getJson('/api/tasks');

        // 2. 画面の返事（ステータスコード）が「200 OK（成功）」であることを確認
        $response->assertStatus(200);

        // 3. 返ってきたデータが期待通りのJSON形式であることを確認
        $response->assertJson([
            'tasks' => []
        ]);
    }
}