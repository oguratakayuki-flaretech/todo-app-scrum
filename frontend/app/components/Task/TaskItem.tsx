// 型定義
import type { Task } from "../../types";

// Props
type Props = {
  task: Task;
  toggleTask: (id: number) => void;
};

// Propsだと宣言してtaskを分割代入
export const TaskItem = ({ task, toggleTask }: Props) => {
  return (
    <li className="border border-gray-200 px-4 py-2">
      <input
        type="checkbox"
        className="mr-2"
        checked={task.completed}
        onChange={() => toggleTask(task.id)}
      />
      <span className={task.completed ? "line-through text-gray-400" : ""}>
        {task.title}
      </span>
    </li>
  );
};
