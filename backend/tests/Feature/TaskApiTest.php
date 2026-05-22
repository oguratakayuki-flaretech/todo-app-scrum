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
}