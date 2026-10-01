document.addEventListener("DOMContentLoaded", () => {
  const backBtn = document.getElementById("backBtn");
  const invoiceTableBody = document.getElementById("invoiceTableBody");

  // ตัวอย่างข้อมูลใบสั่งซื้อ (Mockup Data)
  const invoiceData = {
    orderNo: "ORD-67001",
    orderDate: "01/09/2026",
    memberName: "นาย กอไก่ ขนสวย",
    shippingAddress:
      "123/45 ถนนสุขุมวิท แขวงคลองเตย เขตคลองเตย กรุงเทพมหานคร 10110",
    phone: "081-234-5678",
    paymentType: "โอนเงินผ่านธนาคาร",
    courier: "KERRY EXPRESS",
    items: [
      {
        code: "LEGO-01",
        name: "LEGO Classic Medium Creative Brick Box",
        qty: 1,
        price: 1200.0,
        total: 1200.0,
      },
      {
        code: "LEGO-02",
        name: "LEGO Star Wars X-Wing Fighter",
        qty: 2,
        price: 1500.0,
        total: 3000.0,
      },
    ],
    subtotal: 4200.0,
    discount: 200.0,
    tax: 0.0,
    netTotal: 4000.0,
  };

  // Event ปุ่มกลับหน้าหลัก
  backBtn.addEventListener("click", () => {
    window.history.back();
  });

  // แสดงข้อมูลลงใน UI
  function populateInvoice(data) {
    document.getElementById("orderNoBox").textContent = data.orderNo || "";
    document.getElementById("orderDateBox").textContent = data.orderDate || "";
    document.getElementById("memberNameBox").textContent =
      data.memberName || "";
    document.getElementById("shippingAddressBox").textContent =
      data.shippingAddress || "";
    document.getElementById("phoneBox").textContent = data.phone || "";
    document.getElementById("paymentTypeBox").textContent =
      data.paymentType || "";
    document.getElementById("courierBox").textContent = data.courier || "";

    // แสดงรายการสินค้าในตาราง
    invoiceTableBody.innerHTML = "";
    const items = data.items || [];

    items.forEach((item) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td class="text-center">${item.code}</td>
        <td>${item.name}</td>
        <td class="text-center">${item.qty}</td>
        <td class="text-right">${item.price.toLocaleString("th-TH", { minimumFractionDigits: 2 })}</td>
        <td class="text-right">${item.total.toLocaleString("th-TH", { minimumFractionDigits: 2 })}</td>
      `;
      invoiceTableBody.appendChild(tr);
    });

    // แสดงแถวว่างให้ครบ 5 แถวเพื่อรักษารูปทรงตาราง
    const emptyRowsCount = Math.max(0, 5 - items.length);
    for (let i = 0; i < emptyRowsCount; i++) {
      const tr = document.createElement("tr");
      tr.innerHTML = `<td></td><td></td><td></td><td></td><td></td>`;
      invoiceTableBody.appendChild(tr);
    }

    // สรุปยอดเงิน
    document.getElementById("subtotalBox").textContent = data.subtotal
      ? data.subtotal.toLocaleString("th-TH", { minimumFractionDigits: 2 })
      : "";
    document.getElementById("discountBox").textContent = data.discount
      ? data.discount.toLocaleString("th-TH", { minimumFractionDigits: 2 })
      : "";
    document.getElementById("taxBox").textContent = data.tax
      ? data.tax.toLocaleString("th-TH", { minimumFractionDigits: 2 })
      : "";
    document.getElementById("netTotalBox").textContent = data.netTotal
      ? data.netTotal.toLocaleString("th-TH", { minimumFractionDigits: 2 })
      : "0.00";
  }

  // เริ่มต้นใส่ข้อมูล
  populateInvoice(invoiceData);
});
