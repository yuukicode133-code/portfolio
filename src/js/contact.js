import emailjs from '@emailjs/browser';
import $ from "jquery";


$(document).ready(function () {
  // EmailJS設定
  const SERVICE_ID = "service_85tnkpt";
  const TEMPLATE_ID = "template_t57bll3";

  // DOM要素
  const $inputScreen = $("#input-screen");
  const $confirmScreen = $("#confirm-screen");
  const $completeScreen = $("#complete-screen");
  const $form = $("#contact-form");
  const $backButton = $("#back-button");
  const $submitButton = $("#submit-button");
  const $resetButton = $("#reset-button");

  // フォームデータを保持
  let formData = {
    title: "サンプルサイトのお問い合わせ",
    "contact-name": "",
    "contact-email": "",
    "contact-message": "",
  };
  emailjs.init('FOq-J0DnYMyoz09TK');

  // バリデーション関数
  function validateForm() {
    let isValid = true;
    const name = $("#contact-name").val().trim();
    const email = $("#contact-email").val().trim();
    const message = $("#contact-message").val().trim();
    const privacy = $("#contact-privacy").is(":checked");
    const recaptchaResponse = grecaptcha.getResponse();

    // エラーメッセージをクリア
    $(".error-message").text("");
    $(".contact__input, .contact__textarea").removeClass("error");

    // お名前のバリデーション
    if (name === "") {
      $("#contact-name-error").text("お名前を入力してください");
      $("#contact-name").addClass("error");
      isValid = false;
    }

    // メールアドレスのバリデーション
    if (email === "") {
      $("#contact-email-error").text("メールアドレスを入力してください");
      $("#contact-email").addClass("error");
      isValid = false;
    } else if (!isValidEmail(email)) {
      $("#contact-email-error").text("正しいメールアドレスを入力してください");
      $("#contact-email").addClass("error");
      isValid = false;
    }

    // お問い合わせ内容のバリデーション
    if (message === "") {
      $("#contact-message-error").text("お問い合わせ内容を入力してください");
      $("#contact-message").addClass("error");
      isValid = false;
    }

    // プライバシーポリシーのバリデーション
    if (!privacy) {
      alert("プライバシーポリシーに同意してください");
      isValid = false;
    }

    // reCAPTCHAのバリデーション
    if (!recaptchaResponse) {
      alert("reCAPTCHAを確認してください");
      isValid = false;
    }

    return isValid;
  }

  // メールアドレスの形式チェック
  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  // 画面切り替え関数
  function showScreen(screenName) {
    $inputScreen.addClass("contact__form-wrapper--hidden");
    $confirmScreen.addClass("contact__form-wrapper--hidden");
    $completeScreen.addClass("contact__form-wrapper--hidden");

    switch (screenName) {
      case "input":
        $inputScreen.removeClass("contact__form-wrapper--hidden");
        break;
      case "confirm":
        $confirmScreen.removeClass("contact__form-wrapper--hidden");
        break;
      case "complete":
        $completeScreen.removeClass("contact__form-wrapper--hidden");
        break;
    }
  }

  // 確認画面に表示する内容を設定
  function setConfirmContent() {
    $("#confirm-name").text(formData['contact-name']);
    $("#confirm-email").text(formData['contact-email']);
    $("#confirm-message").text(formData['contact-message']);
  }

  // フォーム送信（確認画面へ）
  $form.on("submit", function (e) {
    e.preventDefault();

    if (!validateForm()) {
      return;
    }

    // フォームデータを保存
    formData['contact-name'] = $("#contact-name").val().trim();
    formData['contact-email'] = $("#contact-email").val().trim();
    formData['contact-message'] = $("#contact-message").val().trim();

    // 確認画面に内容を設定して表示
    setConfirmContent();
    showScreen("confirm");
  });

  // 戻るボタン
  $backButton.on("click", function () {
    showScreen("input");
  });

  // 送信ボタン
  $submitButton.on("click", function () {
    // ボタンを無効化（二重送信防止）
    $submitButton.prop("disabled", true).text("送信中...");

    formData['g-recaptcha-response'] = grecaptcha.getResponse();

    // EmailJSで送信
    emailjs.send(SERVICE_ID, TEMPLATE_ID, formData).then(
      function (response) {
        console.log("SUCCESS!", response.status, response.text);
        // 送信完了画面へ
        showScreen("complete");
        $submitButton.prop("disabled", false).text("送信する");
      },
      function (error) {
        console.error("FAILED...", error);
        alert("送信に失敗しました。もう一度お試しください。");
        $submitButton.prop("disabled", false).text("送信する");
      },
    );
  });

  // 新しいお問い合わせボタン
  $resetButton.on("click", function () {
    // フォームをリセット
    $form[0].reset();
    formData = {
      'contact-name': "",
      'contact-email': "",
      'contact-message': "",
      title: "サンプルサイトのお問い合わせ",
    };
    // reCAPTCHAをリセット
    grecaptcha.reset();
    // 入力画面へ
    showScreen("input");
  });
});
