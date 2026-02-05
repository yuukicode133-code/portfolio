# Contact セクションの実装

## 概要

背景に流体シェイプ（有機的な曲線のブロブ形状）を配置し、その中央にお問い合わせフォームを設置します。
フォーム送信は EmailJS を使用し、送信後は画面切り替えで完了メッセージを表示します。

※ EmailJS の Public Key, Service ID, Template ID は後から手動で設定するため、
コード内にはプレースホルダー（'YOUR_PUBLIC_KEY'等）を記述してください。

## レイアウト構成

### 全体

- 通常のセクション程度の高さ（フルスクリーンではない）
- padding: 上下 80px〜100px 程度
- セクション背景：白または薄いグレー（#f9f9f9）
- 中央に流体シェイプを配置し、その中にフォームを収める

### 流体シェイプ（ブロブ）

- フォームを包み込む程度のサイズ（フォームより一回り大きい）
- 有機的な曲線を持つ形状
- 背景色：薄いベージュ系（#f5f0e8）
- PC: 最大幅 700px 程度、高さは内容に応じて可変
- スマホ: 幅 100%、画面幅に合わせて縮小
- **スマホではアニメーションを無効化**（パフォーマンス考慮）

### フォーム

- 流体シェイプの中央に配置
- 最大幅: 450px 程度
- **必ず流体シェイプ内に収まるよう調整**
- 画面幅が狭い場合は適切に縮小

## レスポンシブ対応の重要ポイント

### フォームがはみ出さないための対策

1. フォームの最大幅を流体シェイプより小さく設定
2. padding, margin を画面幅に応じて縮小
3. 流体シェイプはフォームのコンテナとして機能させる
4. box-sizing: border-box を確実に適用

### スマホでのパフォーマンス対策

1. ブロブのモーフィングアニメーションは PC のみ（prefers-reduced-motion も考慮）
2. SVG ではなく border-radius でシンプルに実装
3. box-shadow は控えめに

## フォーム入力項目

1. **名前**（必須）

   - type="text"
   - name="user_name"
   - placeholder: "お名前"
   - required

2. **法人名**（任意）

   - type="text"
   - name="company_name"
   - placeholder: "法人名（任意）"

3. **メールアドレス**（必須）

   - type="email"
   - name="user_email"
   - placeholder: "メールアドレス"
   - required

4. **お問い合わせ内容**（必須）

   - textarea
   - name="message"
   - placeholder: "お問い合わせ内容をご記入ください"
   - rows: 5
   - required

5. **プライバシーポリシー同意**（必須）

   - type="checkbox"
   - name="privacy_agreement"
   - 「プライバシーポリシーに同意する」ラベル
   - required

6. **送信ボタン**
   - type="submit"
   - テキスト: "送信する"

## HTML 構造

