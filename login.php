<!-- login.php - โครงสร้างหน้าเข้าสู่ระบบและส่วนติดต่อ PHP Session -->
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&family=Pridi:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <title>เข้าสู่ระบบ - SE-Store System</title>
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
  <!-- พื้นหลังสองสี Split Screen Background -->

  <!-- การ์ดเข้าสู่ระบบหลัก -->
  <div class="login-card">

    <!-- ฝั่งซ้าย: ฟอร์มเข้าสู่ระบบ -->
    <div class="login-form-container">
      <h1 class="welcome-title">ยินดีต้อนรับ</h1>

      <form id="loginForm" action="loginProcess.php" method="POST">
        <div class="input-group">
          <label for="username">ชื่อเข้าใช้ระบบ</label>
          <input type="text" id="username" name="username" value="C0003" required autocomplete="off">
        </div>

        <div class="input-group">
          <label for="password">รหัสผ่าน</label>
          <input type="password" id="password" name="password" value="1234" required>
        </div>

        <div class="forgot-group">
          <input type="checkbox" id="forgotCheckbox" name="forgot">
          <label for="forgotCheckbox">ลืมรหัสผ่าน ?</label>
        </div>

        <button type="submit" class="btn-login">Login</button>
      </form>

      <div class="register-link">
        <a href="index.php" type="botton"><- กลับไปหน้าหลัก!</a>
      </div>
    </div>

    <!-- ฝั่งขวา: ภาพและแบนเนอร์ -->
    <div class="login-banner">
      <img src="img/login.jpg" alt="World Consumer Rights Day Illustration">
    </div>
  </div>

  <script src="js/login.js"></script>
</body>

</html>