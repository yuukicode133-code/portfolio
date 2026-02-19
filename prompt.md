既存のドロワーアニメーション（drawer.js / drawer.css）を改修し、「インクが溢れ広がる液体的なアニメーション」に作り替えてください。
現状の問題
現在のdrawer.jsでは、SVGパスの2つの固定状態（PATH_CLOSED → PATH_FULL）をGSAPで補間するモーフィング方式を採用していますが、ベジェ曲線が4つしかないため四角形が膨らむような動きにしかならず、液体が溢れる有機的な形状になっていません。
改修方針：SVGパス + 三角関数 + GSAPのonUpdate
固定パス間の補間ではなく、三角関数でSVGパスを毎フレーム動的に生成し、GSAPのonUpdateコールバックで更新する方式に変更してください。
原理（Canvas波アニメーションの応用）：

Canvas上でMath.sin()を使い波形座標を計算して切り抜きを行う手法がありますが、これと同じ原理をSVGの<path>要素に適用する
progress（0→1）で展開度合いを制御し、waveOffsetの変化で輪郭のうねりを波打たせる
毎フレームpathのd属性を計算してsetAttribute('d', ...)で更新する

具体的な実装イメージ：
javascriptconst state = { progress: 0, waveOffset: 0 };

tl.to(state, {
  progress: 1,
  waveOffset: 6,
  duration: 1.2,
  ease: 'power3.inOut',
  onUpdate: () => {
    const d = generateInkPath(state.progress, state.waveOffset);
    blobPath.setAttribute('d', d);
  }
});
```

**generateInkPath関数の要件：**
- 起点は画面右上（ハンバーガーボタンの位置付近）
- `progress=0`のとき：右上に小さな点（ほぼ見えない状態）
- `progress=1`のとき：画面全体を完全に覆う大きさ
- 中間状態では、不規則なblob形状で広がる途中の液体のように見える
- 輪郭線の各ポイントのY座標に `Math.sin()` を使い、waveOffsetの変化に応じてうねりが波打つ
- 液体が重力で下に垂れるような印象を出すため、下方向への広がりを上方向より少し大きくする
- SVGの`viewBox="0 0 100 100"`に対応した座標系で計算し、パーセントベースにする
- パスのポイント数は**12〜16点程度**に抑える（パフォーマンスのため。これが重要）

### パフォーマンス対策（重要）

このサイトはSPでの閲覧が主であり、低〜中スペックのスマホでもカクつかないことが必須条件です。以下を必ず守ってください：

1. **SVGパスのポイント数を12〜16点以内に抑える**（多すぎると毎フレームの再計算・再描画が重くなる）
2. **SVG要素に`will-change: transform`を指定**してGPUレイヤーを促す
3. **SP（767px以下）ではフォールバックを用意する**：`window.matchMedia('(max-width: 767px)')`で判定し、SPでは三角関数による動的パス生成ではなく**`clip-path: circle()`のシンプルな円形拡大アニメーション**に切り替える。具体的にはSPの場合、SVGを非表示にしてドロワーオーバーレイ自体に`clip-path: circle(0% at calc(100% - 40px) 40px)`→`circle(150% at calc(100% - 40px) 40px)`のGSAPアニメーションを適用する
4. onUpdate内の計算は**極力軽く**する（DOM参照を最小限、文字列結合を効率的に）

### タイムライン構成（既存と同じ構造を維持）
```
[開くとき]
1. ドロワーを visibility: visible に
2. インクが右上から液体的に広がり画面を覆う（duration: 1.2s, ease: power3.inOut）
3. ナビリンクをstaggerでフェードイン（opacity: 0→1, y: 30→0, stagger: 0.08）

[閉じるとき]
- timeline.reverse() で完全な逆再生
既存コードとの関係

drawer.cssのレイアウト・スタイリングは基本そのまま維持
drawer.jsのイベントリスナー構成（開く・閉じる・ナビリンクで閉じる）はそのまま維持
変更するのはアニメーション生成部分（PATH定義とtlの中身）のみ
index.html内のSVG構造は必要に応じて調整してよい

テスト指標

PC（Chrome DevToolsのPerformanceタブ）で60fps近くを維持できること
SP表示（Chrome DevToolsのデバイスエミュレーション、throttling: 4x slowdown）でも滑らかに動くこと
閉じるボタンで逆再生が正常に動作すること