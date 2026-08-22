/* ==========================================================================
   PRELOADER & SPLASH SCREEN JS MODULE
   ========================================================================== */

function initPreloader() {
  const preloader = document.getElementById('preloader');
  const bar = document.getElementById('preloaderBar');
  const percentText = document.getElementById('preloaderPercent');
  const statusText = document.getElementById('preloaderText');

  if (!preloader) return;

  const statusMessages = [
    "Inisialisasi Sistem XI PPLG...",
    "Memuat Identitas Resmi SMK Bali Dewata...",
    "Mempersiapkan Foto & Profil 9 Siswa...",
    "Menyambungkan Basis Data MySQL...",
    "Menyiapkan Antarmuka Interaktif...",
    "Selamat Datang di XI PPLG!"
  ];

  let progress = 0;
  const duration = 3200; // 3.2 Detik Animasi Loading Mulus & Elegan
  const intervalTime = 20;
  const step = 100 / (duration / intervalTime);

  const timer = setInterval(() => {
    progress += step;

    if (progress >= 100) {
      progress = 100;
      clearInterval(timer);

      if (bar) bar.style.width = '100%';
      if (percentText) percentText.textContent = '100%';
      if (statusText) statusText.textContent = statusMessages[5];

      setTimeout(() => {
        preloader.classList.add('fade-out');
        document.body.style.overflow = '';
      }, 500);
    } else {
      if (bar) bar.style.width = `${Math.floor(progress)}%`;
      if (percentText) percentText.textContent = `${Math.floor(progress)}%`;

      if (progress < 20) {
        if (statusText) statusText.textContent = statusMessages[0];
      } else if (progress < 40) {
        if (statusText) statusText.textContent = statusMessages[1];
      } else if (progress < 65) {
        if (statusText) statusText.textContent = statusMessages[2];
      } else if (progress < 85) {
        if (statusText) statusText.textContent = statusMessages[3];
      } else {
        if (statusText) statusText.textContent = statusMessages[4];
      }
    }
  }, intervalTime);
}

// Inisialisasi Preloader langsung
document.addEventListener('DOMContentLoaded', () => {
  document.body.style.overflow = 'hidden';
  initPreloader();
});
