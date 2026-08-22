/* ==========================================================================
   DAFTAR & FOTO SISWA MODULE
   ========================================================================== */

function initStudentFilters() {
  const studentFilterBtns = document.querySelectorAll('.student-filters .filter-btn');
  const studentCards = document.querySelectorAll('.student-card');

  if (!studentFilterBtns.length) return;

  studentFilterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      studentFilterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-filter');

      studentCards.forEach(card => {
        const category = card.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
}
