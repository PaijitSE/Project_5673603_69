document.addEventListener("DOMContentLoaded", () => {
  const currentDateDisplay = document.getElementById("currentDateDisplay");
  const invoiceTableBody = document.getElementById("invoiceTableBody");
  const grandTotalDisplay = document.getElementById("grandTotalDisplay");

  // ตัวอย่างข้อมูลประวัติการสั่งซื้อ (Mockup Data)
  const orderHistory = [
    {
      orderNo: "ORD-6701",
      orderDate: "01/09/2026",
      status: "จัดส่งแล้ว",
      qty: 3,
      total: 2400.0,
      discount: 100.0,
      tax: 161.0,
      netTotal: 2461.0,
    },
    {
      orderNo: "ORD-6702",
      orderDate: "05/09/2026",
      status: "กำลังจัดส่ง",
      qty: 1,
      total: 1200.0,
      discount: 0.0,
      tax: 84.0,
      netTotal: 1284.0,
    },
  ];

  // แสดงวันที่ปัจจุบัน (พ.ศ.)
  function initCurrentDate() {
    const today = new Date();
    const day = String(today.getDate()).padStart(2, "0");
    const month = String(today.getMonth() + 1).padStart(2, "0");
    const year = today.getFullYear() + 543;
    if (currentDateDisplay) {
      currentDateDisplay.textContent = `${day}/${month}/${year}`;
    }
  }

  // วาดรายการประวัติสั่งซื้อลงในตาราง
  function renderInvoiceTable(data) {
    invoiceTableBody.innerHTML = "";

    if (!data || data.length === 0) {
      renderEmptyRows(5);
      grandTotalDisplay.textContent = "0.00";
      return;
    }

    let calculatedGrandTotal = 0;

    data.forEach((item) => {
      calculatedGrandTotal += item.netTotal;

      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td class="text-center">${item.orderNo}</td>
        <td class="text-center">${item.orderDate}</td>
        <td class="text-center">${item.status}</td>
        <td class="text-center">${item.qty}</td>
        <td class="text-right">${item.total.toLocaleString("th-TH", { minimumFractionDigits: 2 })}</td>
        <td class="text-right">${item.discount.toLocaleString("th-TH", { minimumFractionDigits: 2 })}</td>
        <td class="text-right">${item.tax.toLocaleString("th-TH", { minimumFractionDigits: 2 })}</td>
        <td class="text-right">${item.netTotal.toLocaleString("th-TH", { minimumFractionDigits: 2 })}</td>
      `;
      invoiceTableBody.appendChild(tr);
    });

    // วาดแถวว่างเสริมให้ครบ 5 แถวเพื่อรักษาดีไซน์
    if (data.length < 5) {
      renderEmptyRows(5 - data.length);
    }

    grandTotalDisplay.textContent = calculatedGrandTotal.toLocaleString(
      "th-TH",
      {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      },
    );
  }

  // สร้างแถวว่าง (Placeholder Rows)
  function renderEmptyRows(count) {
    for (let i = 0; i < count; i++) {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td></td><td></td><td></td><td></td>
        <td></td><td></td><td></td><td></td>
      `;
      invoiceTableBody.appendChild(tr);
    }
  }

  // เริ่มต้นการทำงาน
  initCurrentDate();
  renderInvoiceTable([]); // เรนเดอร์ตารางว่างเริ่มต้นตามภาพ
});
