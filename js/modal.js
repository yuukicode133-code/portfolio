import $ from 'jquery';
$(function () {
  // ===================
  // プロジェクトデータ
  // ===================
  var projectData = {
    a: {
      title: "Project A",
      description: "コーポレートサイトのデザインから実装まで担当しました。ユーザビリティを重視したUI設計を行いました。",
      technologies: ["HTML / CSS", "JavaScript", "WordPress"],
      image: "https://placehold.co/800x500",
      link: "https://example.com/project-a",
    },
    b: {
      title: "Project B",
      description: "ECサイトのUI/UXデザインを担当。購入導線の最適化により、CVRが30%向上しました。",
      technologies: ["Figma", "Adobe XD", "Photoshop"],
      image: "https://placehold.co/800x500",
      link: "https://example.com/project-b",
    },
    c: {
      title: "Project C",
      description: "スタートアップ企業のブランディングとWebサイト制作を担当しました。",
      technologies: ["HTML / CSS", "JavaScript", "Illustrator"],
      image: "https://placehold.co/800x500",
      link: "https://example.com/project-c",
    },
    d: {
      title: "Project D",
      description: "新サービスローンチに向けたランディングページを制作しました。",
      technologies: ["HTML / CSS", "JavaScript", "GSAP"],
      image: "https://placehold.co/800x500",
      link: "https://example.com/project-d",
    },
    e: {
      title: "Project E",
      description: "WordPressによるオリジナルテーマ開発を行いました。",
      technologies: ["WordPress", "PHP", "MySQL", "JavaScript"],
      image: "https://placehold.co/800x500",
      link: "https://example.com/project-e",
    },
    f: {
      title: "Project F",
      description: "大手企業のコーポレートサイトリニューアルを担当しました。",
      technologies: ["HTML / CSS", "JavaScript", "WordPress"],
      image: "https://placehold.co/800x500",
      link: "https://example.com/project-f",
    },
  };

  // ===================
  // 変数定義
  // ===================
  var $modal = $("#works-modal");
  var modal = $modal[0]; // ネイティブのdialog要素
  var $closeBtn = $modal.find(".works-modal__close");
  var $slides = $modal.find(".works-modal__slide");
  var $dots = $modal.find(".works-modal__dot");
  var $prevBtn = $modal.find(".works-modal__arrow--prev");
  var $nextBtn = $modal.find(".works-modal__arrow--next");

  var currentSlide = 0;
  var totalSlides = $slides.length;
  var isAnimating = false;

  // ===================
  // モーダルを開く
  // ===================
  $(".works__item").on("click", function (e) {
    e.preventDefault();

    if (isAnimating) return;

    var index = $(this).index();
    var projectKeys = ["a", "b", "c", "d", "e", "f"];
    var projectKey = projectKeys[index];

    openModal(projectKey);
  });

  function openModal(projectKey) {
    if (isAnimating) return;
    isAnimating = true;

    currentSlide = 0;

    // カスタムカーソルをモーダル内に移動
    var $cursor = $(".custom-cursor");
    if ($cursor.length) {
      $modal.append($cursor);
    }

    // プロジェクトクラスをリセット＆追加
    $modal.removeClass("is-project-a is-project-b is-project-c is-project-d is-project-e is-project-f is-closing");
    $modal.addClass("is-project-" + projectKey);

    // コンテンツを更新
    updateModalContent(projectKey);

    // スライドを初期化
    updateSlide();

    // showModal()でモーダルを開く（背景のインタラクションをブロック）
    modal.showModal();

    // 次のフレームでアニメーション開始
    requestAnimationFrame(function () {
      $modal.addClass("is-open");

      setTimeout(function () {
        isAnimating = false;
      }, 500);
    });
  }

  function updateModalContent(projectKey) {
    var data = projectData[projectKey];

    // タイトルと説明
    $modal.find(".works-modal__title").text(data.title);
    $modal.find(".works-modal__description").text(data.description);

    // 技術リスト
    var $techList = $modal.find(".works-modal__tech-list");
    $techList.empty();
    data.technologies.forEach(function (tech) {
      $techList.append("<li>" + tech + "</li>");
    });

    // 画像
    $modal.find(".works-modal__image img").attr("src", data.image);

    // リンク
    $modal.find(".works-modal__button").attr("href", data.link);
  }

  // ===================
  // モーダルを閉じる
  // ===================
  function closeModal() {
    if (isAnimating) return;
    isAnimating = true;

    // 閉じるアニメーション開始
    $modal.addClass("is-closing");
    $modal.removeClass("is-open");

    // アニメーション完了後にdialogを閉じる
    setTimeout(function () {
      var $cursor = $(".custom-cursor");
      if ($cursor.length) {
        $("body").append($cursor);
      }
      modal.close();
      $modal.removeClass("is-closing");
      isAnimating = false;
    }, 400);
  }

  $closeBtn.on("click", closeModal);

  // 背景（::backdrop）クリックで閉じる
  $modal.on("click", function (e) {
    // クリックがdialog自体（backdrop部分）の場合のみ閉じる
    if (e.target === modal) {
      closeModal();
    }
  });

  // Escapeキーでの閉じる処理をカスタマイズ（アニメーション付きで閉じる）
  $modal.on("cancel", function (e) {
    e.preventDefault();
    closeModal();
  });

  // ===================
  // スライド操作
  // ===================
  function updateSlide() {
    // スライド切り替え
    $slides.removeClass("is-active");
    $slides.eq(currentSlide).addClass("is-active");

    // ドット更新
    $dots.removeClass("is-active");
    $dots.eq(currentSlide).addClass("is-active");

    // ボタン状態更新
    $prevBtn.prop("disabled", currentSlide === 0);
    $nextBtn.prop("disabled", currentSlide === totalSlides - 1);
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

  $nextBtn.on("click", nextSlide);
  $prevBtn.on("click", prevSlide);

  // ドットクリック
  $dots.on("click", function () {
    currentSlide = $(this).data("index");
    updateSlide();
  });

  // ===================
  // キーボード操作
  // ===================
  $(document).on("keydown", function (e) {
    if (!modal.open) return;

    switch (e.key) {
      case "ArrowRight":
        nextSlide();
        break;
      case "ArrowLeft":
        prevSlide();
        break;
    }
  });

  // ===================
  // スワイプ対応（SP用）
  // ===================
  var touchStartX = 0;
  var touchEndX = 0;

  $modal.on("touchstart", function (e) {
    touchStartX = e.originalEvent.changedTouches[0].screenX;
  });

  $modal.on("touchend", function (e) {
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
