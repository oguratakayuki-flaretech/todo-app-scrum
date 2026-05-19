<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // id（主キー、自動増分）
            $table->string('title'); // title（文字列、タスク内容）
            $table->boolean('completed')->default(false); // completed（boolean、デフォルトfalse）
            $table->timestamps(); // created_at と updated_at（タイムスタンプ）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
