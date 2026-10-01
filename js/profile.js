document.addEventListener('DOMContentLoaded', () => {
  const profileForm = document.getElementById('profileForm');
  const uploadBtn = document.getElementById('uploadBtn');
  const imageInput = document.getElementById('imageInput');
  const avatarPreview = document.getElementById('avatarPreview');

  // Trigger เลือกไฟล์เมื่อกดปุ่ม "อัปโหลดรูป"
  uploadBtn.addEventListener('click', () => {
    imageInput.click();
  });

  // แสดงตัวอย่างรูปภาพเมื่อผู้ใช้เลือกไฟล์ใหม่ (Image Preview)
  imageInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      // ตรวจสอบขนาดไฟล์ (ไม่เกิน 2MB)
      if (file.size > 2 * 1024 * 1024) {
        alert('ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB');
        imageInput.value = '';
        return;
      }

      const reader = new FileReader();
      reader.onload = (evt) => {
        avatarPreview.style.backgroundImage = `url('${evt.target.result}')`;
      };
      reader.readAsDataURL(file);
    }
  });

  // การจัดการเมื่อส่งฟอร์ม (Form Submission)
  profileForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(profileForm);
    
    // ตรวจสอบความถูกต้องเบื้องต้น (Validation)
    const phone = formData.get('phone');
    if (phone && !/^[0-9]{9,10}$/.test(phone)) {
      alert('กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง (9-10 หลัก)');
      return;
    }

    // ส่งข้อมูลแบบ AJAX/Fetch (ตัวอย่างการเตรียมส่งไปประมวลผล)
    console.log('อัปเดตข้อมูลโปรไฟล์เรียบร้อย');
    alert('ปรับปรุงข้อมูลโปรไฟล์สำเร็จ');
  });
});