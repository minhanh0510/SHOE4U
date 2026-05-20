// Shoe4U — Main JS

// Back to top
window.addEventListener('scroll', () => {
  document.getElementById('back-to-top')?.classList.toggle('show', window.scrollY > 400);
});
document.getElementById('back-to-top')?.addEventListener('click', () =>
  window.scrollTo({ top: 0, behavior: 'smooth' })
);

// Auto-hide flash messages
document.addEventListener('DOMContentLoaded', () => {
  const flash = document.getElementById('flash-msg');
  if (flash) {
    setTimeout(() => {
      flash.style.transition = 'opacity .4s';
      flash.style.opacity = '0';
      setTimeout(() => flash.remove(), 400);
    }, 3500);
  }
});
