"use client";
import { useState } from "react";
import { InputForm } from "./components/InputForm";
import { TaskList } from "./components/Task/TaskList";
// 型定義
import type { Task } from "./types";

export default function Home() {
  // useStateでtasksを管理
  const [tasks, setTasks] = useState<Task[]>([]);
  // useStateでinputを管理
  const [input, setInput] = useState<string>("");
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
  return (
    <main className="flex min-h-screen items-center justify-center">
      <div className="max-w-md">
        {/* 入力欄 */}
        <InputForm input={input} setInput={setInput} addTask={addTask} />
        {/* タスク一覧 */}
        <TaskList tasks={tasks} toggleTask={toggleTask} />
      </div>
    </main>
  );
}
