document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const forgotCheckbox = document.getElementById("forgotCheckbox");

  // ตรวจสอบความถูกต้องของข้อมูลก่อนส่งฟอร์ม (Form Validation)
  loginForm.addEventListener("submit", (e) => {
    const usernameInput = document.getElementById("username").value.trim();
    const passwordInput = document.getElementById("password").value;

    if (!usernameInput || !passwordInput) {
      e.preventDefault();
      alert("กรุณากรอกชื่อเข้าใช้ระบบและรหัสผ่านให้ครบถ้วน");
      return;
    }
  });

  // จัดการ Action เมื่อคลิก "ลืมรหัสผ่าน ?"
  forgotCheckbox.addEventListener("change", (e) => {
    if (e.target.checked) {
      const userEmail = prompt(
        "กรุณากรอก อีเมล หรือ ชื่อผู้ใช้ ที่ต้องการรีเซ็ตรหัสผ่าน:",
      );
      if (userEmail) {
        alert(
          `ระบบได้ส่งลิงก์สำหรับตั้งรหัสผ่านใหม่ไปยัง ${userEmail} เรียบร้อยแล้ว`,
        );
      }
      // ยกเลิกการเช็คเพื่อคืนค่าสภาวะปกติ
      e.target.checked = false;
    }
  });
});
