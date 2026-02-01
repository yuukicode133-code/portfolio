worksセクションのクリック時の動作をjQueryで追加実装してください。

【機能概要】
各プロジェクトをクリックすると、画面下からフェードイン＋スライドアップでモーダルが出現。
モーダル内はスライド形式で、最後のスライドにリンクボタンがある。

【モーダルの出現アニメーション】
- 画面下から上へスライドしながらフェードイン
- transform: translateY(100%) → translateY(0)
- opacity: 0 → 1
- duration: 0.5s ease-out
- 背景は各プロジェクトごとに異なるカラー

【プロジェクトごとの背景カラー】
- Project A: #51733f（深緑）
- Project B: #8B4513（ブラウン系）
- Project C: #2c3e50（ダークブルー）
- Project D: #6B4C9A（パープル系）
- Project E: #b0bf9f（ライトグリーン）
- Project F: #34495e（グレーブルー）

【モーダルの構成】
1. 閉じるボタン（右上、×アイコン）
2. スライドコンテナ
3. スライドナビゲーション（ドット＋矢印）

【スライドの内容（各プロジェクト共通構成）】
- スライド1: プロジェクトタイトル + 概要説明
- スライド2: 使用技術・担当範囲
- スライド3: スクリーンショット or イメージ
- スライド4（最終）: 「View Project」リンクボタン

【HTML構造】
※</main>の直前に追加

<div class="works-modal" id="works-modal">
  <div class="works-modal__overlay"></div>
  <div class="works-modal__content">
    <button class="works-modal__close" aria-label="閉じる">
      <span></span>
      <span></span>
    </button>
    
    <div class="works-modal__slider">
      <div class="works-modal__slides">
        <div class="works-modal__slide is-active" data-slide="1">
          <h3 class="works-modal__title en"></h3>
          <p class="works-modal__description"></p>
        </div>
        <div class="works-modal__slide" data-slide="2">
          <h4 class="works-modal__subtitle en">Technologies</h4>
          <ul class="works-modal__tech-list"></ul>
        </div>
        <div class="works-modal__slide" data-slide="3">
          <div class="works-modal__image">
            <img src="" alt="Project screenshot" />
          </div>
        </div>
        <div class="works-modal__slide" data-slide="4">
          <p class="works-modal__cta-text">プロジェクトの詳細をご覧ください</p>
          <a href="#" class="works-modal__button en" target="_blank" rel="noopener">
            View Project
          </a>
        </div>
      </div>
      
      <div class="works-modal__nav">
        <button class="works-modal__arrow works-modal__arrow--prev" aria-label="前へ">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15,18 9,12 15,6"></polyline>
          </svg>
        </button>
        <div class="works-modal__dots">
          <span class="works-modal__dot is-active" data-index="0"></span>
          <span class="works-modal__dot" data-index="1"></span>
          <span class="works-modal__dot" data-index="2"></span>
          <span class="works-modal__dot" data-index="3"></span>
        </div>
        <button class="works-modal__arrow works-modal__arrow--next" aria-label="次へ">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9,6 15,12 9,18"></polyline>
          </svg>
        </button>
      </div>
    </div>
  </div>
</div>

【CSS】
※main.cssに追加

/* ===================
   Works Modal
=================== */
.works-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1000;
  display: none;
  pointer-events: none;
}

.works-modal.is-open {
  display: block;
  pointer-events: auto;
}

.works-modal__overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.works-modal.is-open .works-modal__overlay {
  opacity: 1;
}

.works-modal__content {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 85vh;
  border-radius: 30px 30px 0 0;
  transform: translateY(100%);
  opacity: 0;
  transition: transform 0.5s ease-out, opacity 0.5s ease-out;
  display: flex;
  flex-direction: column;
  padding: var(--spacing-size-60) var(--spacing-size-40);
}

.works-modal.is-open .works-modal__content {
  transform: translateY(0);
  opacity: 1;
}

/* プロジェクトごとの背景色 */
.works-modal.is-project-a .works-modal__content {
  background-color: #51733f;
}
.works-modal.is-project-b .works-modal__content {
  background-color: #8B4513;
}
.works-modal.is-project-c .works-modal__content {
  background-color: #2c3e50;
}
.works-modal.is-project-d .works-modal__content {
  background-color: #6B4C9A;
}
.works-modal.is-project-e .works-modal__content {
  background-color: #b0bf9f;
}
.works-modal.is-project-f .works-modal__content {
  background-color: #34495e;
}

/* 閉じるボタン */
.works-modal__close {
  position: absolute;
  top: 24px;
  right: 24px;
  width: 44px;
  height: 44px;
  background: rgba(255, 255, 255, 0.1);
  border: none;
  border-radius: 50%;
  cursor: pointer;
  z-index: 10;
  transition: background-color 0.3s ease;
}

.works-modal__close:hover {
  background: rgba(255, 255, 255, 0.2);
}

.works-modal__close span {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 20px;
  height: 2px;
  background-color: var(--color-white);
}

.works-modal__close span:first-child {
  transform: translate(-50%, -50%) rotate(45deg);
}

