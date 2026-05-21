import { TaskItem } from "./TaskItem";
// 型定義
import type { Task } from "../../types";

// Props
type Props = {
  tasks: Task[];
  toggleTask: (id: number) => void;
  deleteTask: (id: number) => void;
};

export const TaskList = ({ tasks, toggleTask, deleteTask }: Props) => {
  return (
    <ul className="flex flex-col gap-3 mb-6">
      {tasks.map((task) => (
        <TaskItem
          key={task.id}
          task={task}
          toggleTask={toggleTask}
          deleteTask={deleteTask}
        />
      ))}
    </ul>
  );
};
