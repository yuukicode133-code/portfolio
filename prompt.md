# ローディング画面の実装

## 概要
ポートフォリオサイトの全画面ローディング画面。
テキストが左から右へ手書き風に出現し、その下にプログレスバーを配置するシンプルな構成。

## 技術構成
- HTML + CSS + jQuery
- 外部ライブラリ不要（jQuery以外）
- Canvas不使用

## 動作タイムライン（合計約2秒）

| 時間 | 動作 |
|------|------|
| 0s | 画面表示 |
| 0.2s | アニメーション開始 |
| 0.2s〜1.7s | テキストリビール（左→右）+ プログレスバー 0%→100% |
| 1.7s | "Complete"表示、カーソル線消失 |
| 2.0s | 画面全体フェードアウト開始（0.4秒） |
| 2.4s | loading-screen要素をDOMから除去、コールバック発火 |

## デザイン仕様

### カラー
- 背景: `#f4f1e8`（和紙風）
- テキスト・インク: `#0a2615`
- 薄い要素（ステータス、%表示等）: `rgba(10, 38, 21, 0.25〜0.35)`

### フォント
- テキストリビール: `Playfair Display` italic 400（Google Fonts）
- ステータス・プログレス: `Inter` 500（Google Fonts）

### レイアウト
- 画面中央にテキスト + ステータス + プログレスバーの縦積み
- テキスト幅: `min(90vw, 700px)`
- プログレスバー幅: 最大320px
- 背景に紙のノイズテクスチャ（SVG feTurbulence、pointer-events: none）

### テキストリビールの仕組み
SVGの`<clipPath>`内の`<rect>`のwidthをプログレスに連動させ、左から右へテキストを出現させる。

テキストは3層構成:
1. **Shadow層** — 薄い色 + blur(4px) でインク滲み表現
2. **Fill層** — テキスト本体
3. **Stroke層** — 細い輪郭線（opacity: 0.3）

リビール先端にカーソル線（細い縦線）を表示し、進行中であることを示す。

### ステータステキスト
- プログレスの区間ごとに切り替え（4段階）
- 文言例: Mixing pigments → Binding resin → Setting paper → Curing ink → Complete
- 0.7rem、uppercase、letter-spacing: 0.18em

### プログレスバー
- トラック: 高さ1.5px、薄い背景色
- フィル: 左から右へ伸びる
- 下にパーセンテージ表示（0.6rem）

## 実装上の注意

### 配置
- `<div id="loading-screen">` を `<body>` 直下の最初の要素として配置
- `position: fixed; inset: 0; z-index: 9999;`
- 完了後は `.remove()` でDOMから除去

### フォント読み込み
`document.fonts.ready` でPlayfair Displayの読み込み完了を待ってからアニメーション開始する。フォント未読み込み状態でSVGテキストの幅がずれるのを防ぐため。

### イージング
プログレスのイージングは `easeInOutQuad` を使用。jQueryの `.animate()` ではなく `requestAnimationFrame` で手動制御する（clipPathのSVG属性はjQueryのanimateでは直接操作できないため）。

jQuery は DOM要素の取得・フェードアウト処理・DOM除去に使用する。

### 完了後のコールバック
ローディング完了後に呼ばれるコールバック関数を用意し、メインコンテンツの表示開始を親側に委ねる。