.works-modal__close span:last-child {
  transform: translate(-50%, -50%) rotate(-45deg);
}

/* スライダー */
.works-modal__slider {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  max-width: 900px;
  margin: 0 auto;
  width: 100%;
}

.works-modal__slides {
  position: relative;
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

.works-modal__slide {
  position: absolute;
  width: 100%;
  text-align: center;
  padding: var(--spacing-size-24);
  opacity: 0;
  visibility: hidden;
  transform: translateX(30px);
  transition: opacity 0.4s ease, visibility 0.4s ease, transform 0.4s ease;
}

.works-modal__slide.is-active {
  opacity: 1;
  visibility: visible;
  transform: translateX(0);
}

/* スライドコンテンツ */
.works-modal__title {
  font-size: var(--font-size-3xl);
  color: var(--color-white);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--spacing-size-30);
}

.works-modal__description {
  font-size: var(--font-size-la);
  color: var(--color-white);
  line-height: 1.8;
  max-width: 600px;
  margin: 0 auto;
}

.works-modal__subtitle {
  font-size: var(--font-size-xl);
  color: var(--color-white);
  font-weight: var(--font-weight-medium);
  margin-bottom: var(--spacing-size-24);
}

.works-modal__tech-list {
  list-style: none;
  padding: 0;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 12px;
}

.works-modal__tech-list li {
  font-size: var(--font-size-md);
  color: var(--color-white);
  padding: 10px 20px;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 20px;
  font-family: var(--font-family-en);
}

.works-modal__image {
  max-width: 700px;
  margin: 0 auto;
}

.works-modal__image img {
  width: 100%;
  height: auto;
  border-radius: 16px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.works-modal__cta-text {
  font-size: var(--font-size-la);
  color: var(--color-white);
  margin-bottom: var(--spacing-size-40);
}

.works-modal__button {
  display: inline-block;
  padding: 18px 60px;
  background-color: var(--color-white);
  color: var(--color-black);
  font-size: var(--font-size-md);
  font-weight: var(--font-weight-medium);
  border-radius: 30px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.works-modal__button:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
}

/* ナビゲーション */
.works-modal__nav {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: var(--spacing-size-30);
  padding-top: var(--spacing-size-24);
}

.works-modal__arrow {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: 1px solid rgba(255, 255, 255, 0.3);
  background: transparent;
  color: var(--color-white);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background-color 0.3s ease, border-color 0.3s ease;
}

.works-modal__arrow:hover:not(:disabled) {
  background-color: rgba(255, 255, 255, 0.1);
  border-color: rgba(255, 255, 255, 0.5);
}

.works-modal__arrow:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

.works-modal__dots {
  display: flex;
  gap: 12px;
}

.works-modal__dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.3);
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.works-modal__dot:hover {
  background-color: rgba(255, 255, 255, 0.5);
}

.works-modal__dot.is-active {
  background-color: var(--color-white);
  transform: scale(1.2);
}

/* レスポンシブ */
@media screen and (max-width: 767px) {
  .works-modal__content {
    height: 92vh;
    padding: var(--spacing-size-40) var(--spacing-size-20);
    border-radius: 20px 20px 0 0;
  }
  
  .works-modal__close {
    top: 16px;
    right: 16px;
    width: 40px;
    height: 40px;
  }
  
  .works-modal__title {
    font-size: var(--font-size-2xl);
  }
  
  .works-modal__description {
    font-size: var(--font-size-md);
  }
  
  .works-modal__nav {
    gap: var(--spacing-size-16);
  }
  
  .works-modal__arrow {
    width: 44px;
    height: 44px;
  }
}

【JavaScript】
※js/modal.jsを新規作成

