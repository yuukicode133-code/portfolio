import { defineConfig } from 'vite';

export default defineConfig({
  root: './',          // HTMLファイルがあるディレクトリ
  build: {
    outDir: 'dist',    // ビルド出力先
  },
  server: {
    open: true,        // dev server起動時にブラウザを自動で開く
  },
});