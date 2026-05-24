// ============================================================
// Hamburger Menu
// SP時のグローバルナビゲーション開閉
// ハンバーガーボタン自体の見た目(3本線↔×)はCSSで制御
// ============================================================

(function () {
    "use strict";
  
    const button = document.querySelector(".p-header__hamburger");
    const nav = document.querySelector("#global-nav");
    const body = document.body;
  
    if (!button || !nav) return;
  
    // 開閉状態のトグル
    const toggleMenu = () => {
      const isOpen = button.getAttribute("aria-expanded") === "true";
  
      if (isOpen) {
        closeMenu();
      } else {
        openMenu();
      }
    };
  
    const openMenu = () => {
      button.setAttribute("aria-expanded", "true");
      button.setAttribute("aria-label", "メニューを閉じる");
      nav.classList.add("is-open");
      body.style.overflow = "hidden";  // 背後のスクロールを止める
    };
  
    const closeMenu = () => {
      button.setAttribute("aria-expanded", "false");
      button.setAttribute("aria-label", "メニューを開く");
      nav.classList.remove("is-open");
      body.style.overflow = "";
    };
  
    // ボタンクリックでトグル
    button.addEventListener("click", toggleMenu);
  
    // ナビ内リンククリックで自動で閉じる
    nav.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", closeMenu);
    });
  
    // ESCキーで閉じる
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && button.getAttribute("aria-expanded") === "true") {
        closeMenu();
      }
    });
  
    // PCサイズに切り替わったら強制クローズ
    const mediaQuery = window.matchMedia("(min-width: 768px)");
    mediaQuery.addEventListener("change", (e) => {
      if (e.matches && button.getAttribute("aria-expanded") === "true") {
        closeMenu();
      }
    });
  })();