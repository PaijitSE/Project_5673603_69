<?php
session_start();
require_once('db.php');
include('dataSales.php');

if ((!isset($_SESSION['role'])) || ($_SESSION['role'] !== "2")) {
  header("Location: login.php");
  exit();
}
$fullname = $_SESSION['fullname'] ?? '-ไม่ระบุ-';

$filers = '';
if ($month) $filers = $filers . " เดือน :" . htmlspecialchars($month);
if ($year)  $filers = $filers . " ปีพ.ศ." . htmlspecialchars($year);
$filers = $filers ? $filers : 'ทั้งหมด';

?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&family=Pridi:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <title>SE - Store System | รายงานการขายสินค้า</title>
  <link rel="stylesheet" href="css/saleReport.css">
</head>

<body>
  <!-- แถบเมนูด้านบน (Navbar) -->
  <?php include('headerAdmin.php'); ?>

  <!-- ส่วนเนื้อหาหลัก (การ์ดสีขาว) -->
  <main class="main-container">
    <div class="report-card">

      <!-- ส่วนหัวรายงาน (โลโก้ ชื่อบริษัท และวันที่) -->
      <section class="report-header">
        <div class="company-brand">
          <div class="company-logo">LEGO</div>
          <div class="company-info">
            <h2>บริษัท SE-Store จำกัด</h2>
            <h3>รายงานการขายสินค้า : <?php echo $filers; ?></h3>
          </div>
        </div>
        <div class="report-date-info">
          ข้อมูล ณ วันที่ <span id="currentDateDisplay"><?= date('j F, Y'); ?></span>
        </div>
      </section>

      <!-- ตารางแสดงรายการรายงานการขาย -->
      <section class="table-container">
        <table class="report-table">
          <thead>
            <tr>
              <th class="th-pill">เลขที่ใบเสร็จ</th>
              <th class="th-pill">วันที่ใบเสร็จ</th>
              <th class="th-pill">ชื่อสมาชิก</th>
              <th class="th-pill">จำนวนซื้อ</th>
              <th class="th-pill">รวมเงิน</th>
              <th class="th-pill">ลดส่วน</th>
              <th class="th-pill">ภาษี</th>
              <th class="th-pill">รวมสุทธิ</th>
            </tr>
          </thead>
          <tbody id="reportTableBody">
            <?php if ($resultInvoice->num_rows > 0):
              $total = 0; ?>
              <?php while ($row = $resultInvoice->fetch_assoc()):
                $total = $total + $row['Amount']; ?>
                <tr>
                  <td class="text-center"><a href="printInvoice.php?cid=<?= $row['Inv_cust'] ?>&inv_id=<?= $row['Inv_no']  ?>"><?= htmlspecialchars($row['Inv_no']) ?></a></td>
                  <td class="text-center"><?= htmlspecialchars($row['Inv_date']) ?></td>
                  <td class="text-center"><?= htmlspecialchars($row['Customer_name']) ?></td>
                  <td class="text-center"><?= htmlspecialchars($row['Qty']) ?></td>
                  <td class="text-right"><?= number_format($row['Amount'], 2) ?></td>
                  <td class="text-center">0.00</td>
                  <td class="text-center"><?= number_format($row['Amount'] * .1, 2)  ?></td>
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

      <!-- ส่วนท้ายของการ์ดรายงาน (ตัวกรองค้นหา และสรุปยอดขายรวม) -->
      <section class="report-footer">
        <div class="filter-section">
          <label>เลือกวันที่</label>
          <select id="monthFilter" class="custom-select month">
            <option value="">-เลือก-</option>
            <option value="01">มกราคม</option>
            <option value="02">กุมภาพันธ์</option>
            <option value="03">มีนาคม</option>
            <option value="04">เมษายน</option>
            <option value="05">พฤษภาคม</option>
            <option value="06">มิถุนายน</option>
            <option value="07">กรกฎาคม</option>
            <option value="08">สิงหาคม</option>
            <option value="09">กันยายน</option>
            <option value="10">ตุลาคม</option>
            <option value="11">พฤศจิกายน</option>
            <option value="12">ธันวาคม</option>
          </select>
          <input type="text" id="yearFilter" class="custom-select year" value="">
          <button id="searchBtn" class="btn-search">ค้นหา</button>
        </div>

        <div class="summary-section">
          <span class="summary-label">ยอดขายรวมทั้งสิ้น</span>
          <div class="summary-box">
            <span id="grandTotalDisplay"><?= number_format($total, 2); ?></span>
          </div>
          <span class="currency-label">บาท</span>
        </div>
      </section>

    </div>
  </main>

  <script src="js/saleReport.js"></script>
</body>

</html>