"use client";
import { useState } from "react";
import { InputForm } from "./components/InputForm";
import { TaskList } from "./components/Task/TaskList";
import { FilterBar } from "./components/FilterBar";
import { Header } from "./components/Header";
import { Footer } from "./components/Footer";
// 型定義
import type { Task, Filter } from "./types";

export default function Home() {
  // useStateでtasksを管理
  const [tasks, setTasks] = useState<Task[]>([]);
  // useStateでinputを管理
  const [input, setInput] = useState<string>("");
  // useStateでfilterを管理
  const [filter, setFilter] = useState<Filter>("all");
  // タスクを追加
  const addTask = () => {
    if (!input.trim()) return;
    setTasks([...tasks, { id: Date.now(), title: input, completed: false }]);
    setInput("");
  };
  // チェックボックスの状態切り替え
  const toggleTask = (id: number) => {
    setTasks(
      tasks.map((task) =>
        task.id === id ? { ...task, completed: !task.completed } : task,
      ),
    );
  };
  // 削除ボタンを押したら完了タスクを削除
  const deleteTask = (id: number) => {
    setTasks(tasks.filter((task) => task.id !== id));
  };
  // フィルターで表示タスクを切り替え
  const filteredTasks = tasks.filter((task) => {
    if (filter === "all") return true;
    if (filter === "active") return !task.completed;
    if (filter === "completed") return task.completed;
  });
  return (
    <main className="flex min-h-screen items-center justify-center">
      <div className="max-w-md w-full shadow-md">
        {/* ヘッダー */}
        <Header />
        <div className="p-6">
          {/* 入力欄 */}
          <InputForm input={input} setInput={setInput} addTask={addTask} />
          {/* フィルター */}
          <FilterBar filter={filter} setFilter={setFilter} tasks={tasks} />
          {/* タスク一覧 */}
          <TaskList
            tasks={filteredTasks}
            toggleTask={toggleTask}
            deleteTask={deleteTask}
          />
          {/* フッター */}
          <Footer />
        </div>
      </div>
    </main>
  );
}
