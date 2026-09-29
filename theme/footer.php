<footer class="l-footer">
    <div class="l-inner p-footer">
      <div class="p-footer__top">
        <p class="p-footer__logo">
          <a href="<?php echo home_url('/'); ?>" class="p-footer__logo-link" aria-label="yuuki portfolio — ホームへ">
            <span>yuuk</span><span class="p-footer__logo-accent">i</span><span>&nbsp;portfolio</span>
          </a>
        </p>
        <ul class="p-footer__links" aria-label="連絡先・SNS">
          <li class="p-footer__links-item">
            <?php $contact_page = get_page_by_path('contact'); ?>
            <a href="<?php echo get_permalink($contact_page->ID); ?>" class="p-footer__links-link" aria-label="お問い合わせはこちら">
              <?php get_template_part('template-parts/icons/mail'); ?>
            </a>
          </li>
          <li class="p-footer__links-item">
            <a href="https://github.com/yuukicode133-code" class="p-footer__links-link" target="_blank" rel="noopener noreferrer" aria-label="GitHub(別タブで開きます)">
              <?php get_template_part('template-parts/icons/github'); ?>
            </a>
          </li>
          <li class="p-footer__links-item">
            <a href="https://x.com/yuuki__main_ac" class="p-footer__links-link" target="_blank" rel="noopener noreferrer" aria-label="X(別タブで開きます)">
              <?php get_template_part('template-parts/icons/x'); ?>
            </a>
          </li>
        </ul>
      </div>
      <p class="p-footer__copyright">&copy; 2026 yuuki portfolio. All rights reserved.</p>
    </div>
  </footer>
  <?php wp_footer(); ?>
  </body>
  </html>