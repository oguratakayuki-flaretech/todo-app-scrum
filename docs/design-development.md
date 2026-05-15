# デザイン開発手順

## 担当者

伊藤さん

## 作業ディレクトリ

- 静的HTML/CSS作成時：`frontend/public/design/`
- React移植時：`frontend/app/components/`

## 開発手順（静的HTML/CSS）

1. `frontend/public/design/index.html` を作成
2. draw.ioのモックを参考にコーディング
3. ブラウザで直接ファイルを開いて確認

## 開発手順（React移植）

1. `frontend/app/components/` にコンポーネントファイルを作成
2. 作成したHTML/CSSをJSXに変換
3. `class` → `className` に変換する
4. スタイルはそのままCSSファイルに記録

## 注意点

- ボタンの動作は後から実装するので、現時点では「見た目だけ」でOK
- デザインは後からフロントエンドに当て込む前提なので、焦らなくてOK
- タスク一覧の3つの項目は固定で表示してOK

## よくあるトラブル

| トラブル | 解決策 |
|---------|--------|
| デザインが崩れる | Chrome DevToolsで該当要素のCSSを確認 |
| Reactに移植したらレイアウトが変わる | `class` が `className` になっているか確認 |
| 画像が表示されない | パスが正しいか確認（`/images/` など） |
