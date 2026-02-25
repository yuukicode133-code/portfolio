## favicon設定の追加

静的サイトのポートフォリオにfaviconを設定してください。

### 前提
- 静的サイト（Vite使用）
- favicon画像ファイルは自分で `assets/image/favicon/` に配置済みとする
- テーマカラー: `#51733f`

### 生成されたfavicon画像ファイル一覧
- apple-touch-icon.png（180×180）
- favicon-96x96.png（96×96）
- favicon.ico（48×48）
- favicon.svg
- web-app-manifest-192x192.png（192×192）
- web-app-manifest-512x512.png（512×512）

### やること

#### 1. `assets/image/favicon/` ディレクトリを作成
上記の画像ファイルを格納するためのディレクトリ。画像は後から自分で配置するので、ディレクトリだけ作成。

#### 2. `index.html` の `<head>` 内にfaviconタグを追加
以下を追加する（既存のタグは変更しない）：
```html
<link rel="icon" type="image/png" href="./assets/image/favicon/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="./assets/image/favicon/favicon.svg" />
<link rel="shortcut icon" href="./assets/image/favicon/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="./assets/image/favicon/apple-touch-icon.png" />
<link rel="manifest" href="./site.webmanifest" />
<meta name="theme-color" content="#51733f">
```

#### 3. プロジェクトルートに `site.webmanifest` を作成
以下の内容で作成：
```json
{
  "name": "Portfolio",
  "short_name": "Portfolio",
  "icons": [
    {
      "src": "./assets/image/favicon/web-app-manifest-192x192.png",
      "sizes": "192x192",
      "type": "image/png",
      "purpose": "maskable"
    },
    {
      "src": "./assets/image/favicon/web-app-manifest-512x512.png",
      "sizes": "512x512",
      "type": "image/png",
      "purpose": "maskable"
    }
  ],
  "theme_color": "#51733f",
  "background_color": "#51733f",
  "display": "standalone"
}
```

### 注意
- 既存のコードは変更しないこと
- Viteのビルドでfaviconファイルが正しくdistに含まれるか、vite.config.jsの `publicDir` やアセット設定も確認してください
- 画像ファイル自体は後から配置するので、パスの設定とディレクトリ作成だけ行う