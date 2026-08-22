/* ==========================================================================
   STATISTIK COUNTER & SKILL PROGRESS BARS MODULE
   ========================================================================== */

function initCountersAndSkills() {
  const statsSection = document.getElementById('statistik');
  if (!statsSection) return;

  let animated = false;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !animated) {
        animated = true;
        
        const counters = document.querySelectorAll('.stat-number');
        counters.forEach(counter => {
          const target = +counter.getAttribute('data-target');
          const duration = 1800;
          const step = Math.ceil(target / (duration / 16));
          let current = 0;

          const updateCounter = () => {
            current += step;
            if (current < target) {
              counter.textContent = current + (counter.getAttribute('data-suffix') || '');
              requestAnimationFrame(updateCounter);
            } else {
              counter.textContent = target + (counter.getAttribute('data-suffix') || '');
            }
          };

          updateCounter();
        });

        const skillFills = document.querySelectorAll('.skill-fill');
        skillFills.forEach(fill => {
          const percentage = fill.getAttribute('data-percent');
          fill.style.width = percentage + '%';
        });
      }
    });
  }, { threshold: 0.3 });

  observer.observe(statsSection);
}
