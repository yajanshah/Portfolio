
(function () {
  // Scroll reveal
  const revealItems = document.querySelectorAll('[data-reveal]');
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });
  revealItems.forEach((el) => revealObserver.observe(el));

  // Animated counters
  const counters = document.querySelectorAll('[data-count]');
  const countObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const target = parseInt(el.getAttribute('data-count'), 10);
      const suffix = el.getAttribute('data-suffix') || '';
      let start = 0;
      const duration = 1200;
      const startTime = performance.now();
      function tick(now) {
        const progress = Math.min((now - startTime) / duration, 1);
        const value = Math.floor(progress * target);
        el.textContent = value.toLocaleString() + suffix;
        if (progress < 1) requestAnimationFrame(tick);
      }
      requestAnimationFrame(tick);
      countObserver.unobserve(el);
    });
  }, { threshold: 0.4 });
  counters.forEach((el) => countObserver.observe(el));

  // Sticky side nav active section
  const sideLinks = document.querySelectorAll('.side-nav a[href^="#"]');
  if (sideLinks.length) {
    const sections = [...sideLinks].map((a) => document.querySelector(a.getAttribute('href'))).filter(Boolean);
    const sectionObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const id = entry.target.getAttribute('id');
        sideLinks.forEach((link) => link.classList.toggle('active', link.getAttribute('href') === '#' + id));
      });
    }, { threshold: 0.35, rootMargin: '0px 0px -40% 0px' });
    sections.forEach((s) => sectionObserver.observe(s));
  }

  // FAQ accordion
  document.querySelectorAll('.faq-item button').forEach((btn) => {
    btn.addEventListener('click', () => {
      const item = btn.closest('.faq-item');
      item.classList.toggle('open');
    });
  });

  // Simple carousel
  document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('.carousel-track');
    const items = carousel.querySelectorAll('.carousel-item');
    let index = 0;
    function update() {
      track.style.transform = `translateX(${index * -100}%)`;
    }
    carousel.querySelector('.carousel-next')?.addEventListener('click', () => {
      index = (index + 1) % items.length;
      update();
    });
    carousel.querySelector('.carousel-prev')?.addEventListener('click', () => {
      index = (index - 1 + items.length) % items.length;
      update();
    });
  });

  // Lightbox
  const lightbox = document.querySelector('.lightbox');
  if (lightbox) {
    const img = lightbox.querySelector('img');
    document.querySelectorAll('[data-lightbox]').forEach((tile) => {
      tile.addEventListener('click', () => {
        img.src = tile.getAttribute('data-lightbox');
        lightbox.classList.add('open');
      });
    });
    lightbox.addEventListener('click', () => lightbox.classList.remove('open'));
  }
})();

