<?php
session_start();
require_once('db.php');
include('dataCustomer.php');

$row = mysqli_fetch_assoc($resultsql5);

if ((!isset($_SESSION['role'])) || ($_SESSION['role'] !== "1")) {
  header("Location: login.php");
  exit();
}
$fullname = $_SESSION['fullname'] ?? '-ไม่ระบุ-';

?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&family=Pridi:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <title>SE - Store System | ข้อมูลโปรไฟล์</title>
  <link rel="stylesheet" href="css/profile.css">
</head>

<body>

  <!-- แถบเมนูด้านบน (Header Navbar) -->

  <header class="navbar">
    <div class="navbar-left">
      <div class="logo-box">
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/LEGO_logo.svg" alt="Lego Logo">
      </div>
      <div class="system-title">
        <h1>SE - Store System</h1>
        <span>: ส่วนงานสมาชิก</span>
      </div>
    </div>
    <div class="navbar-right">
      <div class="user-greeting">
        สวัสดี <strong><?php echo htmlspecialchars($fullname); ?></strong>
      </div>
      <nav class="nav-menu">
        <a href="profile.php?cid=<?= $row["Cust_id"]; ?>">ข้อมูลส่วนตัว</a> |
        <a href="invoiceReport.php?cid=<?= $row["Cust_id"]; ?>">ประวัติการสั่งซื้อ</a> |
        <a href="index.php" class="logout-link">ออกจากระบบ</a>
      </nav>
    </div>
  </header>

  <!-- ส่วนเนื้อหาหลัก (การ์ดสีน้ำตาลอิฐ) -->
  <main class="main-container">
    <div class="profile-card">
      <h2 class="card-title">ข้อมูลโปรไฟล์</h2>

      <form id="profileForm" class="profile-form">
        <!-- ฝั่งซ้าย: ฟิลด์ข้อมูลต่างๆ -->
        <div class="form-left">

          <div class="form-group">
            <label for="memberId">รหัสสมาชิก</label>

            <input type="text" id="memberId" name="memberId" value="<?= $row["Cust_id"]; ?>">

          </div>

          <div class="form-group">
            <label for="titleName">คำนำหน้าชื่อ</label>

            <input type="text" id="titleName" name="titleName" value="<?= $row["Cust_prename"] ?>">

          </div>

          <div class="form-group inline-2">
            <label for="firstName">ชื่อ - นามสกุล</label>
            <div class="inline-inputs">

              <input type="text" id="firstName" name="firstName" value="<?= $row["Cust_firstname"] ?>">
              <input type="text" id="lastName" name="lastName" value="<?= $row["Cust_lastname"] ?>">

            </div>
          </div>

          <div class="form-group">
            <label for="memberLevel">ระดับสมาชิก</label>

            <input type="text" id="memberLevel" name="memberLevel" value="Gold Member" readonly value="<?= $row["Cust_level"] ?>">

          </div>

          <div class="form-group align-top">
            <label for="address">ที่อยู่</label>

            <textarea id="address" name="address" rows="4"><?= $row["Cust_address"] ?>"</textarea>

          </div>

          <div class="form-group">
            <label for="birthDate">วันเดือนปีเกิด</label>

            <input type="date" id="birthDate" name="birthDate" value="<?= $row["Cust_birth"] ?>">

          </div>

          <div class="form-group">
            <label for="phone">เบอร์โทรศัพท์</label>

            <input type="tel" id="phone" name="phone" value="<?= $row["Cust_tel"] ?>">

          </div>

          <div class="form-group">
            <label for="username">ชื่อเข้าใช้ระบบ</label>

            <input type="text" id="username" name="username" class="highlight-input" value="<?= $row["Cust_UN"] ?>">

          </div>

          <div class="form-group">
            <label for="password">รหัสผ่าน</label>

            <input type="text" id="password" name="password" class="highlight-input" value="<?= $row["Cust_PW"] ?>">

          </div>

        </div>

        <!-- ฝั่งขวา: ส่วนอัปโหลดรูปและปุ่มบันทึก -->
        <div class="form-right">
          <div class="avatar-container">
            <span class="avatar-title">รูปสมาชิก</span>
            <div class="circle-avatar" id="avatarPreview"><img src="<?= $row["Cust_picture"] ?>"></div>
            <input type="file" id="imageInput" name="avatar" accept="image/*" class="hidden-file-input">
            <button type="button" class="btn-upload" id="uploadBtn">อัปโหลดรูป</button>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-submit">ปรับปรุงข้อมูล</button>
          </div>
        </div>
      </form>
    </div>
  </main>

  <script src="js/profile.js"></script>
</body>

</html>