document.addEventListener("DOMContentLoaded", () => {
  const backBtn = document.getElementById("backBtn");
  const printBtn = document.getElementById("printBtn");
  const invoiceTableBody = document.getElementById("invoiceTableBody");

  // Event ปุ่มกลับหน้าหลัก
  backBtn.addEventListener("click", () => {
    window.history.back();
  });

  printBtn.addEventListener("click", () => {
    window.addEventListener(" load", window.print());
    window.onafterprint = function () {
      window.history.back();
    };
  });
});
