<?php
// HERO / BERANDA SECTION COMPONENT
?>
<section id="beranda" class="hero">
  <div class="container hero-grid">
    <div class="hero-content reveal">
      <div class="hero-badge">
        <img src="assets/images/logo.png" alt="Logo SMK Bali Dewata" style="width: 22px; height: 22px; object-fit: contain;">
        <span>SMK Bali Dewata • Generasi Developer Masa Depan</span>
      </div>
      
      <h1 class="hero-title">
        Selamat Datang di <br>
        <span class="blue-text">Kelas XI PPLG</span>
      </h1>
      
      <p class="hero-description">
        Wadah belajar, berkreasi, dan berinovasi di bidang Pengembangan Perangkat Lunak & GIM. Kami siap menciptakan solusi digital terbaik melalui baris kode dan semangat kerja sama.
      </p>

      <div class="hero-actions">
        <a href="#jadwal" class="btn btn-primary">
          <i class="fa-solid fa-calendar-days"></i> Lihat Jadwal Pelajaran
        </a>
        <a href="#galeri" class="btn btn-outline">
          <i class="fa-solid fa-images"></i> Galeri Kelas
        </a>
      </div>

      <!-- Tech Stack Chips (Termasuk C dan C++) -->
      <div class="hero-tech-stack">
        <span class="tech-tag"><i class="fa-solid fa-c" style="color: #A8B9CC;"></i> C</span>
        <span class="tech-tag"><i class="fa-solid fa-code" style="color: #00599C;"></i> C++</span>
        <span class="tech-tag"><i class="fa-brands fa-html5" style="color: #E34F26;"></i> HTML5</span>
        <span class="tech-tag"><i class="fa-brands fa-css3-alt" style="color: #1572B6;"></i> CSS3</span>
        <span class="tech-tag"><i class="fa-brands fa-js" style="color: #F7DF1E;"></i> JavaScript</span>
        <span class="tech-tag"><i class="fa-brands fa-php" style="color: #777BB4;"></i> PHP</span>
        <span class="tech-tag"><i class="fa-brands fa-python" style="color: #3776AB;"></i> Python</span>
        <span class="tech-tag"><i class="fa-solid fa-database" style="color: #00758F;"></i> MySQL</span>
        <span class="tech-tag"><i class="fa-brands fa-git-alt" style="color: #F05032;"></i> Git</span>
      </div>
    </div>

    <!-- Code Card Visual (Full Display, Zero Overlapping Badges) -->
    <div class="hero-visual reveal">
      <div class="hero-card-main" style="width: 100%; position: relative;">
        <div class="code-header" style="display: flex; align-items: center; justify-content: space-between;">
          <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="dots">
              <span class="dot red"></span>
              <span class="dot yellow"></span>
              <span class="dot green"></span>
            </div>
            <span class="code-title">ClassPPLG.php • XI PPLG App</span>
          </div>
          
          <!-- Badge Siswa Aktif Dipindahkan ke Header Card agar Kode Kelihatan Full -->
          <div style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.3rem 0.8rem; background: rgba(37, 99, 235, 0.1); border: 1px solid var(--border-accent); border-radius: var(--radius-full); font-size: 0.8rem; font-weight: 600; color: var(--primary-blue);">
            <i class="fa-solid fa-users"></i> 9 Siswa Aktif
          </div>
        </div>

        <!-- Full Unobstructed Code Snippet -->
        <div class="code-snippet" style="padding: 1.4rem; font-size: 0.95rem; line-height: 1.7; background: #F8FAFC; border-radius: var(--radius-md); font-family: 'Consolas', 'Fira Code', monospace; overflow-x: auto;">
          <span class="keyword">&lt;?php</span><br>
          <span class="keyword">class</span> <span class="function">KelasXIPPLG</span> {<br>
          &nbsp;&nbsp;<span class="keyword">public</span> <span class="string">$jurusan</span> = <span class="string">'Pengembangan Perangkat Lunak'</span>;<br>
          &nbsp;&nbsp;<span class="keyword">public</span> <span class="string">$status</span> = <span class="string">'Siap Berprestasi & Inovatif'</span>;<br>
          &nbsp;&nbsp;<span class="keyword">public</span> <span class="string">$anggota</span> = <span class="string">'9 Siswa XI PPLG'</span>;<br><br>
          &nbsp;&nbsp;<span class="keyword">public</span> <span class="keyword">function</span> <span class="function">mulaiBelajar</span>() {<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<span class="keyword">echo</span> <span class="string">"Hello World! Welcome to XI PPLG"</span>;<br>
          &nbsp;&nbsp;}<br>
          }<br><br>
          <span class="string">$app</span> = <span class="keyword">new</span> <span class="function">KelasXIPPLG</span>();<br>
          <span class="string">$app</span>-&gt;<span class="function">mulaiBelajar</span>();<br>
          <span class="keyword">?&gt;</span>
        </div>
      </div>
    </div>
  </div>
</section>
