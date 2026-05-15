# 環境構築手順

## 必要なソフトウェア

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)（バージョン20.10以上）
- Git
- ブラウザ（Chrome / Firefox 推奨）

## 初回セットアップ

```bash
# リポジトリをクローン
git clone <リポジトリURL>
cd todo-app

# コンテナを起動
docker compose up -d

## 起動確認

| サービス | URL | 期待される表示 |
|---------|-----|---------------|
| Next.js（フロント） | http://localhost:3008 | Next.jsの初期画面 |
| Laravel（API） | http://localhost:8000 | Laravelのウェルカム画面 |

## コンテナの停止

```bash
docker compose down

## コンテナの停止

```bash
docker compose down

## よくあるトラブル

| トラブル | 解決策 |
|---------|--------|
| docker compose up でエラー | docker compose down -v してから再起動 |
| ポート3008が既に使われている | 他のアプリを終了するか、docker-compose.ymlのポートを変更 |
| Next.jsの変更が反映されない | docker compose restart nextjs |
| Laravelの変更が反映されない | ブラウザをリロード（F5）。それでもダメなら docker compose restart laravel |

## 開発の流れ

```bash
# 1. 最新のコードを取得
git pull origin main

# 2. 作業用ブランチを作成
git checkout -b feature/タスク名

# 3. コーディング（ここで編集）

# 4. コミット
git add .
git commit -m "[FE] やったことの概要"

# 5. プッシュ
git push origin feature/タスク名

# 6. GitHubでプルリクエストを作成

# 7. レビューを受けてマージ

## 困ったときは

1. まず `docs/` 内の関連ドキュメントを確認する
2. Slackの専用チャンネルで質問する
3. リーダーにメンションする

### 質問するときのフォーマット

- 何をやろうとしているか
- どんなエラーが出ているか（スクリーンショット推奨）
- 試したこと
