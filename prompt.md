# Aboutセクションの実装

## 概要
2つの円形要素を重ねて配置するAboutセクションを作成してください。
右下の白いテキスト円形にはスクロールで拡大するアニメーションを適用します。

## レイアウト詳細

### 全体構成
- セクション背景：薄いベージュ系（#f5f5f0 程度）
- 2つの円形が重なるレイアウト
- 左上に人物画像の円形、右下にテキストの白い円形

### 1. 人物画像の円形（左上配置）
- 位置：セクション内でやや左上
- サイズ：直径 400-500px程度（レスポンシブで調整）
- 円形にクリップされた画像
- z-index：テキスト円形より上（手前に表示）
- pictureタグでwebp/jpgの出し分け
  - WebP: assets/images/about.webp
  - フォールバック: assets/images/about.jpg
- object-fit: cover で画像をトリミング

### 2. テキストの白い円形（右下配置）
- 位置：人物画像と一部重なるように右下に配置
- サイズ：直径 500-600px程度
- 背景色：白（#ffffff）
- z-index：人物画像より下
- 内部にAbout見出しとテキストを配置
- **この円形にスクロール拡大アニメーションを適用**

### 重なり具合
- 人物画像の右下部分とテキスト円形の左上部分が重なる
- 重なり幅は円形直径の20-30%程度

## スクロールアニメーション仕様

### 実装方法
- IntersectionObserverを使用
- jQueryは使用しない（Vanilla JS）

### アニメーション詳細
- 対象：テキストの白い円形（.about-text-circle）
- 初期状態：transform: scale(0.6); opacity: 0;
- 表示時：transform: scale(1); opacity: 1;
- transition: transform 0.8s ease-out, opacity 0.6s ease-out;

### IntersectionObserver設定
```javascript
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target); // 一度だけ実行
    }
  });
}, {
  threshold: 0.2,
  rootMargin: '0px 0px -50px 0px'
});
```

## HTML構造
```html
<section id="about" class="about-section">
  <div class="about-container">
    <!-- 人物画像の円形 -->
    <div class="about-image-circle">
      <picture>
        <source srcset="assets/images/about.webp" type="image/webp">
        <img src="assets/images/about.jpg" alt="プロフィール画像">
      </picture>
    </div>
    
    <!-- テキストの白い円形（スクロールで拡大） -->
    <div class="about-text-circle">
      <div class="about-text-content">
        <h2 class="about-title">About</h2>
        <p class="about-description">
          ここに自己紹介テキストが入ります。
          フリーランスのWeb制作者として活動しています。
        </p>
      </div>
    </div>
  </div>
</section>
```

## CSS要件

### 円形の実装
```css
.about-image-circle,
.about-text-circle {
  border-radius: 50%;
  overflow: hidden;
}
```

### 配置（position使用）
```css
.about-container {
  position: relative;
  min-height: 80vh;
}

.about-image-circle {
  position: absolute;
  top: 10%;
  left: 10%;
  width: clamp(300px, 35vw, 500px);
  height: clamp(300px, 35vw, 500px);
  z-index: 2;
}

.about-text-circle {
  position: absolute;
  top: 30%;
  left: 25%;
  width: clamp(350px, 40vw, 600px);
  height: clamp(350px, 40vw, 600px);
  background: #fff;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}
```

### スクロールアニメーション用CSS
```css
.about-text-circle {
  transform: scale(0.6);
  opacity: 0;
  transition: transform 0.8s ease-out, opacity 0.6s ease-out;
}

.about-text-circle.is-visible {
  transform: scale(1);
  opacity: 1;
}
```

### レスポンシブ対応
- タブレット（1023px以下）：円形サイズを縮小
- スマホ（767px以下）：縦並びレイアウトに変更、または円形サイズをさらに縮小

## JavaScript実装

既存のJSファイル（scroll-animation.js等）に追加するか、
about-animation.js として新規作成してください。
```javascript
document.addEventListener('DOMContentLoaded', function() {
  const aboutCircle = document.querySelector('.about-text-circle');
  
  if (aboutCircle) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.2,
      rootMargin: '0px 0px -50px 0px'
    });
    
    observer.observe(aboutCircle);
  }
});
```

## ファイル構成
- HTML: index.html の適切な位置にセクションを追加
- CSS: CSS/components/about.css を新規作成し、main.cssでインポート
- JS: js/about-animation.js を新規作成するか、既存のアニメーション用JSに追加
- 画像: assets/images/about.jpg, assets/images/about.webp を使用（画像ファイル自体は既存のものを使用）

## 注意点
- pictureタグでのwebp出し分けを必ず実装すること
- 円形の重なり順序（z-index）に注意
- スクロールアニメーションは一度だけ実行（unobserveで監視解除）
- 既存のプロジェクトのコーディング規約・ファイル構成に合わせること