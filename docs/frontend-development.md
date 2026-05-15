# フロントエンド開発手順（Next.js）

## 担当者

岡さん

## 作業ディレクトリ

`frontend/`

## 主なファイル

| パス | 役割 |
|------|------|
| `app/page.tsx` | トップページ（メイン画面） |
| `app/layout.tsx` | 全体レイアウト |
| `app/globals.css` | グローバルCSS |
| `app/components/` | Reactコンポーネント（自分で作成） |
| `app/hooks/` | カスタムフック（自分で作成） |

## 開発手順

1. コードを編集する
2. 保存するとブラウザが**自動リロード**される（ホットリロード）
3. http://localhost:3008 で動作確認

## 注意点

- ファイル保存時に自動で画面が更新されるので、ブラウザリロードは不要
- TypeScriptの型エラーはVS Codeで即座に確認できる
- コンポーネントは小さく分割することを心がける

## よくあるトラブル

| トラブル | 解決策 |
|---------|--------|
| 変更が画面に反映されない | ブラウザをリロード（F5）。それでもダメなら docker compose restart nextjs |
| TypeScriptのエラーが出る | `npm run tsc --noEmit` で型チェック |
| 依存パッケージを追加したい | `docker compose exec nextjs npm install パッケージ名` |