$(function() {
  // ===================
  // プロジェクトデータ
  // ===================
  var projectData = {
    a: {
      title: 'Project A',
      description: 'コーポレートサイトのデザインから実装まで担当しました。ユーザビリティを重視したUI設計を行いました。',
      technologies: ['HTML / CSS', 'JavaScript', 'WordPress'],
      image: 'https://placehold.co/800x500',
      link: 'https://example.com/project-a'
    },
    b: {
      title: 'Project B',
      description: 'ECサイトのUI/UXデザインを担当。購入導線の最適化により、CVRが30%向上しました。',
      technologies: ['Figma', 'Adobe XD', 'Photoshop'],
      image: 'https://placehold.co/800x500',
      link: 'https://example.com/project-b'
    },
    c: {
      title: 'Project C',
      description: 'スタートアップ企業のブランディングとWebサイト制作を担当しました。',
      technologies: ['HTML / CSS', 'JavaScript', 'Illustrator'],
      image: 'https://placehold.co/800x500',
      link: 'https://example.com/project-c'
    },
    d: {
      title: 'Project D',
      description: '新サービスローンチに向けたランディングページを制作しました。',
      technologies: ['HTML / CSS', 'JavaScript', 'GSAP'],
      image: 'https://placehold.co/800x500',
      link: 'https://example.com/project-d'
    },
    e: {
      title: 'Project E',
      description: 'WordPressによるオリジナルテーマ開発を行いました。',
      technologies: ['WordPress', 'PHP', 'MySQL', 'JavaScript'],
      image: 'https://placehold.co/800x500',
      link: 'https://example.com/project-e'
    },
    f: {
      title: 'Project F',
      description: '大手企業のコーポレートサイトリニューアルを担当しました。',
      technologies: ['HTML / CSS', 'JavaScript', 'WordPress'],
      image: 'https://placehold.co/800x500',
      link: 'https://example.com/project-f'
    }
  };

  // ===================
  // 変数定義
  // ===================
  var $modal = $('#works-modal');
  var $overlay = $modal.find('.works-modal__overlay');
  var $closeBtn = $modal.find('.works-modal__close');
  var $slides = $modal.find('.works-modal__slide');
  var $dots = $modal.find('.works-modal__dot');
  var $prevBtn = $modal.find('.works-modal__arrow--prev');
  var $nextBtn = $modal.find('.works-modal__arrow--next');
  
  var currentSlide = 0;
  var totalSlides = $slides.length;
  var currentProject = null;

  // ===================
  // モーダルを開く
  // ===================
  $('.works__item').on('click', function(e) {
    e.preventDefault();
    
    var index = $(this).index();
    var projectKeys = ['a', 'b', 'c', 'd', 'e', 'f'];
    var projectKey = projectKeys[index];
    
    openModal(projectKey);
  });

  function openModal(projectKey) {
    currentProject = projectKey;
    currentSlide = 0;
    
    // プロジェクトクラスをリセット＆追加
    $modal.removeClass('is-project-a is-project-b is-project-c is-project-d is-project-e is-project-f');
    $modal.addClass('is-project-' + projectKey);
    
    // コンテンツを更新
    updateModalContent(projectKey);
    
    // スライドを初期化
    updateSlide();
    
    // モーダル表示
    $modal.addClass('is-open');
    $('body').css('overflow', 'hidden');
  }

  function updateModalContent(projectKey) {
    var data = projectData[projectKey];
    
    // タイトルと説明
    $modal.find('.works-modal__title').text(data.title);
    $modal.find('.works-modal__description').text(data.description);
    
    // 技術リスト
    var $techList = $modal.find('.works-modal__tech-list');
    $techList.empty();
    $.each(data.technologies, function(i, tech) {
      $techList.append('<li>' + tech + '</li>');
    });
    
    // 画像
    $modal.find('.works-modal__image img').attr('src', data.image);
    
    // リンク
    $modal.find('.works-modal__button').attr('href', data.link);
  }

  // ===================
  // モーダルを閉じる
  // ===================
  function closeModal() {
    $modal.removeClass('is-open');
    $('body').css('overflow', '');
  }

  $closeBtn.on('click', closeModal);
  $overlay.on('click', closeModal);

  // ===================
  // スライド操作
  // ===================
  function updateSlide() {
    // スライド切り替え
    $slides.removeClass('is-active');
    $slides.eq(currentSlide).addClass('is-active');
    
    // ドット更新
    $dots.removeClass('is-active');
    $dots.eq(currentSlide).addClass('is-active');
    
    // ボタン状態更新
    $prevBtn.prop('disabled', currentSlide === 0);
    $nextBtn.prop('disabled', currentSlide === totalSlides - 1);
  }

  function nextSlide() {
    if (currentSlide < totalSlides - 1) {
      currentSlide++;
      updateSlide();
    }
  }

  function prevSlide() {
    if (currentSlide > 0) {
      currentSlide--;
      updateSlide();
    }
  }

  $nextBtn.on('click', nextSlide);
  $prevBtn.on('click', prevSlide);

  // ドットクリック
  $dots.on('click', function() {
    currentSlide = $(this).data('index');
    updateSlide();
  });

  // ===================
  // キーボード操作
  // ===================
  $(document).on('keydown', function(e) {
    if (!$modal.hasClass('is-open')) return;
    
    switch(e.key) {
      case 'Escape':
        closeModal();
        break;
      case 'ArrowRight':
        nextSlide();
        break;
      case 'ArrowLeft':
        prevSlide();
        break;
    }
  });

  // ===================
  // スワイプ対応（SP用）
  // ===================
  var touchStartX = 0;
  var touchEndX = 0;

  $modal.on('touchstart', function(e) {
    touchStartX = e.originalEvent.changedTouches[0].screenX;
  });

  $modal.on('touchend', function(e) {
    touchEndX = e.originalEvent.changedTouches[0].screenX;
    handleSwipe();
  });

  function handleSwipe() {
    var swipeThreshold = 50;
    var diff = touchStartX - touchEndX;
    
    if (diff > swipeThreshold) {
      // 左スワイプ → 次へ
      nextSlide();
    } else if (diff < -swipeThreshold) {
      // 右スワイプ → 前へ
      prevSlide();
    }
  }
});

【index.htmlの変更】
1. </main>の直前にモーダルHTMLを追加
2. scriptタグを追加：
   <script src="./js/modal.js" defer></script>

【注意事項】
- jQueryは既に読み込まれている前提（jquery-3.7.1.min.js）
- 既存のCSS変数を活用
- BEM記法を維持
- プロジェクトデータは後から実際の内容に差し替え可能