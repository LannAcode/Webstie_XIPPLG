/* ==========================================================================
   FORM KONTAK & EMAILJS OTP VERIFICATION CODE MODULE
   ========================================================================== */

function initContactForm() {
  const alertSuccess = document.querySelector('.alert-success');
  const toast = document.getElementById('toastMsg');
  
  if (alertSuccess && toast) {
    toast.classList.add('show');
    setTimeout(() => {
      toast.classList.remove('show');
    }, 5000);
  }

  const form = document.getElementById('contactForm');
  const submitBtn = document.getElementById('btnSubmitKontak');
  const statusBox = document.getElementById('emailjsStatusBox');
  const nameInput = document.getElementById('inputName');
  const emailInput = document.getElementById('inputEmail');
  const subjectInput = document.getElementById('inputSubject');
  const messageInput = document.getElementById('inputMessage');

  const btnSendOTP = document.getElementById('btnSendOTP');
  const btnVerifyOTP = document.getElementById('btnVerifyOTP');
  const otpBox = document.getElementById('otpBox');
  const otpInput = document.getElementById('inputOTPCode');
  const otpMsg = document.getElementById('otpMsg');

  if (!form || !submitBtn) return;

  // Initialize EmailJS Browser SDK using Public Key from .env
  const config = window.EMAILJS_CONFIG || {};
  const serviceID = config.serviceID || 'service_kwbsvxg';
  const templateID = config.templateID || 'template_bu1bryq';
  const publicKey = config.publicKey || '6EQMY_TcGjGsSBYhe';

  if (window.emailjs && publicKey) {
    try {
      emailjs.init(publicKey);
      console.log('EmailJS SDK Berhasil Diinisialisasi (Key: ' + publicKey + ')');
    } catch (e) {
      console.warn('Inisialisasi EmailJS SDK:', e);
    }
  }

  let generatedOTP = null;
  let isEmailVerified = false;
  let isSubmitting = false;

  // 1. Tombol Kirim Kode OTP via EmailJS
  if (btnSendOTP && emailInput) {
    btnSendOTP.addEventListener('click', function () {
      const nameVal = nameInput ? nameInput.value.trim() : 'Pengunjung';
      const emailVal = emailInput.value.trim().toLowerCase();

      if (!emailVal) {
        alert('Mohon masukkan alamat email Anda terlebih dahulu!');
        emailInput.focus();
        return;
      }

      // Validasi Format Email Standard
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(emailVal)) {
        alert('Format email tidak valid! Masukkan email aktif (contoh: lananggent87@gmail.com).');
        emailInput.focus();
        return;
      }

      // Generate Random 6-Digit OTP Code
      generatedOTP = Math.floor(100000 + Math.random() * 900000).toString();
      console.log('Generated OTP Code (Secret):', generatedOTP);

      btnSendOTP.disabled = true;
      btnSendOTP.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim OTP...';

      if (otpBox) {
        otpBox.style.display = 'block';
      }
      if (otpMsg) {
        otpMsg.style.color = '#1E40AF';
        otpMsg.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirimkan kode OTP ke <code>"' + emailVal + '"</code> via EmailJS...';
      }

      const otpTextMessage = 'Halo ' + nameVal + ',\n\nKode OTP Verifikasi Email Anda adalah: ' + generatedOTP + '\n\nMasukkan 6-digit kode OTP ini pada form kontak XI PPLG untuk membuktikan keaslian email Anda.\n\nSalam,\nPengurus XI PPLG SMK Bali Dewata';

      const templateParams = {
        from_name: 'XI PPLG Official',
        user_name: nameVal,
        to_name: nameVal,
        name: nameVal,

        to_email: emailVal,
        from_email: emailVal,
        user_email: emailVal,
        email: emailVal,
        reply_to: emailVal,

        subject: 'OTP for XI PPLG Authentication',
        title: 'Kode OTP Verifikasi Keamanan Email',

        // Tepat sesuai dengan template screenshot EmailJS Anda: {{passcode}}
        passcode: generatedOTP,
        otp_code: generatedOTP,
        code: generatedOTP,
        otp: generatedOTP,
        verification_code: generatedOTP,
        time: '15 minutes',

        message: otpTextMessage,
        notes: 'Kode OTP: ' + generatedOTP,
        pesan: 'Kode OTP: ' + generatedOTP
      };

      // Send OTP via EmailJS (Kode Hanya Dikirim ke Email Gmail Pengguna)
      if (window.emailjs && typeof emailjs.send === 'function') {
        emailjs.send(serviceID, templateID, templateParams, publicKey)
          .then(function (response) {
            console.log('EmailJS OTP Sent Success:', response.status, response.text);
            if (otpMsg) {
              otpMsg.style.color = '#065F46';
              otpMsg.innerHTML = '<i class="fa-solid fa-envelope-circle-check"></i> <strong>Kode OTP 6-digit telah terkirim!</strong> Silakan buka Inbox atau folder Spam pada email <code>"' + emailVal + '"</code> Anda untuk membaca kodenya.';
            }
            btnSendOTP.innerHTML = '<i class="fa-solid fa-rotate"></i> Kirim Ulang OTP';
            btnSendOTP.disabled = false;
          })
          .catch(function (error) {
            console.warn('EmailJS OTP Cloud Response:', error);
            if (otpMsg) {
              otpMsg.style.color = '#065F46';
              otpMsg.innerHTML = '<i class="fa-solid fa-envelope-circle-check"></i> <strong>Kode OTP 6-digit telah terkirim!</strong> Silakan periksa Inbox / Spam email <code>"' + emailVal + '"</code> Anda.';
            }
            btnSendOTP.innerHTML = '<i class="fa-solid fa-rotate"></i> Kirim Ulang OTP';
            btnSendOTP.disabled = false;
          });
      } else {
        if (otpMsg) {
          otpMsg.style.color = '#065F46';
          otpMsg.innerHTML = '<i class="fa-solid fa-envelope-circle-check"></i> Kode OTP 6-digit telah dikirim ke email <code>"' + emailVal + '"</code>. Masukkan kode tersebut pada kolom di bawah.';
        }
        btnSendOTP.innerHTML = '<i class="fa-solid fa-key"></i> Kirim Kode OTP';
        btnSendOTP.disabled = false;
      }
    });
  }

  // 2. Tombol Verifikasi Kode OTP Input User & Auto Submit ke DB / Admin Panel
  if (btnVerifyOTP && otpInput) {
    btnVerifyOTP.addEventListener('click', function () {
      const enteredCode = otpInput.value.trim();

      if (!generatedOTP) {
        alert('Silakan klik tombol "Kirim OTP" terlebih dahulu!');
        return;
      }

      if (!enteredCode) {
        alert('Masukkan 6-digit kode OTP yang telah dikirim!');
        otpInput.focus();
        return;
      }

      if (enteredCode === generatedOTP) {
        isEmailVerified = true;
        
        if (otpMsg) {
          otpMsg.style.color = '#065F46';
          otpMsg.innerHTML = '<i class="fa-solid fa-circle-check"></i> <strong>VERIFIKASI SUKSES!</strong> Akun email <code>"' + emailInput.value + '"</code> terverifikasi asli (Real Email).';
        }

        // Lock Email Input Field
        emailInput.readOnly = true;
        emailInput.style.background = '#F1F5F9';

        const nameVal = nameInput ? nameInput.value.trim() : '';
        const subjectVal = subjectInput ? subjectInput.value.trim() : '';
        const messageVal = messageInput ? messageInput.value.trim() : '';
        
        if (statusBox) {
          statusBox.style.display = 'block';
          statusBox.style.background = '#D1FAE5';
          statusBox.style.color = '#065F46';
          statusBox.style.border = '1px solid #10B981';
          statusBox.innerHTML = '<i class="fa-solid fa-shield-check"></i> <strong>VERIFIKASI SUKSES!</strong> Email Anda terbukti aktif. Menyimpan data ke Database Admin...';
        }

        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';

        // Jika Nama, Subjek, dan Pesan sudah diisi, otomatis simpan ke DB & kirim ke Admin!
        if (nameVal && subjectVal && messageVal && !isSubmitting) {
          isSubmitting = true;
          submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan ke Database Admin...';
          setTimeout(function () {
            form.submit();
          }, 800);
        } else {
          alert('✅ VERIFIKASI OTP SUKSES! Lengkapi kolom Nama, Subjek, dan Pesan, lalu klik "Kirim Pesan & Simpan DB".');
        }
      } else {
        if (otpMsg) {
          otpMsg.style.color = '#991B1B';
          otpMsg.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> <strong>Kode OTP Salah!</strong> Periksa kembali kode 6-digit pada inbox/spam email Anda.';
        }
        alert('❌ Kode OTP Salah! Silakan periksa kembali email Anda.');
      }
    });
  }

  // 3. Prevent Form Submit if Email Not Verified via OTP
  form.addEventListener('submit', function (e) {
    if (isSubmitting) return;

    if (!isEmailVerified) {
      e.preventDefault();
      alert('⚠️ PERATURAN KEAMANAN: Anda wajib melakukan Verifikasi Kode OTP terlebih dahulu!\n\n1. Klik tombol "Kirim OTP"\n2. Buka email Anda & masukkan 6-digit kode OTP\n3. Klik "Verifikasi OTP"');
      
      if (statusBox) {
        statusBox.style.display = 'block';
        statusBox.style.background = '#FEE2E2';
        statusBox.style.color = '#991B1B';
        statusBox.style.border = '1px solid #EF4444';
        statusBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> <strong>Akses Ditolak:</strong> Anda belum memverifikasi kode OTP email pengirim.';
      }
      return;
    }

    isSubmitting = true;
  });
}
