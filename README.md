# green - Web Portfolio

架空のフリーランスWeb制作者のポートフォリオサイトです。
下記のサイトを参考にしながら"緑のインク"をテーマに学習も兼ねて33日で公開に至りました。

## URL

https://yuukicode133-code.github.io/portfolio/

## インスピレーション

デザインは [olhauzhykova](https://olhauzhykova.com/) にインスピレーションを受けています。

## 使用技術

- HTML（セマンティックHTML、WAI-ARIA対応）
- CSS（PostCSS / CSS変数による設計トークン管理）
- jQuery
- GSAP（ドロワーアニメーション)
- Vite
- ホスティング: GitHub Pages
- CI/CD: GitHub Actions（自動ビルド＆デプロイ）
- フォント: Playfair Display / Shippori Mincho B1 / Inter（Google Fonts）
- セキュリティ: reCAPTCHA v2（コンタクトフォーム）

## このプロジェクトを通じて初めて挑戦したこと

- GSAP の導入からタイムラインによる複雑なアニメーション制御
- CSS 変数 の活用
- Vite のセットアップ
- CSS アニメーション
- Sourcetree / GitHub を使ったバージョン管理
- アニメーション各種（ドロワーの開閉、モーダル、スクロール連動の円形拡大、メールアプリへの反映フォーム）

## 主な実装で苦労した点と解決方法

### Vite + GSAP環境の構築

従来のCDNベースの開発からnpm + importベースの開発環境への移行に苦労しました。
「バンドラーとは何か」「なぜViteが必要なのか」という理解から始め、`vite.config.js`の設定、GSAPのimport管理、GitHub Pagesへの自動デプロイまでを一つずつ構築しました。
公式ドキュメントとAIツールを併用しながら、各技術の「役割分担」を整理することで全体像を把握できました。

### デザイン面

デザインの知識がないため、サイト全体の見た目については参考サイトやギャラリーサイトをみながらテーマにあったものになるようアイデアを出しました。
例えばドロワーのアニメーションは「緑のインクが溢れる」ことを表現したいというアイデアから、AIとの対話でGSAPによるSVGパスモーフィングという実装方法にたどり着きました。
完成したコードを読むと、12個の制御点を三角関数（`sin`）で配置し、`wave`（うねり）と`gravity`（重力バイアス）で有機的な輪郭を生成する仕組みになっていて、数学的なアプローチでインクの流体感を表現していることが理解できました。

### ローディング画面の同期制御

テキスト、プログレスバー、パーセント数値の3つの要素を完全に同じタイミングで動かしたかったのですが、CSS transitionで個別に設定すると要素間で微妙なタイミングのズレが発生する可能性がありました。
AIとの対話で、「1つの`progress`値から全要素の状態を導出する」という設計方針に至りました。
実装されたコードでは、`requestAnimationFrame` で毎フレーム1つの進行度を計算し、そこから clip-path・width・テキストを一括更新しています。`easeInOutQuad`関数で「出だしゆっくり → 中盤加速 → 終盤減速」の自然なカーブを実現し、`document.fonts.ready` でフォント読み込みを待つことでレイアウト崩れも防いでいます。
コードを読み解く中で、`rawProgress`（線形）と`progress`（イージング後）を分ける理由や、`performance.now()` が `Date.now()` より高精度な理由を学びました。

### カスタムカーソルのパフォーマンス

カスタムカーソルをスムーズに動かすにあたり、AIとの対話で `left/top` ではなく `transform: translate()` を使ってGPUアクセラレーションを活用する方法を教わりました。
また、タッチデバイスではカーソルの概念がないため、`ontouchstart` の有無で判定して無効化する分岐処理が入っています。
遅延追従（現在位置とマウス位置の差分に `speed` 係数を掛ける補間）で、カーソルが滑らかに追いかける動きを実現しています。

### ドロワーメニューのSP/PC分岐

ドロワーのアニメーションについて、当初PC（デスクトップ)ではナビゲーションメニューを実装していましたが、SP（スマートフォン）での実装はパフォーマンスに懸念が出てきたので
SP（スマートフォン）とPC（デスクトップ）で異なるアプローチを取る設計になりました。
PCでは三角関数によるSVGパスモーフィング（インクが溢れるような表現）、SPでは `clip-path: circle()` によるシンプルな円形展開にしています。`window.matchMedia('(max-width: 767px)')` で読み込み時に1度だけ判定する設計です。
コードを読んで、「高度な処理を低スペック端末で避ける」というパフォーマンス配慮の考え方を理解しました。

