/* ==========================================================================
   SCHEDULE / JADWAL PELAJARAN MODULE
   ========================================================================== */

function initScheduleTabs() {
  const tabBtns = document.querySelectorAll('.schedule-controls .tab-btn');
  const scheduleCards = document.querySelectorAll('.schedule-card');

  if (!tabBtns.length) return;

  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      tabBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const selectedDay = btn.getAttribute('data-day');

      scheduleCards.forEach(card => {
        const cardDay = card.getAttribute('data-day');
        if (selectedDay === 'semua' || cardDay === selectedDay) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
}
