export const InputForm = () => {
  const handleClick = () => {
    console.log("追加された");
  };

  return (
    <div className="flex gap-2 mb-6">
      {/* 入力欄 */}
      <input
        className="border border-gray-200 px-4 py-2 outline-none"
        placeholder="📝 新しいタスクを入力..."
      />
      {/* ボタン */}
      <button
        className="bg-gray-900 text-white px-4 py-2"
        onClick={handleClick}
      >
        追加
      </button>
    </div>
  );
};
