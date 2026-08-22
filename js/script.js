/* ==========================================================================
   WEBSITE XI PPLG - MASTER SCRIPT (PHP VERSION)
   Coordinates initialization of all JS modules on DOMContentLoaded
   ========================================================================== */

function initAllModules() {
  if (typeof initNavbar === 'function') initNavbar();
  if (typeof initTypewriter === 'function') initTypewriter();
  if (typeof initScheduleTabs === 'function') initScheduleTabs();
  if (typeof initGallery === 'function') initGallery();
  if (typeof initStudentFilters === 'function') initStudentFilters();
  if (typeof initCountersAndSkills === 'function') initCountersAndSkills();
  if (typeof initContactForm === 'function') initContactForm();
  if (typeof initScrollReveal === 'function') initScrollReveal();
  if (typeof initScrollTop === 'function') initScrollTop();
}

document.addEventListener('DOMContentLoaded', () => {
  initAllModules();
});
