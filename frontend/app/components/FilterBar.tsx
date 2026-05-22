// 型定義
import type { Filter } from "../types";

// Props
type Props = {
  filter: Filter;
  setFilter: (value: Filter) => void;
};

export const FilterBar = ({ filter, setFilter }: Props) => {
  return (
    <div className="border border-gray-200">
      <button>aaa</button>
      <button>aaa</button>
      <button>aaa</button>
    </div>
  );
};
