// import { defineConfig } from "vite";
// import { resolve } from "path";

// export default defineConfig({
//   root: "src",
//   base: "/portfolio/",
//   build: {
//     // outDir: '../dist',
//     outDir: "../theme/build", // 変更：テーマフォルダ内へ出力
//     manifest: true, // 追加：manifest.json を生成
//     emptyOutDir: true,
//     rollupOptions: {
//       input: {
//         main: resolve(__dirname, "src/js/main.js"),
//         style: resolve(__dirname, "src/scss/style.scss"),
//       },
//     },
//   },
//   server: {
//     open: true,
//     host: 'localhost',
//     port: 5173,
//     strictPort: true,          // 5173が埋まってたら別ポートに逃げず、エラーで止める（アドレス固定のため）
//     cors: true,                // WordPress(8888)からアセットを読み込む許可
//     origin: 'http://localhost:5173',  // Viteが生成するURLの土台を固定
//   },
//   publicDir: "../public",
// });
import { defineConfig } from 'vite';
import { resolve } from 'path';
import fs from 'fs';

// Viteサーバー起動時に hot ファイルを作り、終了時に消すプラグイン
function writeHotFile() {
  const viteDir = resolve(__dirname, 'theme/build/.vite');
  const hotPath = resolve(viteDir, 'hot');
  return {
    name: 'write-hot-file',
    configureServer() {
      fs.mkdirSync(viteDir, { recursive: true });
      fs.writeFileSync(hotPath, 'http://localhost:5173');
      const clean = () => { try { fs.unlinkSync(hotPath); } catch (e) {} };
      process.on('exit', clean);
      process.on('SIGINT', () => { clean(); process.exit(); });
      process.on('SIGTERM', () => { clean(); process.exit(); });
    },
  };
}

export default defineConfig(({ command }) => ({
  root: 'src',
  // dev（serve）時は '/'、本番ビルド時は '/portfolio/'
  base: command === 'serve' ? '/' : '/portfolio/',
  build: {
    outDir: '../theme/build',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        main:  resolve(__dirname, 'src/js/main.js'),
        style: resolve(__dirname, 'src/scss/style.scss'),
      },
    },
  },
  server: {
    open: false,
    host: 'localhost',
    port: 5173,
    strictPort: true,
    cors: true,
    origin: 'http://localhost:5173',
  },
  publicDir: '../public',
  plugins: [
    writeHotFile(),
  ],
}));