```html
<section id="contact" class="contact">
  <div class="contact__inner">
    <h2 class="contact__title en">Contact</h2>

    <!-- 流体シェイプ（フォームのコンテナ） -->
    <div class="contact__blob">
      <!-- フォーム画面 -->
      <div class="contact__form-wrapper" id="contact-form-view">
        <form class="contact__form" id="contact-form">
          <div class="contact__form-group">
            <label for="contact-name" class="contact__label"> お名前 <span class="contact__required">*</span> </label>
            <input type="text" id="contact-name" name="user_name" class="contact__input" placeholder="お名前" autocomplete="name" required />
          </div>

          <div class="contact__form-group">
            <label for="contact-company" class="contact__label"> 法人名 <span class="contact__optional">（任意）</span> </label>
            <input type="text" id="contact-company" name="company_name" class="contact__input" placeholder="法人名（任意）" autocomplete="organization" />
          </div>

          <div class="contact__form-group">
            <label for="contact-email" class="contact__label"> メールアドレス <span class="contact__required">*</span> </label>
            <input type="email" id="contact-email" name="user_email" class="contact__input" placeholder="メールアドレス" autocomplete="email" required />
          </div>

          <div class="contact__form-group">
            <label for="contact-message" class="contact__label"> お問い合わせ内容 <span class="contact__required">*</span> </label>
            <textarea id="contact-message" name="message" class="contact__textarea" placeholder="お問い合わせ内容をご記入ください" rows="5" required></textarea>
          </div>

          <div class="contact__form-group contact__form-group--checkbox">
            <label class="contact__checkbox-label">
              <input type="checkbox" id="contact-privacy" name="privacy_agreement" class="contact__checkbox" required />
              <span class="contact__checkbox-custom"></span>
              <span class="contact__checkbox-text"> <a href="/privacy-policy" target="_blank" rel="noopener noreferrer" class="contact__privacy-link">プライバシーポリシー</a>に同意する </span>
            </label>
          </div>

          <button type="submit" class="contact__submit" id="contact-submit">
            <span class="contact__submit-text">送信する</span>
            <span class="contact__submit-loading">送信中...</span>
          </button>
        </form>
      </div>

      <!-- 送信完了画面 -->
      <div class="contact__complete" id="contact-complete-view" aria-hidden="true">
        <div class="contact__complete-content">
          <div class="contact__complete-icon">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="20,6 9,17 4,12"></polyline>
            </svg>
          </div>
          <h3 class="contact__complete-title">送信完了</h3>
          <p class="contact__complete-message">
            お問い合わせありがとうございます。<br />
            内容を確認の上、折り返しご連絡いたします。
          </p>
          <button type="button" class="contact__back-button" id="contact-back">フォームに戻る</button>
        </div>
      </div>
    </div>
  </div>
</section>
```

## CSS 実装（CSS/components/contact.css）

