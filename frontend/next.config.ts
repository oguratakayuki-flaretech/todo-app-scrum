// @ts-nocheck
import type { NextConfig } from 'next';

const nextConfig: NextConfig = {
  // 1. Next.js 16のTurbopack用・ファイル監視設定（空っぽにせず、監視ルールを教える）
  turbopack: {
    watch: {
      poll: 1000, // 1秒ごとにファイルをチェック（Docker対策）
    },
  },

  // 2. 昔のwebpackの設定は完全に削除（これが残っているとNext.js 16が怒るため）
} as any;

export default nextConfig;