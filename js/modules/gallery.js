/* ==========================================================================
   GALLERY & LIGHTBOX MODAL MODULE
   ========================================================================== */

function initGallery() {
  const filterBtns = document.querySelectorAll('.gallery-filters .filter-btn');
  const galleryItems = document.querySelectorAll('.gallery-item');
  const lightbox = document.getElementById('lightboxModal');
  const modalClose = document.querySelector('.modal-close');
  const modalImg = document.getElementById('modalImg');
  const modalTitle = document.getElementById('modalTitle');
  const modalCategory = document.getElementById('modalCategory');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-filter');

      galleryItems.forEach(item => {
        const category = item.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

  galleryItems.forEach(item => {
    item.addEventListener('click', () => {
      const img = item.querySelector('img');
      const title = item.querySelector('.gallery-overlay h5')?.textContent || 'Galeri XI PPLG';
      const category = item.querySelector('.gallery-overlay p')?.textContent || 'Dokumentasi Kebersamaan';

      if (img && modalImg) modalImg.src = img.src;
      if (modalTitle) modalTitle.textContent = title;
      if (modalCategory) modalCategory.textContent = category;

      if (lightbox) lightbox.style.display = 'flex';
    });
  });

  if (modalClose && lightbox) {
    modalClose.addEventListener('click', () => lightbox.style.display = 'none');
    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) lightbox.style.display = 'none';
    });
  }
}