```css
.contact {
  position: relative;
  background-color: #f9f9f9;
  padding: var(--spacing-size-80) var(--spacing-size-24);

  @mixin mq-sp {
    padding: var(--spacing-size-48) var(--spacing-size-16);
  }

  &__inner {
    max-width: 800px;
    margin: 0 auto;
  }

  &__title {
    font-size: var(--font-size-3xl);
    font-weight: var(--font-weight-bold);
    color: var(--color-black);
    text-align: center;
    margin-bottom: var(--spacing-size-48);
    letter-spacing: 0.1em;
    text-transform: capitalize;

    @mixin mq-sp {
      font-size: var(--font-size-2xl);
      margin-bottom: var(--spacing-size-32);
    }
  }

  /* 流体シェイプ - フォームのコンテナとして機能 */
  &__blob {
    background-color: #f5f0e8;
    border-radius: 60% 40% 50% 50% / 50% 50% 40% 60%;
    padding: var(--spacing-size-48);
    max-width: 600px;
    margin: 0 auto;
    position: relative;

    /* PCのみアニメーション */
    @media (min-width: 768px) and (prefers-reduced-motion: no-preference) {
      animation: blob-morph 15s ease-in-out infinite;
    }

    @mixin mq-sp {
      border-radius: 30px;
      padding: var(--spacing-size-32) var(--spacing-size-24);
      max-width: 100%;
      /* スマホではアニメーション無効 */
      animation: none;
    }
  }

  /* フォームラッパー */
  &__form-wrapper {
    opacity: 1;
    visibility: visible;
    transition: opacity 0.3s ease, visibility 0.3s ease;

    &.is-hidden {
      opacity: 0;
      visibility: hidden;
      position: absolute;
      pointer-events: none;
    }
  }

  &__form {
    max-width: 450px;
    margin: 0 auto;
  }

  /* フォームグループ */
  &__form-group {
    margin-bottom: var(--spacing-size-20);

    @mixin mq-sp {
      margin-bottom: var(--spacing-size-16);
    }

    &--checkbox {
      margin-top: var(--spacing-size-24);
      margin-bottom: var(--spacing-size-24);

      @mixin mq-sp {
        margin-top: var(--spacing-size-20);
        margin-bottom: var(--spacing-size-20);
      }
    }
  }

  &__label {
    display: block;
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-black);
    margin-bottom: var(--spacing-size-8);
    font-family: var(--font-family-jp);
  }

  &__required {
    color: #c0392b;
    font-size: var(--font-size-xs);
  }

  &__optional {
    color: #777;
    font-size: var(--font-size-xs);
  }

  /* 入力フィールド */
  &__input,
  &__textarea {
    width: 100%;
    padding: var(--spacing-size-12) var(--spacing-size-16);
    font-size: var(--font-size-md);
    font-family: var(--font-family-jp);
    color: var(--color-black);
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    transition: border-color 0.2s ease;
    box-sizing: border-box;

    &::placeholder {
      color: #aaa;
    }

    &:focus {
      outline: none;
      border-color: var(--color-black);
    }

    @mixin mq-sp {
      padding: var(--spacing-size-12);
      font-size: var(--font-size-base);
    }
  }

  &__textarea {
    resize: vertical;
    min-height: 120px;

    @mixin mq-sp {
      min-height: 100px;
    }
  }

  /* チェックボックス */
  &__checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: var(--spacing-size-10);
    cursor: pointer;
    font-size: var(--font-size-sm);
    font-family: var(--font-family-jp);
    line-height: 1.5;
  }

  &__checkbox {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;

    &:checked + .contact__checkbox-custom {
      background-color: var(--color-black);
      border-color: var(--color-black);

      &::after {
        opacity: 1;
      }
    }

    &:focus + .contact__checkbox-custom {
      border-color: var(--color-black);
    }
  }

  &__checkbox-custom {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    border: 2px solid #bbb;
    border-radius: 3px;
    position: relative;
    transition: all 0.2s ease;
    margin-top: 2px;

    &::after {
      content: "";
      position: absolute;
      top: 1px;
      left: 5px;
      width: 4px;
      height: 8px;
      border: solid #fff;
      border-width: 0 2px 2px 0;
      transform: rotate(45deg);
      opacity: 0;
      transition: opacity 0.2s ease;
    }
  }

  &__checkbox-text {
    color: var(--color-black);
  }

  &__privacy-link {
    color: var(--color-black);
    text-decoration: underline;

    &:hover {
      text-decoration: none;
    }
  }

  /* 送信ボタン */
  &__submit {
    width: 100%;
    padding: var(--spacing-size-14) var(--spacing-size-24);
    font-size: var(--font-size-md);
    font-weight: var(--font-weight-bold);
    font-family: var(--font-family-jp);
    color: #fff;
    background-color: var(--color-black);
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: opacity 0.2s ease;
    position: relative;

    &:hover:not(:disabled) {
      opacity: 0.8;
    }

    &:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    &.is-loading {
      .contact__submit-text {
        visibility: hidden;
      }
      .contact__submit-loading {
        opacity: 1;
      }
    }
  }

  &__submit-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity 0.2s ease;
  }

  /* 送信完了画面 */
  &__complete {
    opacity: 0;
    visibility: hidden;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.3s ease, visibility 0.3s ease;

    &.is-visible {
      opacity: 1;
      visibility: visible;
      position: relative;
    }
  }

  &__complete-content {
    text-align: center;
    padding: var(--spacing-size-24);
  }

  &__complete-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto var(--spacing-size-20);
    background-color: #27ae60;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;

    @mixin mq-sp {
      width: 56px;
      height: 56px;
    }
  }

  &__complete-title {
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-bold);
    color: var(--color-black);
    margin-bottom: var(--spacing-size-12);
    font-family: var(--font-family-jp);
  }

  &__complete-message {
    font-size: var(--font-size-sm);
    color: var(--color-black);
    line-height: 1.8;
    margin-bottom: var(--spacing-size-24);
    font-family: var(--font-family-jp);
  }

  &__back-button {
    padding: var(--spacing-size-10) var(--spacing-size-20);
    font-size: var(--font-size-sm);
    font-family: var(--font-family-jp);
    color: var(--color-black);
    background: transparent;
    border: 1px solid var(--color-black);
    border-radius: 50px;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;

    &:hover {
      background-color: var(--color-black);
      color: #fff;
    }
  }
}

/* ブロブのモーフィングアニメーション - PCのみ */
@keyframes blob-morph {
  0%,
  100% {
    border-radius: 60% 40% 50% 50% / 50% 50% 40% 60%;
  }
  33% {
    border-radius: 50% 60% 40% 60% / 60% 40% 60% 40%;
  }
  66% {
    border-radius: 40% 50% 60% 40% / 40% 60% 50% 60%;
  }
}
```

