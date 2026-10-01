<?php
session_start();
require_once('db.php');
include('dataInvoice.php');
include('dataInvoiceDetail.php');

$rowInvoice = mysqli_fetch_assoc($resultInvoice);

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
    <title>SE - Store System | ใบสั่งซื้อ/ใบเสร็จรับเงิน</title>
    <link rel="stylesheet" href="css/printInvoice.css">
</head>

<body>

    <!-- ปุ่มกลับหน้าหลัก (มุมขวาบน) -->
    <div class="top-bar">
        <button type="button" class="btn-back" id="backBtn"><a href="profile.php?cid=<?= $_SESSION['id'] ?>">กลับหน้าหลัก</a></button>
    </div>

    <!-- การ์ดเอกสารใบเสร็จ (กระดาษสีขาว) -->
    <main class="invoice-wrapper">
        <div class="invoice-card">

            <!-- ส่วนหัวเอกสาร (โลโก้ และ ชื่อบริษัท) -->
            <header class="invoice-header">
                <div class="brand-group">
                    <div class="logo-box">LEGO</div>
                    <div class="company-details">
                        <h1>บริษัท SE-Store จำกัด</h1>
                        <h2>ใบสั่งซื้อ/ใบเสร็จรับเงิน</h2>
                    </div>
                </div>
            </header>

            <!-- ส่วนข้อมูลเลขที่และวันที่ใบสั่งซื้อ (มุมขวา) -->
            <section class="meta-info-section">
                <div class="info-row">
                    <label>ใบสั่งซื้อเลขที่</label>
                    <div class="value-box" id="orderNoBox"><?= $rowInvoice["Inv_no"] ?></div>
                </div>
                <div class="info-row">
                    <label>วันที่สั่งซื้อ</label>
                    <div class="value-box" id="orderDateBox"><?= $rowInvoice["Inv_date"] ?></div>
                </div>
            </section>

            <!-- ส่วนข้อมูลลูกค้า/ผู้สั่งซื้อ -->
            <section class="customer-info-section">
                <div class="info-row wide">
                    <label>สมาชิก</label>
                    <div class="value-box" id="memberNameBox"><?= $rowInvoice["Customer_name"] ?></div>
                </div>
                <div class="info-row wide">
                    <label>ที่ส่งจัดส่ง</label>
                    <div class="value-box" id="shippingAddressBox"><?= $rowInvoice["Cust_address"] ?></div>
                </div>
                <div class="info-row wide">
                    <label>เบอร์โทรศัพท์</label>
                    <div class="value-box" id="phoneBox"><?= $rowInvoice["Cust_tel"] ?></div>
                </div>
            </section>

            <!-- ตารางรายการสินค้า -->
            <section class="table-section">
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th class="col-code">รหัสสินค้า</th>
                            <th class="col-name">ชื่อสินค้า</th>
                            <th class="col-qty">จำนวน</th>
                            <th class="col-price">ราคาต่อหน่วย</th>
                            <th class="col-total">รวมเงิน</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceTableBody">
                        <?php $total = 0;
                        while ($row = $resultInvoiceDetail->fetch_assoc()):
                            $amount = $row['Product_price'] * $row['Product_num'];
                            $total += $amount;
                        ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($row['Product_id']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['Product_name']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['Product_num']) ?></td>
                                <td class="text-right"><?= number_format($row['Product_price'], 2) ?></td>
                                <td class="text-right"><?= number_format($amount, 2)  ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>

            <!-- ส่วนสรุปการชำระเงินและยอดรวมท้ายเอกสาร -->
            <footer class="invoice-footer">
                <!-- ฝั่งซ้าย: วิธีชำระเงินและการขนส่ง -->
                <div class="footer-left">
                    <div class="info-row medium">
                        <label>ชำระแบบ</label>
                        <div class="value-box" id="paymentTypeBox">บัตรเครดิต/เดบิต</div>
                    </div>
                    <div class="info-row medium">
                        <label>ขนส่งสินค้าโดย</label>
                        <div class="value-box" id="courierBox">SPX Express</cd>
                        </div>
                    </div>
                </div>

                <!-- ฝั่งขวา: คำนวณยอดเงินรวม -->
                <div class="footer-right">
                    <div class="summary-row">
                        <label>รวมเงินทั้งสิ้น</label>
                        <div class="value-box right" id="subtotalBox"><?= number_format($total, 2); ?></div>
                    </div>
                    <div class="summary-row">
                        <label>ส่วนลด</label>
                        <div class="value-box right" id="discountBox">0.00</div>
                    </div>
                    <div class="summary-row">
                        <label>ภาษี ณ ที่จ่าย</label>
                        <div class="value-box right" id="taxBox"><?= number_format($total * .1, 2); ?></div>
                    </div>
                    <div class="summary-row net-row">
                        <label>รวมเงินสุทธิ</label>
                        <div class="value-box-highlight" id="netTotalBox"><?= number_format($total, 2); ?></div>
                    </div>
                </div>
            </footer>

        </div>
    </main>

    <script src="printInvoice.js"></script>
</body>

</html>