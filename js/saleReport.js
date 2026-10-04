document.addEventListener("DOMContentLoaded", () => {
  // ดึง Element อ้างอิง
  const currentDateDisplay = document.getElementById("currentDateDisplay");
  const reportTableBody = document.getElementById("reportTableBody");
  const searchBtn = document.getElementById("searchBtn");
  const grandTotalDisplay = document.getElementById("grandTotalDisplay");

  searchBtn.addEventListener("click", () => {
    const monthFilter = document.getElementById("monthFilter").value;
    const yearFilter = document.getElementById("yearFilter").value;
    window.location =
      "saleReport.php?month=" + monthFilter + "&year=" + yearFilter;
  });
});
