<?php
session_start();
require_once('db.php');
include('dataInvoice.php');

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
    <title>SE - Store System | ประวัติการสั่งซื้อสินค้า</title>
    <link rel="stylesheet" href="css/invoiceReport.css">
</head>

<body>

    <!-- แถบเมนูด้านบน (Navbar) -->
    <?php include('headerMember.php'); ?>

    <!-- เนื้อหาหลัก (การ์ดรายงานสีขาว) -->
    <main class="main-container">
        <div class="report-card">

            <!-- หัวข้อรายงาน -->
            <section class="report-header">
                <h2 class="report-title">ประวัติการสั่งซื้อสินค้า</h2>
                <div class="report-date-info">
                    ข้อมูล ณ วันที่ <span id="currentDateDisplay"><?= date('j F, Y'); ?></span>
                </div>
            </section>

            <!-- ตารางแสดงรายการประวัติการสั่งซื้อ -->
            <section class="table-container">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th class="th-pill">เลขใบสั่งซื้อ</th>
                            <th class="th-pill">วันที่ใบสั่งซื้อ</th>
                            <th class="th-pill">สถานะการจัดส่ง</th>
                            <th class="th-pill">จำนวนซื้อ</th>
                            <th class="th-pill">รวมเงิน</th>
                            <th class="th-pill">ลดส่วน</th>
                            <th class="th-pill">ภาษี</th>
                            <th class="th-pill">รวมสุทธิ</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceTableBody">
                        <?php if ($resultInvoice->num_rows > 0):
                            $total = 0; ?>
                            <?php while ($row = $resultInvoice->fetch_assoc()):
                                $total = $total + $row['Amount']; ?>
                                <tr>
                                    <td class="text-center"><a href="printInvoice.php?cid=<?= $Cid  ?>&inv_id=<?= $row['Inv_no']  ?>"><?= htmlspecialchars($row['Inv_no']) ?></a></td>
                                    <td class="text-center"><?= htmlspecialchars($row['Inv_date']) ?></td>
                                    <td class="text-center"><?php switch ($row['Inv_shipping']) {
                                                                case '0':
                                                                    echo "เตรียมจัดส่ง";
                                                                    break;
                                                                case '1':
                                                                    echo "จัดส่งแล้ว";
                                                                    break;
                                                                default:
                                                                    echo "รับสินค้าแล้ว";
                                                            } ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['Qty']) ?></td>
                                    <td class="text-right"><?= number_format($row['Amount'], 2) ?></td>
                                    <td class="text-center">0.00</td>
                                    <td class="text-center">0.00</td>
                                    <td class="text-right"><?= number_format($row['Amount'], 2)  ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">ไม่มีข้อมูลใบสั่งซื้อในระบบ</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

            <!-- ส่วนสรุปยอดซื้อรวม -->
            <section class="report-footer">
                <div class="summary-section">
                    <span class="summary-label">ยอดซื้อรวมทั้งสิ้น</span>
                    <div class="summary-box">
                        <span id="grandTotalDisplay"><?= number_format($total, 2); ?></span>
                    </div>
                    <span class="currency-label">บาท</span>
                </div>
            </section>

        </div>
    </main>

    <!-- <script src="js/invoiceReport.js"></script> -->
</body>

</html>