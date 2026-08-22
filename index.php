<?php
/* ==========================================================================
   WEBSITE RESMI KELAS XI PPLG - SMK BALI DEWATA
   Master Entry Point File (PHP Version)
   ========================================================================== */
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Website Resmi Kelas XI PPLG SMK Bali Dewata (Pengembangan Perangkat Lunak & GIM) - Wadah Kreativitas, Kode, dan Inovasi Siswa PPLG.">
  <title>XI PPLG - SMK Bali Dewata (Pengembangan Perangkat Lunak & GIM)</title>
  <link rel="icon" type="image/png" href="assets/images/logo.png">

  <!-- Google Fonts: Outfit & Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 CDN for Tech Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Modular Stylesheets -->
  <link rel="stylesheet" href="css/variables.css">
  <link rel="stylesheet" href="css/preloader.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- 0. INITIAL ANIMATED PRELOADER SPLASH SCREEN -->
  <?php include 'components/preloader.php'; ?>

  <!-- 1. NAVBAR COMPONENT -->
  <?php include 'components/navbar.php'; ?>

  <main>
    <!-- 2. BERANDA SECTION -->
    <?php include 'components/hero.php'; ?>

    <!-- 3. TENTANG SECTION -->
    <?php include 'components/tentang.php'; ?>

    <!-- 4. SISWA SECTION -->
    <?php include 'components/siswa.php'; ?>

    <!-- 5. JADWAL SECTION -->
    <?php include 'components/jadwal.php'; ?>

    <!-- 6. GALERI SECTION -->
    <?php include 'components/galeri.php'; ?>

    <!-- 7. STATISTIK SECTION -->
    <?php include 'components/statistik.php'; ?>

    <!-- 8. KEGIATAN SECTION -->
    <?php include 'components/kegiatan.php'; ?>

    <!-- 9. GURU SECTION -->
    <?php include 'components/guru.php'; ?>

    <!-- 10. KONTAK SECTION -->
    <?php include 'components/kontak.php'; ?>
  </main>

  <!-- 11. FOOTER COMPONENT -->
  <?php include 'components/footer.php'; ?>

  <!-- JavaScript Modular Script Files -->
  <script src="js/modules/preloader.js"></script>
  <script src="js/modules/navbar.js"></script>
  <script src="js/modules/typewriter.js"></script>
  <script src="js/modules/schedule.js"></script>
  <script src="js/modules/gallery.js"></script>
  <script src="js/modules/students.js"></script>
  <script src="js/modules/stats.js"></script>
  <script src="js/modules/contact.js"></script>
  <script src="js/modules/animations.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
