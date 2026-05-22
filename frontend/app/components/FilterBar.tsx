// 型定義
import type { Filter, Task } from "../types";

// Props
type Props = {
  filter: Filter;
  setFilter: (value: Filter) => void;
  tasks: Task[];
};

export const FilterBar = ({ filter, setFilter, tasks }: Props) => {
  // ボタンの状態を配列としてまとめる
  const filterOptions = [
    { type: "all" as const, label: "全て" },
    { type: "active" as const, label: "未完了" },
    { type: "completed" as const, label: "完了" },
  ];
  // 画面に表示する前に、あらかじめそれぞれの数を計算しておく
  const totalCount = tasks.length;
  const activeCount = tasks.filter((task) => !task.completed).length;
  const completeCount = tasks.filter((task) => task.completed).length;
  return (
    <div className="flex items-center border border-gray-200 px-4 py-2 mb-6">
      {/* ボタン */}
      <div className="flex gap-2 mr-auto">
        {/* 配列をループ（map）して、自動で3つのボタンを生成する */}
        {filterOptions.map((option) => (
          <button
            key={option.type}
            className={`border text-xs px-4 py-2 transition-colors ${
              filter === option.type
                ? "bg-gray-900 border-gray-900 text-white"
                : "bg-white border-gray-200 text-gray-700"
            }`}
            onClick={() => setFilter(option.type)}
          >
            {option.label}
          </button>
        ))}
      </div>
      {/* フィルタリング結果 */}
      <div className="text-xs text-gray-400">
        全て{totalCount} | 未完了{activeCount} | 完了{completeCount}
      </div>
    </div>
  );
};