## JavaScript 実装（js/contact.js 新規作成）

```javascript
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contact-form");
  const formView = document.getElementById("contact-form-view");
  const completeView = document.getElementById("contact-complete-view");
  const submitButton = document.getElementById("contact-submit");
  const backButton = document.getElementById("contact-back");
  const privacyCheckbox = document.getElementById("contact-privacy");

  if (!form) return;

  // EmailJS初期化
  // ※ 後から手動で設定してください
  if (typeof emailjs !== "undefined") {
    emailjs.init("YOUR_PUBLIC_KEY");
  }

  // フォーム送信処理
  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    // バリデーション
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    // 送信中状態
    submitButton.disabled = true;
    submitButton.classList.add("is-loading");

    // フォームデータ取得
    const formData = {
      user_name: form.user_name.value,
      company_name: form.company_name.value || "（未入力）",
      user_email: form.user_email.value,
      message: form.message.value,
    };

    try {
      // EmailJS送信
      // ※ Service ID と Template ID は後から手動で設定してください
      if (typeof emailjs !== "undefined") {
        await emailjs.send("YOUR_SERVICE_ID", "YOUR_TEMPLATE_ID", formData);
      }

      // 成功：画面切り替え
      showCompleteView();
      form.reset();
    } catch (error) {
      console.error("送信エラー:", error);
      alert("送信に失敗しました。しばらく経ってから再度お試しください。");
    } finally {
      submitButton.disabled = false;
      submitButton.classList.remove("is-loading");
    }
  });

  // 完了画面を表示
  function showCompleteView() {
    formView.classList.add("is-hidden");
    formView.setAttribute("aria-hidden", "true");

    setTimeout(function () {
      completeView.classList.add("is-visible");
      completeView.setAttribute("aria-hidden", "false");
    }, 150);
  }

  // フォーム画面に戻る
  function showFormView() {
    completeView.classList.remove("is-visible");
    completeView.setAttribute("aria-hidden", "true");

    setTimeout(function () {
      formView.classList.remove("is-hidden");
      formView.setAttribute("aria-hidden", "false");
    }, 150);
  }

  // 戻るボタン
  if (backButton) {
    backButton.addEventListener("click", showFormView);
  }

  // チェックボックスのカスタムバリデーションメッセージ
  if (privacyCheckbox) {
    privacyCheckbox.addEventListener("invalid", function () {
      this.setCustomValidity("プライバシーポリシーへの同意が必要です");
    });
    privacyCheckbox.addEventListener("change", function () {
      this.setCustomValidity("");
    });
  }
});
```

## ファイル構成

### 新規作成

- CSS/components/contact.css
- js/contact.js

### 編集

- CSS/main.css → @import './components/contact.css'; を追加
- index.html → contact セクションの HTML を置き換え、script 読み込み追加

## index.html への追加

### head 内（EmailJS SDK）

```html
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
```

### body 終了前

```html
<script src="./js/contact.js" defer></script>
```

## EmailJS 設定箇所（後から手動で設定）

js/contact.js 内の以下 3 箇所を実際の値に置き換え：

1. `emailjs.init('YOUR_PUBLIC_KEY');` → Public Key を設定
2. `'YOUR_SERVICE_ID'` → Service ID を設定
3. `'YOUR_TEMPLATE_ID'` → Template ID を設定

## 注意事項

- EmailJS の各 ID はプレースホルダーのまま実装し、後から手動で設定
- 流体シェイプはスマホでは角丸の四角形に変更（パフォーマンス対策）
- モーフィングアニメーションは PC + prefers-reduced-motion: no-preference の場合のみ
- フォームは必ず流体シェイプ内に収まるよう max-width, padding を調整済み
- box-sizing: border-box を適用し、はみ出しを防止
