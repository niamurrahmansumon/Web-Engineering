// Menu open/close logic
document.querySelector('.menu').addEventListener('click', function() {
  document.getElementById('menuOverlay').classList.add('active');
});
document.getElementById('closeMenu').addEventListener('click', function() {
  document.getElementById('menuOverlay').classList.remove('active');
});

// Optional: close on ESC key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    document.getElementById('menuOverlay').classList.remove('active');
  }
});