FROM node:20-alpine

WORKDIR /app

# npm installは起動時に行う（開発用）
# イメージに依存パッケージを焼き込まない

EXPOSE 3000

# 開発用のデフォルトコマンド（docker-composeで上書きする）
CMD ["sh", "-c", "if [ ! -d node_modules ]; then npm install; fi; npm run dev"]
