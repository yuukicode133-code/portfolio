document.addEventListener('DOMContentLoaded', function () {
  const aboutCircle = document.querySelector('.about__text-circle');

  if (aboutCircle) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.2,
        rootMargin: '0px 0px -50px 0px',
      }
    );

    observer.observe(aboutCircle);
  }
});
