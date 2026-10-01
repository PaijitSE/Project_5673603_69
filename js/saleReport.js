document.addEventListener('DOMContentLoaded', () => {
  // ดึง Element อ้างอิง
  const currentDateDisplay = document.getElementById('currentDateDisplay');
  const reportTableBody = document.getElementById('reportTableBody');
  const dateFilter = document.getElementById('dateFilter');
  const searchBtn = document.getElementById('searchBtn');
  const grandTotalDisplay = document.getElementById('grandTotalDisplay');

  // ตัวอย่างข้อมูลการขาย (Mockup Data)
  const salesData = [
    { receiptNo: 'RC-67001', date: '01/09/2026', memberName: 'สมชาย ใจดี', quantity: 2, total: 1500.00, discount: 100.00, tax: 98.00, netTotal: 1498.00 },
    { receiptNo: 'RC-67002', date: '02/09/2026', memberName: 'สมหญิง รักดี', quantity: 1, total: 850.00, discount: 0.00, tax: 59.50, netTotal: 909.50 },
    { receiptNo: 'RC-67003', date: '03/09/2026', memberName: 'อนันต์ สุขใจ', quantity: 5, total: 4200.00, discount: 200.00, tax: 280.00, netTotal: 4280.00 },
  ];

  // 1. ฟังก์ชันแสดงวันที่ปัจจุบัน
  function initCurrentDate() {
    const today = new Date();
    const day = String(today.getDate()).padStart(2, '0');
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const year = today.getFullYear() + 543; // แปลงเป็น พ.ศ.
    if (currentDateDisplay) {
      currentDateDisplay.textContent = `${day}/${month}/${year}`;
    }
  }

  // 2. ฟังก์ชันเรนเดอร์ข้อมูลลงในตาราง
  function renderReportTable(data) {
    reportTableBody.innerHTML = '';

    // หากไม่มีข้อมูล ให้สร้างแถวว่างแบบในรูปภาพ (5 แถว)
    if (!data || data.length === 0) {
      renderEmptyRows(5);
      grandTotalDisplay.textContent = '0.00';
      return;
    }

    let calculatedGrandTotal = 0;

    data.forEach(item => {
      calculatedGrandTotal += item.netTotal;

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td class="text-center">${item.receiptNo}</td>
        <td class="text-center">${item.date}</td>
        <td>${item.memberName}</td>
        <td class="text-center">${item.quantity}</td>
        <td class="text-right">${item.total.toLocaleString('th-TH', { minimumFractionDigits: 2 })}</td>
        <td class="text-right">${item.discount.toLocaleString('th-TH', { minimumFractionDigits: 2 })}</td>
        <td class="text-right">${item.tax.toLocaleString('th-TH', { minimumFractionDigits: 2 })}</td>
        <td class="text-right">${item.netTotal.toLocaleString('th-TH', { minimumFractionDigits: 2 })}</td>
      `;
      reportTableBody.appendChild(tr);
    });

    // หากรายการมีไม่ถึง 5 แถว ให้เติมแถวว่างให้ครบเพื่อคงความสวยงามตาม UI
    if (data.length < 5) {
      renderEmptyRows(5 - data.length);
    }

    // อัปเดตยอดขายรวมทั้งสิ้น
    grandTotalDisplay.textContent = calculatedGrandTotal.toLocaleString('th-TH', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  // ฟังก์ชันวาดแถวว่าง (Placeholder Rows) ตามดีไซน์ต้นฉบับ
  function renderEmptyRows(count) {
    for (let i = 0; i < count; i++) {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td></td><td></td><td></td><td></td>
        <td></td><td></td><td></td><td></td>
      `;
      reportTableBody.appendChild(tr);
    }
  }

  // 3. Event Handling: การกรองข้อมูลเมื่อกดปุ่มค้นหา
  searchBtn.addEventListener('click', () => {
    const selectedValue = dateFilter.value;
    
    if (selectedValue === '') {
      // หากยังไม่ได้เลือก ให้แสดงแถวว่าง
      renderReportTable([]);
    } else {
      // โหลดข้อมูลตามเงื่อนไข (ในระบบจริงจะส่ง AJAX Fetch ไปยัง Backend PHP)
      renderReportTable(salesData);
    }
  });

  // เรียกใช้งานเริ่มต้น
  initCurrentDate();
  renderReportTable([]); // เริ่มต้นด้วยการแสดงตารางว่างตามภาพ
});