### アクセシビリティ対応

WAI-ARIAの実装はAIの支援を受けて進めましたが、その過程でスキップリンク、`aria-expanded` によるドロワーの状態通知、フォーカストラップ（ドロワー内でTabキーをループさせる）、`role="progressbar"` によるローディング進捗の通知など、スクリーンリーダーやキーボード操作のユーザーにとっての意味を学びました。

## パフォーマンス最適化

- `<picture>` + `<source>` による WebP / JPG フォーマット切り替え
- 画像の WebP 化（約 40% サイズ削減）
- `loading="lazy"` による画像の遅延読み込み
- GSAP アニメーションでの `will-change` 適切な使用

## 機能

- ローディングアニメーション（プログレスバー付き）
- SVGパスによる液体blob展開のドロワーメニュー（PC）/ clip-path円形展開（SP）
- Worksセクションのスクロール連動フェードインアニメーション
- Aboutセクションの円形拡大アニメーション（スクロール連動）
- Worksモーダル（`<dialog>`要素、4スライド構成のスライダー、スワイプ対応）
- カスタムカーソル（PC、タッチデバイスでは自動無効化）
- お問い合わせフォーム（3ステップ: 入力→確認→完了、バリデーション付き、mailto）
- タッチデバイスでのhover効果無効化（`@media (hover: hover)`）
- LINEアプリ内ブラウザ検知バナー

## アクセシビリティ

- スキップリンク
- WAI-ARIA属性（`aria-label`、`aria-expanded`、`aria-modal`、`aria-hidden`等）
- キーボード操作対応（Escキーでモーダル/ドロワー閉じる、フォーカストラップ）
- `prefers-reduced-motion`対応（contactブロブアニメーション）
- ローディング画面の `role="progressbar"` + `aria-live="polite"` による進捗通知

## SEO

- JSON-LD構造化データ（`@graph` で WebSite / WebPage / Person / CollectionPage / ProfilePage / ContactPage / BreadcrumbList を記述）
- OGP / Twitterカード設定
- canonical URL
- Webマニフェスト（PWA対応）

## プロジェクト構成

```
portfolio/
├── assets/
│   ├── image/              # 画像リソース（JPG / WebP / favicon / OGP）
│   └── video/              # FVセクションの背景動画
├── src/
│   ├── styles/
│   │   └── main.css        # スタイルシート（PostCSS）
│   └── js/
│       └── main.js         # エントリーポイント（ES Modules）
├── index.html              # エントリーポイント
├── package.json            # 依存パッケージ管理
├── vite.config.js          # Vite 設定
├── postcss.config.cjs      # PostCSS 設定
├── site.webmanifest        # PWA マニフェスト
└── .gitignore
```

## 開発環境

- エディタ: Cursor
- バージョン管理: Git (Sourcetree) / GitHub
- デプロイ: GitHub Pages
- デバッグ: Chrome DevTools
- AI 支援: Claude, Claude Code, Canvas AI, Figma Make

## このプロジェクトを通じて学んだこと

AIツールを活用してコードを生成し、完成したコードを読み解くことで以下を学びました。

- `requestAnimationFrame` による時間ベースのアニメーション制御と、イージング関数の仕組み
- SVGの `<path>` 要素と三角関数を使った動的な図形生成
- GSAPタイムライン1本で `play()` / `reverse()` による開閉アニメーションを制御する設計
- `<dialog>` 要素のネイティブ機能（背景スクロールロック、Escキー閉じ、オーバーレイ）
- WAI-ARIAによるアクセシビリティ設計の基本（フォーカストラップ、状態通知、進捗通知）
- `transform` によるGPUアクセラレーションと `left/top` との違い
- SP/PCでアニメーション手法を分けるパフォーマンス設計
- Vite + GitHub Actions による自動ビルド＆デプロイのCI/CDパイプライン

## ライセンス

このプロジェクトのコードは学習・参考目的での閲覧を歓迎します。
商用利用や再配布については事前にご連絡ください。
