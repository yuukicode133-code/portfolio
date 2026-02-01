worksセクションを以下の仕様で改修してください。

【デザインコンセプト】
通常時はテキストのみ中央配置で表示。ホバー時に円形のサムネイルが出現するミニマルなデザイン。

【通常時の表示】
- 背景：ダーク（#0a0a0a）
- テキストを画面中央に配置（text-align: center）
- 各項目の構成：
  - プロジェクト名（大きく、白、太字、var(--font-size-2xl)程度）
  - 役割/担当（小さく、グレー#999、プロジェクト名の下、間隔8px程度）
- 項目間は縦に並べる（1カラム）
- 各項目間の余白：60〜80px程度
- 区切り線：なし

【ホバー時の円形サムネイル】
- サイズ：直径280〜320px程度
- 形状：円形（border-radius: 50%）
- 出現アニメーション：
  - opacity: 0 → 1（0.3s ease）
  - 画像自体がゆっくりズーム（scale: 1 → 1.15、0.6s ease）

【重要：サムネイルの出現位置】
各プロジェクトごとに異なる位置に表示（CSSで個別指定）

- Project A: 右上エリア（top: -20%, right: 5%）
- Project B: 左中央エリア（top: 20%, left: 5%）
- Project C: 右下エリア（bottom: -10%, right: 10%）
- Project D: 左上エリア（top: -30%, left: 8%）
- Project E: 右中央エリア（top: 10%, right: 3%）
- Project F: 左下エリア（bottom: 0%, left: 5%）

※位置指定には.works__item:nth-child(n)を使用

【テキストの重なり処理】
- 円形画像：z-index: 1（背面）
- テキスト：z-index: 2（前面、常にテキストが見える状態）
- テキストにはtext-shadowや背景なしで、画像の上に重なっても読める

【HTML構造】
<section class="works" id="works">
  <div class="works__inner">
    <h2 class="works__title en">Portfolio</h2>
    <ul class="works__list">
      <li class="works__item">
        <a href="#" class="works__link">
          <div class="works__text">
            <h3 class="works__item-title en">Project A</h3>
            <p class="works__item-role">Web Design, Development</p>
          </div>
          <div class="works__thumbnail">
            <img src="https://placehold.co/600x400" alt="Project A" />
          </div>
        </a>
      </li>
      <!-- 他のプロジェクトも同様の構造 -->
    </ul>
  </div>
</section>

【CSSのポイント】
.works__inner {
  max-width: var(--layout-content-width);
  margin: 0 auto;
  padding: 0 var(--spacing-size-24);
}

.works__title {
  text-align: center;
  margin-bottom: var(--spacing-size-80);
}

.works__list {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.works__item {
  position: relative;
  width: 100%;
  text-align: center;
  padding: var(--spacing-size-40) 0;
}

.works__text {
  position: relative;
  z-index: 2;
}

.works__item-title {
  font-size: var(--font-size-2xl);
  color: var(--color-white);
  font-weight: var(--font-weight-bold);
}

.works__item-role {
  font-size: var(--font-size-sm);
  color: #999;
  margin-top: 8px;
}

.works__thumbnail {
  position: absolute;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  overflow: hidden;
  opacity: 0;
  pointer-events: none;
  z-index: 1;
  transition: opacity 0.3s ease;
}

.works__item:hover .works__thumbnail {
  opacity: 1;
}

.works__thumbnail img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.works__item:hover .works__thumbnail img {
  transform: scale(1.15);
}

/* 各項目ごとのサムネイル位置 */
.works__item:nth-child(1) .works__thumbnail {
  top: -20%;
  right: 5%;
}
.works__item:nth-child(2) .works__thumbnail {
  top: 20%;
  left: 5%;
}
.works__item:nth-child(3) .works__thumbnail {
  bottom: -10%;
  right: 10%;
}
.works__item:nth-child(4) .works__thumbnail {
  top: -30%;
  left: 8%;
}
.works__item:nth-child(5) .works__thumbnail {
  top: 10%;
  right: 3%;
}
.works__item:nth-child(6) .works__thumbnail {
  bottom: 0%;
  left: 5%;
}

【レスポンシブ】
- SP時（max-width: 767px）：
  - サムネイルのホバー表示は非表示（display: none）
  - テキストサイズを少し小さく調整
  - 項目間の余白を狭める（40px程度）

【注意事項】
- 既存のCSS変数を活用
- BEM記法を維持
- 現在のworksセクションのHTMLとCSSを置き換える形で実装