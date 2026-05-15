# バックエンド開発手順（Laravel）

## 担当者

小川さん

## 作業ディレクトリ

`backend/`

## 主なファイル

| パス | 役割 |
|------|------|
| `routes/api.php` | APIルート定義 |
| `app/Http/Controllers/` | コントローラー |
| `app/Models/` | モデル（Eloquent） |
| `database/migrations/` | テーブル定義 |
| `.env` | 環境設定（DB接続など） |

## 開発手順

1. コードを編集する
2. ブラウザで http://localhost:8000 を開く
3. 動作確認（**手動リロードが必要**）

## 注意点

- **ブラウザは手動でリロード（F5）が必要**（自動更新されない）
- Laravelサーバーはコード変更を検知して自動再起動するため、サーバー再起動コマンドは不要
- 新しくコントローラーやモデルを作成した場合、キャッシュクリアが必要な場合がある

```bash
docker compose exec laravel php artisan cache:clear

## よくあるトラブル

| トラブル | 解決策 |
|---------|--------|
| 変更が反映されない | ブラウザをリロード（F5）。それでもダメなら docker compose restart laravel |
| Composerでパッケージを追加したい | docker compose exec laravel composer require パッケージ名 |
| マイグレーションを実行したい | docker compose exec laravel php artisan migrate |
| シーダーを実行したい | docker compose exec laravel php artisan db:seed |
