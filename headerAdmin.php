<header class="navbar">
    <div class="brand">
        <div class="logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/LEGO_logo.svg" alt="Lego Logo">
        </div>
        <div class="title-group">
            <h1>SE - Store System</h1>
            <p>: ส่วนงานเจ้าหน้าที่</p>
        </div>
    </div>
    <div class="user-menu">
        <span class="welcome-text">สวัสดี <?= htmlspecialchars($fullname) ?> </span>
        <nav class="nav-links">
            <a href="product.php">จัดการสินค้า</a> |
            <a href="saleReport.php">รายงานการขาย</a> |
            <a href="index.php" class="logout">ออกจากระบบ</a>
        </nav>
    </div>
</header>