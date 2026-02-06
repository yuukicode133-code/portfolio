document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('contact-form');

  if (!form) return;

  // 宛先メールアドレス（※ご自身のメールアドレスに変更してください）
  const toEmail = 'your-email@example.com';

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    // バリデーション
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    // フォームの値を取得
    const userName = form.user_name.value;
    const userEmail = form.user_email.value;
    const message = form.message.value;

    // メールの件名と本文を作成
    const subject = 'ポートフォリオからのお問い合わせ';
    const body = `お名前: ${userName}
メールアドレス: ${userEmail}

お問い合わせ内容:
${message}`;

    // mailtoリンクを生成（日本語対応のためencodeURIComponentを使用）
    const mailtoLink = `mailto:${toEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;

    // メールアプリを起動
    window.location.href = mailtoLink;
  });
});
