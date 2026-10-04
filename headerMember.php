<!-- แถบเมนูด้านบน (Navbar) -->
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
            <a href="profile.php?cid=<?= $_SESSION['id']; ?>">ข้อมูลส่วนตัว</a> |
            <a href="invoiceReport.php?cid=<?= $_SESSION['id']; ?>">ประวัติการสั่งซื้อ</a> |
            <a href="index.php" class="logout-link">ออกจากระบบ</a>
        </nav>
    </div>
</header>