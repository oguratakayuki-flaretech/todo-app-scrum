import { useState } from "react";

// props
type Props = {
  input: string;
  setInput: (value: string) => void;
  addTask: () => void;
};

export const InputForm = ({ input, setInput, addTask }: Props) => {
  return (
    <div className="flex gap-2 mb-6">
      {/* 入力欄 */}
      <input
        className="border border-gray-200 px-4 py-2 outline-none"
        placeholder="📝 新しいタスクを入力..."
        value={input}
        onChange={(e: React.ChangeEvent<HTMLInputElement>) =>
          setInput(e.target.value)
        }
      />
      {/* ボタン */}
      <button className="bg-gray-900 text-white px-4 py-2" onClick={addTask}>
        追加
      </button>
    </div>
  );
};
