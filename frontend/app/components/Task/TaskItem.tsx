// 型定義
import type { Task } from "../../types";

// Props
type Props = {
  task: Task;
};

// Propsだと宣言してtaskを分割代入
export const TaskItem = ({ task }: Props) => {
  return <li className="border border-gray-200 px-4 py-2">{task.title}</li>;
};
