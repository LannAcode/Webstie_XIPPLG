# 🚀 Website Resmi XI PPLG - SMK Bali Dewata

![XI PPLG Banner](assets/images/logo.png)

> **Platform Web Resmi Kelas XI PPLG (Pengembangan Perangkat Lunak dan Gim) SMK Bali Dewata, Denpasar, Bali.**  
> Wadah dokumentasi kegiatan, galeri pameran karya **TIKFEST**, jadwal pelajaran, profil siswa & guru, serta portal kontak terverifikasi OTP EmailJS dan Dashboard Admin.

---

## 🌟 Fitur Utama Website

### 👨‍💻 1. Profil 9 Siswa XI PPLG (Full Socials)
- Menampilkan 9 profil siswa aktif lengkap dengan foto avatar 1:1, peran, quote, serta tautan **Instagram** dan **GitHub** resmi:
  1. **I Ketut Lanang Artha Nugraha** ([@iniilangg2](https://www.instagram.com/iniilangg2) • [@LannAcode](https://github.com/LannAcode))
  2. **I Komang Arta Wiguna** ([@artaaa.exe](https://www.instagram.com/artaaa.exe) • [@Arta-cmd-rgb](https://github.com/Arta-cmd-rgb))
  3. **Kadek Wirasatya Wiguna** ([@wiraasaatyaa](https://www.instagram.com/wiraasaatyaa) • [@wiraasatyaa](https://github.com/wiraasatyaa))
  4. **I Gusti Agung Tira Aditya** ([@adityaa1610v](https://www.instagram.com/adityaa1610v) • [@agungtira027-lab](https://github.com/agungtira027-lab))
  5. **Filia Kynatha Tertia Hadikusuma** ([@fyuuwu03](https://www.instagram.com/fyuuwu03/) • [@Feelia03](https://github.com/Feelia03))
  6. **Tedy Noviansah** ([@sidee_biw](https://www.instagram.com/sidee_biw) • [@rengokuapi166-eng](https://github.com/rengokuapi166-eng?tab=stars))
  7. **Dewa Ngakan Putu Rafael Satyamali** ([@rafboysss_16](https://www.instagram.com/rafboysss_16) • [@Rafa541334](https://github.com/Rafa541334))
  8. **Putu Adicahya Mahendra** ([@putuadicahyamahendra](https://www.instagram.com/putuadicahyamahendra/) • [@putuadicahyamahendra-design](https://github.com/putuadicahyamahendra-design))
  9. **I Putu Darma Putra** ([@putraaaxxc](https://www.instagram.com/putraaaxxc) • [@dukunhost11](https://github.com/dukunhost11))

### 👨‍🏫 2. Profil Guru Pengajar & Kaprodi
- **Pak Julio** (Kode Guru: `48B` • Kaprodi PPLG & Guru Produktif)
- **Pak Yuda Mahendra, S.Kom** (Kaprodi PPLG & Guru Produktif)

### 🏆 3. Seksi Event & Pameran TIKFEST
- Kartu kegiatan pameran karya utama **TIKFEST** memamerkan aplikasi web dinamis, software, dan proyek game interaktif buatan siswa XI PPLG.
- Dokumentasi praktikum pemrograman bahasa C (Type Conversion & Tabel Rapot).

### 📅 4. Jadwal Pelajaran Interaktif
- Penjadwalan 4 hari aktif (Senin, Selasa - Projek Peluang Kode `48B`, Rabu, Jumat) dilengkapi filter tab hari.

### 📸 5. Galeri Foto & Fullscreen Lightbox Modal
- Galeri foto kebersamaan dan praktikum lab komputer dengan filter kategori (**Semua Foto**, **TIKFEST**, **Foto Kebersamaan**, **Praktikum Lab**) dan modal Lightbox pratinjau layar penuh.

### 🔑 6. Sistem Kontak & Verifikasi Kode OTP EmailJS
- **OTP Anti-Iseng**: Pengirim pesan wajib memasukkan 6-digit kode OTP yang dikirimkan rahasia ke Gmail pengirim via EmailJS (`service_kwbsvxg`, `template_bu1bryq`).
- Pengiriman form otomatis disimpan ke database MySQL setelah verifikasi OTP lulus.

### 🛡️ 7. Dashboard Admin & Balas Email
- **Login Admin**: Proteksi password reveal tunggal, CSRF token, dan session security.
- **Pengelolaan Pesan**: Pencarian, filter status (Belum Dibaca / Sudah Dibaca), dan hapus pesan.
- **Balas Email Resmi**: Admin dapat membalas email pengunjung langsung dari dashboard admin via EmailJS ke inbox Gmail pengirim.

### 🗄️ 8. Arsitektur Database Dual-Sync
- Koneksi utama 100% ke **MySQL XAMPP** (`127.0.0.1:3306`, database `db_xi_pplg`).
- Cadangan otomatis **SQLite** (`database/db_xi_pplg.sqlite`) jika MySQL sedang tidak aktif.

### 📱 9. 100% Full Responsive Design
- Tampilan dioptimalkan untuk Smartphone (360px–576px), Tablet (768px), Laptop, dan Desktop.

---

## 🛠️ Teknologi yang Digunakan

- **Language**: PHP 8.x, JavaScript (ES6+), HTML5, CSS3
- **Database**: MySQL / MariaDB (Primary) + SQLite3 (Fallback)
- **API & Email**: EmailJS Browser SDK (`@emailjs/browser`)
- **Icon & Typography**: FontAwesome 6, Google Fonts (*Outfit* & *Poppins*)
- **Security**: `.env` Configuration, `.gitignore` Protection, CSRF, Anti-XSS Headers

---

## 💻 Panduan Instalasi Lokal

### 1. Clone Repository & Setup Environment
```bash
git clone https://github.com/username/websitePPlG.git
cd websitePPlG
```

### 2. Konfigurasi File `.env`
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Isikan kredensial EmailJS dan database pada file `.env`:
```env
EMAILJS_SERVICE_ID=your_service_id_here
EMAILJS_TEMPLATE_ID=your_template_id_here
EMAILJS_REPLY_TEMPLATE_ID=your_reply_template_id_here
EMAILJS_PUBLIC_KEY=your_public_key_here

DB_HOST=127.0.0.1
DB_NAME=db_xi_pplg
DB_USER=root
DB_PASS=
```

### 3. Persiapan Database MySQL (XAMPP)
1. Buka **XAMPP Control Panel**, jalankan **Apache** dan **MySQL** (`Start`).
2. Buka phpMyAdmin di browser: `http://localhost/phpmyadmin`
3. Buat database baru bernama `db_xi_pplg`.
4. Eksekusi tabel `pesan_kontak`:
```sql
CREATE TABLE IF NOT EXISTS pesan_kontak (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  subjek VARCHAR(255) NOT NULL,
  pesan TEXT NOT NULL,
  status ENUM('belum_dibaca', 'sudah_dibaca') DEFAULT 'belum_dibaca',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### 4. Jalankan Website
Gunakan server bawaan PHP:
```bash
php -S localhost:8080
```
Buka di browser:
- 🌐 **Website Utama**: `http://localhost:8080`
- 📊 **Dashboard Admin**: `http://localhost:8080/admin/login.php` (Default: `admin` / `admin123`)

---

## 📜 Lisensi & Pengembang

Dikembangkan dengan bangga oleh **Siswa XI PPLG SMK Bali Dewata**  
*Denpasar, Bali - Indonesia*  
© 2026 XI PPLG SMK Bali Dewata. All Rights Reserved.
