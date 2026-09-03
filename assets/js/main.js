(function () {
  // Footer year
  var yearEl = document.getElementById('footer-year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  // Hero slider
  var slider = document.getElementById('hero-slider');
  if (slider) {
    var slides = Array.prototype.slice.call(slider.querySelectorAll('.hero-slide'));
    var dotsWrap = document.getElementById('hero-dots');
    var current = 0;
    var timer;

    slides.forEach(function (_, i) {
      var dot = document.createElement('button');
      dot.className = 'hero-dot' + (i === 0 ? ' active' : '');
      dot.setAttribute('aria-label', 'Imagen ' + (i + 1));
      dot.addEventListener('click', function () { goTo(i); resetTimer(); });
      dotsWrap.appendChild(dot);
    });
    var dots = Array.prototype.slice.call(dotsWrap.querySelectorAll('.hero-dot'));

    function goTo(index) {
      slides[current].classList.remove('active');
      dots[current].classList.remove('active');
      current = index;
      slides[current].classList.add('active');
      dots[current].classList.add('active');
    }
    function next() { goTo((current + 1) % slides.length); }
    function resetTimer() {
      clearInterval(timer);
      timer = setInterval(next, 5500);
    }
    resetTimer();
  }

  // Header scroll state
  var header = document.getElementById('site-header');
  window.addEventListener('scroll', function () {
    header.classList.toggle('scrolled', window.scrollY > 40);
  });

  // Mobile menu
  var hamburger = document.getElementById('hamburger');
  var nav = document.getElementById('site-nav');
  var lockedScrollY = 0;
  function setMenu( open ) {
    nav.classList.toggle('open', open);
    hamburger.classList.toggle('active', open);
    hamburger.setAttribute('aria-expanded', open);
    if ( open ) {
      lockedScrollY = window.scrollY;
      document.body.classList.add('menu-open');
      document.body.style.top = ( -lockedScrollY ) + 'px';
    } else {
      document.body.classList.remove('menu-open');
      document.body.style.top = '';
      window.scrollTo( 0, lockedScrollY );
    }
  }
  hamburger.addEventListener('click', function () {
    setMenu( !nav.classList.contains('open') );
  });
  nav.querySelectorAll('a').forEach(function (a) {
    a.addEventListener('click', function () { setMenu( false ); });
  });
  document.addEventListener('keydown', function (e) {
    if ( e.key === 'Escape' ) setMenu( false );
  });

  // Fade-up reveal on scroll
  var revealEls = document.querySelectorAll('.fade-up');
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });
  revealEls.forEach(function (el) { io.observe(el); });

  // Gallery lightbox (only runs on pages that have a gallery + lightbox markup)
  var lightbox = document.getElementById('lightbox');
  if (lightbox) {
  var galItems = Array.prototype.slice.call(document.querySelectorAll('.gal-item'));
  var lbContent = document.getElementById('lightbox-content');
  var lbClose = document.getElementById('lightbox-close');
  var lbPrev = document.getElementById('lightbox-prev');
  var lbNext = document.getElementById('lightbox-next');
  var currentIndex = 0;

  function renderLightbox(index) {
    currentIndex = (index + galItems.length) % galItems.length;
    var item = galItems[currentIndex];
    var type = item.getAttribute('data-type');
    var src = item.getAttribute('data-src');
    lbContent.innerHTML = '';
    if (type === 'video') {
      var video = document.createElement('video');
      video.src = src;
      video.controls = true;
      video.autoplay = true;
      video.poster = item.getAttribute('data-poster') || '';
      lbContent.appendChild(video);
    } else {
      var img = document.createElement('img');
      img.src = src;
      img.alt = '';
      lbContent.appendChild(img);
    }
  }

  galItems.forEach(function (item, index) {
    item.addEventListener('click', function () {
      lightbox.classList.add('open');
      renderLightbox(index);
    });
  });

  function closeLightbox() {
    lightbox.classList.remove('open');
    lbContent.innerHTML = '';
  }

  lbClose.addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', function (e) {
    if (e.target === lightbox) closeLightbox();
  });
  lbPrev.addEventListener('click', function () { renderLightbox(currentIndex - 1); });
  lbNext.addEventListener('click', function () { renderLightbox(currentIndex + 1); });
  document.addEventListener('keydown', function (e) {
    if (!lightbox.classList.contains('open')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') renderLightbox(currentIndex - 1);
    if (e.key === 'ArrowRight') renderLightbox(currentIndex + 1);
  });
  } // end lightbox guard
})();
