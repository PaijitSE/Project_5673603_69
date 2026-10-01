<?php
session_start();
require_once('db.php');
include('dataProduct.php');
include('dataProductType.php');


if ((!isset($_SESSION['role'])) || ($_SESSION['role'] !== "2")) {
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
    <title>SE - Store System</title>
    <link rel="stylesheet" href="css/product.css">
</head>

<body>
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

    <main class="main-container">
        <div class="action-header">
            <h2>จัดการข้อมูลสินค้า</h2>
            <button class="btn btn-add" id="openModalBtn">+ เพิ่มข้อมูลสินค้า</button>
        </div>

        <div class="table-responsive">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>ประเภท</th>
                        <th>จำนวน</th>
                        <th>ราคาขาย</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <?php if ($resultsql1->num_rows > 0): ?>
                        <?php while ($row = $resultsql1->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['Product_id']) ?></td>
                                <td><?= htmlspecialchars($row['Product_name']) ?></td>
                                <td><?= htmlspecialchars($row['Product_type']) ?></td>
                                <td><?= htmlspecialchars($row['Product_count']) ?></td>
                                <td><?= htmlspecialchars($row['Product_unit']) ?></td>
                                <td><?= htmlspecialchars($row['Product_price']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-edit" data-product="<?php echo htmlspecialchars(json_encode($row, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>">แก้ไข</button>
                                        <button class=" btn-delete" onclick="deleteData('<?= $row['Product_id']; ?>')">ลบ</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">ไม่มีข้อมูลสินค้าในระบบ</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div class="modal-overlay hidden" id="productModal">
        <div class="modal-card">
            <h3 class="modal-title" id="modelTitle">เพิ่มข้อมูลสินค้าใหม่ หรือ แก้ไขข้อมูลเดิม</h3>

            <form id="productForm" class="modal-body" enctype="multipart/form-data">
                <div class="form-left">
                    <input type="hidden" id="m_action" name="action" value="">
                    <div class="form-group">
                        <label>รหัสสินค้า</label>
                        <input type="text" id="productId" name="productId" placeholder="ระบุรหัสสินค้า S ตามด้วยลำดับสินค้า เช่น S01, S02" required>
                    </div>

                    <div class="form-group">
                        <label>ชื่อสินค้า</label>
                        <input type="text" id="productName" name="productName" required>
                    </div>

                    <div class="form-group inline-2">
                        <label>ประเภทสินค้า</label>
                        <div class="inline-inputs">
                            <input type="text" id="categoryCode" name="categoryCode" placeholder="รหัสประเภท">
                            <select id="categorySelect">
                                <?php while ($row = mysqli_fetch_assoc($resultsql3)): ?>
                                    <option value="<?= $row['Type_id'] ?>"><?= $row['Type_id'] . '-' . $row['Type_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group inline-2">
                        <label>จำนวนสินค้า</label>
                        <div class="inline-inputs">
                            <input type="number" id="stockQty" name="stockQty" placeholder="จำนวนในคลัง">
                            <input type="text" id="unitName" name="unitName" placeholder="หน่วยนับ">
                        </div>
                    </div>

                    <div class="form-group inline-2">
                        <label>ราคาต่อหน่วย</label>
                        <div class="inline-inputs">
                            <input type="number" id="costPrice" name="costPrice" placeholder="ราคาต้นทุน">
                            <input type="number" id="sellPrice" name="sellPrice" placeholder="ราคาขาย">
                        </div>
                    </div>

                    <div class="form-group inline-2">
                        <label>ควบคุมคลัง</label>
                        <div class="inline-inputs">
                            <input type="number" id="minQty" name="minQty" placeholder="จำนวนต่ำสุด">
                            <input type="number" id="maxQty" name="maxQty" placeholder="จำนวนสูงสุด">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>รายละเอียด</label>
                        <textarea id="description" name="description" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label>สถานะ</label>
                        <select id="statusSelect" name="statusSelect">
                            <option value="1">1-พร้อมใช้งาน</option>
                            <option value="2">2-ยกเลิกใช้งาน</option>
                        </select>
                    </div>
                </div>

                <div class="form-right">
                    <div class="image-preview-container">
                        <p>รูปสินค้า</p>
                        <input type="hidden" id="imageOld" name="imageOld" value="">
                        <div class="circle-avatar" id="avatarPreview"><img src="" id="productImg" alt="Product Image"></div>
                        <input type="file" id="imageInput" name="image" accept="image/*" class="hidden">
                        <button type="button" class="btn btn-upload" onclick="document.getElementById('imageInput').click()">อัปโหลดรูป</button>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn btn-cancel" id="closeModalBtn">ยกเลิก</button>
                        <button type="submit" class="btn btn-save" id="manageModalBtn">บันทึกข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="js/product.js"></script>
</body>

</html>