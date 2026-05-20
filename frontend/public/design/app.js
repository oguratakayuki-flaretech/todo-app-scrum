document.addEventListener("DOMContentLoaded", () => {
  const input = document.querySelector(".app__input");
  const addButton = document.querySelector(".app__btn");
  const taskList = document.querySelector(".app__schedule");
  const countText = document.querySelector(".app__count");
  const tabs = document.querySelectorAll(".app__tab");

  let currentFilter = "all";

  let tasks = Array.from(document.querySelectorAll(".app__task")).map((task, index) => {
    return {
      id: Date.now() + index,
      title: task.querySelector(".app__assignment").textContent.trim(),
      completed: task.classList.contains("app__task--done"),
      priority: task.classList.contains("app__task--priority"),
    };
  });

  const filterMap = {
    全て: "all",
    未完了: "active",
    完了: "completed",
  };

  const createId = () => {
    if (window.crypto && crypto.randomUUID) {
      return crypto.randomUUID();
    }

    return String(Date.now() + Math.random());
  };

  const getFilteredTasks = () => {
    if (currentFilter === "active") {
      return tasks.filter((task) => !task.completed);
    }

    if (currentFilter === "completed") {
      return tasks.filter((task) => task.completed);
    }

    return tasks;
  };

  const renderTasks = () => {
    taskList.innerHTML = "";

    const filteredTasks = getFilteredTasks();

    filteredTasks.forEach((task) => {
      const taskItem = document.createElement("div");

      taskItem.className = [
        "app__task",
        task.completed ? "app__task--done" : "",
        task.priority ? "app__task--priority" : "",
      ]
        .filter(Boolean)
        .join(" ");

      taskItem.dataset.id = task.id;

      taskItem.innerHTML = `
          <div class="app__task-content">
            <button type="button" class="app__check" aria-label="完了状態を切り替える">
              <i class="fa-solid fa-check"></i>
            </button>
            <p class="app__assignment">${task.title}</p>
          </div>
  
          <div class="app__task-actions">
            <button type="button" class="app__delete" aria-label="タスクを削除">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        `;

      taskList.appendChild(taskItem);
    });

    updateCount();
  };

  const updateCount = () => {
    const totalCount = tasks.length;
    const activeCount = tasks.filter((task) => !task.completed).length;

    countText.textContent = `${totalCount}タスク・未完了${activeCount}`;
  };

  const addTask = () => {
    const title = input.value.trim();

    if (title === "") {
      alert("タスクを入力してください");
      return;
    }

    tasks.push({
      id: createId(),
      title,
      completed: false,
      priority: false,
    });

    input.value = "";

    currentFilter = "all";

    tabs.forEach((tab) => {
      tab.classList.remove("is-active");

      if (tab.textContent.trim() === "全て") {
        tab.classList.add("is-active");
      }
    });

    renderTasks();
  };

  addButton.addEventListener("click", addTask);

  input.addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      addTask();
    }
  });

  taskList.addEventListener("click", (event) => {
    const taskItem = event.target.closest(".app__task");

    if (!taskItem) return;

    const taskId = taskItem.dataset.id;

    if (event.target.closest(".app__check")) {
      tasks = tasks.map((task) => {
        if (String(task.id) === String(taskId)) {
          return {
            ...task,
            completed: !task.completed,
          };
        }

        return task;
      });

      renderTasks();
    }

    if (event.target.closest(".app__delete")) {
      tasks = tasks.filter((task) => String(task.id) !== String(taskId));
      renderTasks();
    }
  });

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      tabs.forEach((tab) => tab.classList.remove("is-active"));
      tab.classList.add("is-active");

      const tabText = tab.textContent.trim();
      currentFilter = filterMap[tabText];

      renderTasks();
    });
  });

  renderTasks();
});
