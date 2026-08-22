<?php
// JADWAL PELAJARAN SECTION COMPONENT (SENIN, SELASA, RABU, JUMAT)
?>
<section id="jadwal" class="section">
  <div class="container">
    <div class="section-header reveal">
      <span class="badge-tag"><i class="fa-solid fa-clock"></i> Timetable</span>
      <h2 class="section-title">Jadwal Pelajaran <span>XI PPLG</span></h2>
      <p class="section-subtitle">Jadwal pembelajaran harian kelas XI PPLG (Senin, Selasa, Rabu, dan Jumat).</p>
    </div>

    <!-- Controls / Day Filter Tabs -->
    <div class="schedule-controls reveal">
      <button class="tab-btn active" data-day="semua">Semua Hari</button>
      <button class="tab-btn" data-day="senin">Senin</button>
      <button class="tab-btn" data-day="selasa">Selasa</button>
      <button class="tab-btn" data-day="rabu">Rabu</button>
      <button class="tab-btn" data-day="jumat">Jumat</button>
    </div>

    <!-- Timetable Cards Grid -->
    <div class="schedule-grid reveal">
      
      <!-- ================= SENIN ================= -->
      <div class="schedule-card" data-day="senin">
        <div>
          <div class="schedule-time">
            <span class="time-badge"><i class="fa-regular fa-clock"></i> Jam Utama</span>
            <span class="room-badge" style="background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE;">Kode Guru: 48E</span>
          </div>
          <h4 class="schedule-subject">Pemrograman Perangkat Bergerak <span style="color: #2563EB; font-size: 0.85rem;">(K-RPL4)</span></h4>
          <p class="schedule-teacher"><i class="fa-solid fa-user-tie" style="color: #2563EB;"></i> I Putu Agus Julio Pratama, S.Kom</p>
        </div>
        <div class="schedule-footer">
          <span class="status-tag active">Senin</span>
          <span>Lab PPLG</span>
        </div>
      </div>

      <!-- ================= SELASA ================= -->
      <div class="schedule-card" data-day="selasa">
        <div>
          <div class="schedule-time">
            <span class="time-badge"><i class="fa-regular fa-clock"></i> Jam Utama</span>
            <span class="room-badge" style="background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE;">Kode Guru: 48B</span>
          </div>
          <h4 class="schedule-subject">Projek Peluang <span style="color: #2563EB; font-size: 0.85rem;">(48B)</span></h4>
          <p class="schedule-teacher"><i class="fa-solid fa-user-tie" style="color: #2563EB;"></i> I Putu Agus Julio Pratama, S.Kom</p>
        </div>
        <div class="schedule-footer">
          <span class="status-tag active">Selasa</span>
          <span>Lab PPLG</span>
        </div>
      </div>

      <!-- ================= RABU ================= -->
      <!-- Pelajaran 1 Rabu -->
      <div class="schedule-card" data-day="rabu">
        <div>
          <div class="schedule-time">
            <span class="time-badge"><i class="fa-regular fa-clock"></i> Sesi 1</span>
            <span class="room-badge" style="background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE;">Kode Guru: 47A</span>
          </div>
          <h4 class="schedule-subject">Pemrograman Berbasis Teks, Grafis, & Multimedia <span style="color: #2563EB; font-size: 0.85rem;">(K-RPL2)</span></h4>
          <p class="schedule-teacher"><i class="fa-solid fa-user-tie" style="color: #2563EB;"></i> Yuda Mahendra Putra, S.Kom</p>
        </div>
        <div class="schedule-footer">
          <span class="status-tag active">Rabu</span>
          <span>Lab PPLG</span>
        </div>
      </div>

      <!-- Pelajaran 2 Rabu -->
      <div class="schedule-card" data-day="rabu">
        <div>
          <div class="schedule-time">
            <span class="time-badge"><i class="fa-regular fa-clock"></i> Sesi 2</span>
            <span class="room-badge" style="background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE;">Kode Guru: 48I</span>
          </div>
          <h4 class="schedule-subject">Desain Grafis Lanjutan <span style="color: #2563EB; font-size: 0.85rem;">(P-RPL1)</span></h4>
          <p class="schedule-teacher"><i class="fa-solid fa-user-tie" style="color: #2563EB;"></i> I Putu Agus Julio Pratama, S.Kom</p>
        </div>
        <div class="schedule-footer">
          <span class="status-tag active">Rabu</span>
          <span>Lab PPLG</span>
        </div>
      </div>

      <!-- ================= JUMAT ================= -->
      <!-- Pelajaran 1 Jumat -->
      <div class="schedule-card" data-day="jumat">
        <div>
          <div class="schedule-time">
            <span class="time-badge"><i class="fa-regular fa-clock"></i> Sesi 2</span>
            <span class="room-badge" style="background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE;">Kode Guru: 47C</span>
          </div>
          <h4 class="schedule-subject">Basis Data <span style="color: #2563EB; font-size: 0.85rem;">(K-RPL1)</span></h4>
          <p class="schedule-teacher"><i class="fa-solid fa-user-tie" style="color: #2563EB;"></i> Yuda Mahendra Putra, S.Kom</p>
        </div>
        <div class="schedule-footer">
          <span class="status-tag active">Jumat</span>
          <span>Lab PPLG</span>
        </div>
      </div>

      <!-- Pelajaran 2 Jumat -->
      <div class="schedule-card" data-day="jumat">
        <div>
          <div class="schedule-time">
            <span class="time-badge"><i class="fa-regular fa-clock"></i> Sesi 1</span>
            <span class="room-badge" style="background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE;">Kode Guru: 47B</span>
          </div>
          <h4 class="schedule-subject">Pemrograman Web <span style="color: #2563EB; font-size: 0.85rem;">(K-RPL3)</span></h4>
          <p class="schedule-teacher"><i class="fa-solid fa-user-tie" style="color: #2563EB;"></i> Yuda Mahendra Putra, S.Kom</p>
        </div>
        <div class="schedule-footer">
          <span class="status-tag active">Jumat</span>
          <span>Lab PPLG</span>
        </div>
      </div>

    </div>
  </div>
</section>
