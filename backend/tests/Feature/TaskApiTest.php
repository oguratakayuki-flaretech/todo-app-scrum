<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task; // ★これが必要になるので追加します

class TaskApiTest extends TestCase
{
    // テストを実行するたびにデータベースを綺麗にリセットする魔法の1行
    use RefreshDatabase;

    /**
     * ケース1：データがない（空っぽの）ケース
     */
    public function test_can_get_empty_task_list(): void
    {
        // 1. データが何も無い状態でAPIにアクセス
        $response = $this->getJson('/api/tasks');

        // 2. 200 OK が返ってくること
        $response->assertStatus(200);

        // 3. tasks の中身が空っぽであることを確認
        $response->assertJson([
            'tasks' => []
        ]);
    }

    /**
     * ケース2：データがあるケース
     */
    public function test_can_get_task_list_with_data(): void
    {
        // 1. テストデータを2件、データベースに「種まき（Seed）」する
        Task::factory()->count(2)->create();

        // 2. データがある状態でAPIにアクセス
        $response = $this->getJson('/api/tasks');

        // 3. 200 OK が返ってくること
        $response->assertStatus(200);

        // 4. 返ってきたJSONの中に、ちゃんと「tasks」というキーがあることと、
        //    データが2件（Count: 2）入っていることを確認する
        $response->assertJsonStructure([
            'tasks' => [
                '*' => ['id', 'title', 'created_at', 'updated_at']
            ]
        ]);
        
        // 念のため2件取得できているか数を確認
        $response->assertJsonCount(2, 'tasks');
    }

    /**
     * タスクが正常に作成できることをテスト
     */
    public function test_can_create_task(): void
    {
        // 1. テスト用のデータを用意
        $data = ['title' => '新しいテストタスク'];

        // 2. POST /api/tasks にデータを送る
        $response = $this->postJson('/api/tasks', $data);

        // 3. ステータスコードが 201 であること、データが返ってきていることを確認
        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        // 4. データベースに本当に保存されたか確認
        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * タイトルが空の場合はバリデーションエラーになることをテスト
     */
    public function test_create_task_requires_title(): void
    {
        // タイトルを空にしてデータを送る
        $response = $this->postJson('/api/tasks', ['title' => '']);

        // 422（バリデーションエラー）が返ってくることを確認
        $response->assertStatus(422);
    }
}