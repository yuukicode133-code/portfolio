import $ from 'jquery';
$(document).ready(function() {
  const $form = $('#contact-form');

  if (!$form.length) return;

  // 宛先メールアドレス（※ご自身のメールアドレスに変更してください）
  const toEmail = 'pandashirokuma@gmail.com';

  $form.on('submit', function(e) {
    e.preventDefault();

    // バリデーション
    const formElement = this;
    if (!formElement.checkValidity()) {
      formElement.reportValidity();
      return;
    }

    // フォームの値を取得
    const userName = $('[name="user_name"]').val();
    const userEmail = $('[name="user_email"]').val();
    const message = $('[name="message"]').val();

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
