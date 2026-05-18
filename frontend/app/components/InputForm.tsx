export const InputForm = () => {
  //   const handleClick = () => {
  //     console.log("押された");
  //   };

  return (
    <div className="flex gap-2 mb-6">
      {/* 入力欄 */}
      <input
        className="flex-1 border border-gray-200 rounded-lg px-4 py-2 text-sm outline-none focus:border-gray-400 transition"
        placeholder="タスクを入力..."
      />
      {/* ボタン */}
      <button className="bg-gray-800 text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-700 transition">
        追加
      </button>
    </div>
  );
};
