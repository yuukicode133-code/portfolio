<?php get_header(); ?>
<main class="l-main">
  <?php get_template_part('template-parts/breadcrumb'); ?>

  <div class="p-page-header">
    <div class="l-inner">
      <h1 class="p-page-header__title">プライバシーポリシー</h1>
    </div>
  </div>

  <section class="p-privacy">
    <div class="l-inner">
      <div class="p-privacy__wrapper">
        <p class="p-privacy__lead">
          このプライバシーポリシーは、関勇実（以下「運営者」といいます）が提供するポートフォリオ（以下「本サイト」といいます）における個人情報の取扱いについて適用されます。
        </p>
        <div class="p-privacy__item">
          <h2 class="p-privacy__title">1.取得する情報</h2>
          <p class="p-privacy__text">
            本サイトのお問い合わせフォームから、会社名、氏名、メールアドレス、電話番号、件名、お問い合わせ内容を取得します。
          </p>
        </div>
        <div class="p-privacy__item">
          <h2 class="p-privacy__title">2.利用目的</h2>
          <p class="p-privacy__text">
            取得した情報は、お問い合わせへの返信およびそれに必要なご連絡のためにのみ利用します。
          </p>
        </div>
        <div class="p-privacy__item">
          <h2 class="p-privacy__title">3.第三者への提供</h2>
          <p class="p-privacy__text">
            取得した個人情報は、ご本人の同意がある場合または法令に基づく場合を除き、第三者に提供しません。
          </p>
        </div>
        <div class="p-privacy__item">
          <h2 class="p-privacy__title">4.外部サービスの利用</h2>
          <p class="p-privacy__text">
            本サイトでは、お問い合わせフォームへの不正な送信を防ぐため、Cloudflare, Inc.が提供する「Cloudflare Turnstile」を利用しています。Turnstileは、ボットによるアクセスを判別するために、IPアドレスやブラウザの情報などを取得します。取得された情報は、Cloudflare社のプライバシーポリシーに基づいて取り扱われます。
          </p>
          <ul class="p-privacy__link">
            <li class="p-privacy__link-item">
              <a href="https://www.cloudflare.com/privacypolicy/" target="_blank" rel="noopener noreferrer">Cloudflare プライバシーポリシー</a>
            </li>
            <li class="p-privacy__link-item">
              <a href="https://www.cloudflare.com/turnstile-privacy-policy/" target="_blank" rel="noopener noreferrer">Turnstile Privacy Addendum</a>
            </li>
          </ul>
        </div>
        <div class="p-privacy__item">
          <h2 class="p-privacy__title">5.Cookieについて</h2>
          <p class="p-privacy__text">
            本サイトでは、Cookieを利用したアクセス解析や広告配信は行っていません。
          </p>
        </div>
        <div class="p-privacy__item">
          <h2 class="p-privacy__title">6.お問い合わせ・開示等のご請求</h2>
          <p class="p-privacy__text">
            個人情報の開示・訂正・削除などのご請求や、本ポリシーに関するお問い合わせは、<a class="p-privacy__link-contact" href="<?php echo home_url('/contact/'); ?>">お問い合わせフォーム</a>からご連絡ください。
          </p>
        </div>
        <div class="p-privacy__item">
          <h2 class="p-privacy__title">7.本ポリシーの改定</h2>
          <p class="p-privacy__text">
            本ポリシーの内容は、必要に応じて改定することがあります。改定後の内容は、本ページに掲載した時点から効力を生じるものとします。
          </p>
        </div>
        <div class="p-privacy__date-wrapper">
          <p class="p-privacy__date">制定日：<time datetime="<?php echo get_the_date('Y-n-d'); ?>"><?php echo get_the_date('Y年n月d日'); ?></time></p>
        </div>
      </div>
    </div>
  </section>


</main>

<?php get_footer(); ?>