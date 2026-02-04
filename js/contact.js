document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('contact-form');
  const formView = document.getElementById('contact-form-view');
  const completeView = document.getElementById('contact-complete-view');
  const submitButton = document.getElementById('contact-submit');
  const backButton = document.getElementById('contact-back');
  const privacyCheckbox = document.getElementById('contact-privacy');

  if (!form) return;

  // EmailJS初期化
  // ※ 後から手動で設定してください
  if (typeof emailjs !== 'undefined') {
    emailjs.init('YOUR_PUBLIC_KEY');
  }

  // フォーム送信処理
  form.addEventListener('submit', async function(e) {
    e.preventDefault();

    // バリデーション
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    // 送信中状態
    submitButton.disabled = true;
    submitButton.classList.add('is-loading');

    // フォームデータ取得
    const formData = {
      user_name: form.user_name.value,
      company_name: form.company_name.value || '（未入力）',
      user_email: form.user_email.value,
      message: form.message.value
    };

    try {
      // EmailJS送信
      // ※ Service ID と Template ID は後から手動で設定してください
      if (typeof emailjs !== 'undefined') {
        await emailjs.send(
          'YOUR_SERVICE_ID',
          'YOUR_TEMPLATE_ID',
          formData
        );
      }

      // 成功：画面切り替え
      showCompleteView();
      form.reset();

    } catch (error) {
      console.error('送信エラー:', error);
      alert('送信に失敗しました。しばらく経ってから再度お試しください。');
    } finally {
      submitButton.disabled = false;
      submitButton.classList.remove('is-loading');
    }
  });

  // 完了画面を表示
  function showCompleteView() {
    formView.classList.add('is-hidden');
    formView.setAttribute('aria-hidden', 'true');

    setTimeout(function() {
      completeView.classList.add('is-visible');
      completeView.setAttribute('aria-hidden', 'false');
    }, 150);
  }

  // フォーム画面に戻る
  function showFormView() {
    completeView.classList.remove('is-visible');
    completeView.setAttribute('aria-hidden', 'true');

    setTimeout(function() {
      formView.classList.remove('is-hidden');
      formView.setAttribute('aria-hidden', 'false');
    }, 150);
  }

  // 戻るボタン
  if (backButton) {
    backButton.addEventListener('click', showFormView);
  }

  // チェックボックスのカスタムバリデーションメッセージ
  if (privacyCheckbox) {
    privacyCheckbox.addEventListener('invalid', function() {
      this.setCustomValidity('プライバシーポリシーへの同意が必要です');
    });
    privacyCheckbox.addEventListener('change', function() {
      this.setCustomValidity('');
    });
  }
});
