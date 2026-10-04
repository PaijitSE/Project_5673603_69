<?php
session_start();
session_unset();
session_destroy();   // ทำลายเซสชัน
require_once('db.php');
include('dataProduct.php');
include('dataMostSale.php');
include('dataProductType.php');

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&family=Pridi:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <title>SE - Store System</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <!-- Header / Navbar -->
    <div class="navbar">
        <div class="navbar-brand">
            <!-- โลโก้ LEGO หรือรูปจำลอง -->
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/LEGO_logo.svg" alt="Lego Logo">
            <span>SE - Store System</span>
        </div>
        <div class="navbar-menu">
            <a href="#">หน้าหลัก</a>
            <span>|</span>
            <a href="login.php">เข้าสู่ระบบ</a>
        </div>
    </div>

    <div class="container">
        <!-- Banner Carousel -->
        <div class="banner">
            <button class="banner-nav prev">&#10094;</button> <!--ปุ่ม slide ซ้าย-->
            <div class="banner-content">
                <!-- <h2>SE-Store For you!!!</h2>
                <h1>MEGA SALE</h1>
                <p>--- WWW.YOURWEBSITE.COM ---</p> -->
            </div>
            <button class="banner-nav next">&#10095;</button> <!--ปุ่ม slide ซ้าย-->
        </div>

        <!-- Recommended Section Title -->
        <div class="section-title">
            สินค้าขายดี / สินค้าแนะนำ
        </div>

        <!-- Recommended Products -->
        <div class="recommended-section">
            <?php while ($row = mysqli_fetch_assoc($resultsql2)) { ?>
                <div class="rec-card">
                    <img src="<?= $row['Product_picture'] ?>" alt="Product">
                    <div class="rec-name"><?= mb_substr($row['Product_name'], 0, 25, "UTF-8") . '...' ?></div>
                    <div class="rec-price"><?= $row['Product_price'] . ' บาท' ?></div>
                </div>
            <?php } ?>
        </div>

        <!-- Search and Filter Bar -->
        <div class="filter-bar">
            <form class="search-box" action="?" method="GET" id="searchForm">
                <input type="text" name="keyword" placeholder="ค้นหาสินค้า" id="searchInput">
                <button type="submit">Search</button>
            </form>
            <div class="category-select">
                <select name="category" id="categorySelect" onchange="filterCategory(this.value)">
                    <option value="">ทุกประเภทสินค้า</option>
                    <?php while ($row = mysqli_fetch_assoc($resultsql3)) { ?>
                        <option value="<?= $row['Type_id'] ?>"><?= $row['Type_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="products-container" id="productGrid">
            <?php while ($row = mysqli_fetch_assoc($resultsql1)) { ?>
                <div class="product-card" data-category="<?= $row['Product_type'] ?>" data-name="<?= $row['Product_name'] ?>">
                    <img src="<?= $row['Product_picture'] ?>" alt="<?= $row['Product_name'] ?>">
                    <div class="product-code">รหัสสินค้า-<?= $row['Product_id'] ?></div>
                    <div class="product-info">
                        <strong>Type :</strong> <?= $row['Product_type'] ?><br>
                        <strong>Name :</strong> <?= mb_substr($row['Product_name'], 0, 12, "UTF-8") . '...' ?><br>
                        <strong>Price :</strong> <?= $row['Product_price'] ?><br>
                        <strong>Stock In :</strong> <?= $row['Product_count'] ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- JavaScript สำหรับการค้นหาและกรองสินค้า -->
    <script src="js/index.js"></script>
</body>

</html>