<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    // テストを実行するたびにデータベースを綺麗にリセットする魔法の1行
    use RefreshDatabase;

    /**
     * ケース1：データがない（空っぽの）ケース
     */
    public function test_can_get_empty_task_list(): void
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200);
        $response->assertJson([
            'tasks' => []
        ]);
    }

    /**
     * ケース2：データがあるケース
     */
    public function test_can_get_task_list_with_data(): void
    {
        Task::factory()->count(2)->create();

        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'tasks' => [
                '*' => ['id', 'title', 'created_at', 'updated_at']
            ]
        ]);
        $response->assertJsonCount(2, 'tasks');
    }

    /**
     * タスクが正常に作成できることをテスト
     */
    public function test_can_create_task(): void
    {
        $data = ['title' => '新しいテストタスク'];

        $response = $this->postJson('/api/tasks', $data);
        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * タイトルが空の場合はバリデーションエラーになることをテスト
     */
    public function test_create_task_requires_title(): void
    {
        $response = $this->postJson('/api/tasks', ['title' => '']);
        $response->assertStatus(422);
    }

    /**
     * タスクが正常に更新できることをテスト（正常系）
     */
    public function test_can_update_task(): void
    {
        // 1. テスト用のタスクを1件データベースに作成しておく
        $task = Task::factory()->create([
            'title' => '元のタイトル',
            'completed' => false
        ]);

        // 2. 更新したいデータを用意
        $updateData = [
            'title' => 'アップデートしたタスク',
            'completed' => true
        ];

        // 3. PUT /api/tasks/{id} にデータを送る
        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        // 4. ステータスコードが 200 であること、データが更新されていることを確認
        $response->assertStatus(200)
                 ->assertJsonFragment($updateData);

        // 5. データベースの中身も本当に書き換わっているか確認
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'アップデートしたタスク',
            'completed' => true
        ]);
    }

    /**
     * 存在しないIDの場合は404エラーになることをテスト（異常系）
     */
    public function test_update_task_returns_404_if_not_found(): void
    {
        $response = $this->putJson('/api/tasks/9999', [
            'title' => '存在しないはず'
        ]);
        $response->assertStatus(404);
    }

    /**
     * completedをnullにして送信した場合も問題なく動作するかテスト
     */
    public function test_update_task_with_null_completed(): void
    {
        // 1. 元のタスクを作成（最初から completed を false にしておく）
        $task = Task::factory()->create([
            'title' => 'タスクタイトル',
            'completed' => false
        ]);

        // 2. completed を null にして送信する
        $updateData = [
            'title' => 'タイトルだけ更新',
            'completed' => null
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        // 3. 404 や 500 エラーにならず、200 OK が返ってくることを確認
        $response->assertStatus(200);

        // 4. データベースのタイトルは変わり、completedはnullが無視されて元のfalse(0)を維持しているか確認
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'タイトルだけ更新',
            'completed' => false 
        ]);
    }

    /**
     * タスクが正常に削除できることをテスト（正常系）
     */
    public function test_can_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    /**
     * 存在しないIDを削除しようとした場合は404エラーになることをテスト（異常系）
     */
    public function test_delete_task_returns_404_if_not_found(): void
    {
        $response = $this->deleteJson('/api/tasks/9999');
        $response->assertStatus(404);
    }
}