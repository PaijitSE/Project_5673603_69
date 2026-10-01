function filterCategory(category) {
  location.href = "index.php?category=" + category;
}

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const vCate = urlParams.get("category");
const vKey = urlParams.get("keyword");

if (vCate !== "") {
  const selectElement = document.getElementById("categorySelect");
  const optionsArray = Array.from(selectElement.options);
  const targetIndex = optionsArray.findIndex(
    (option) => option.value === vCate,
  );

  // ถ้าเจอตัวเลือก (index ไม่เท่ากับ -1) ให้เปลี่ยนสไตล์
  if (targetIndex !== -1) {
    selectElement.options[targetIndex].setAttribute("selected", "true");
  }
}

if (vKey !== "") {
  const inputElement = document.getElementById("searchInput");
  inputElement.value = vKey;
}

// ค้นหาตามข้อความเมื่อกด Search
// document.getElementById('searchForm').addEventListener('submit', function(e) {
//     e.preventDefault();
//     const searchText = document.getElementById('searchInput').value.toLowerCase();
//     const cards = document.querySelectorAll('.product-card');

//     cards.forEach(card => {
//         const name = card.getAttribute('data-name').toLowerCase();
//         if (name.includes(searchText)) {
//             card.style.display = "flex";
//         } else {
//             card.style.display = "none";
//         }
//     });
// });
