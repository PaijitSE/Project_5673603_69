document.addEventListener("DOMContentLoaded", () => {
  // Elements Reference
  const openModalBtn = document.getElementById("openModalBtn");
  const closeModalBtn = document.getElementById("closeModalBtn");
  const productModal = document.getElementById("productModal");
  const productForm = document.getElementById("productForm");
  const imageInput = document.getElementById("imageInput");
  const avatarPreview = document.getElementById("avatarPreview");
  const categorySelect = document.getElementById("categorySelect");

  const toggleModal = (show) => {
    if (show) {
      productModal.classList.remove("hidden");
    } else {
      productModal.classList.add("hidden");
      productForm.reset();
      avatarPreview.style.backgroundImage = "none";
    }
  };

  openModalBtn.addEventListener("click", () => {
    document.getElementById("m_action").value = "add";
    document.getElementById("modelTitle").innerText = "เพิ่มข้อมูลสินค้าใหม่";
    document.getElementById("manageModalBtn").innerText = "บันทึกข้อมูล";
    document.getElementById("productImg").src = "img/empty.jpg";

    document.getElementById("productId").value = "";
    document.getElementById("productName").value = "";
    document.getElementById("categoryCode").value = "";
    document.getElementById("stockQty").value = "";
    document.getElementById("unitName").value = "";
    document.getElementById("costPrice").value = "";
    document.getElementById("sellPrice").value = "";
    document.getElementById("minQty").value = "";
    document.getElementById("maxQty").value = "";
    document.getElementById("description").value = "Not specified";
    document.getElementById("statusSelect").value = "1";
    document.getElementById("imageOld").value = "img/empty.jpg";
    document.getElementById("productImg").src = "img/empty.jpg";

    toggleModal(true);
  });

  document.querySelectorAll(".btn-edit").forEach((button) => {
    button.addEventListener("click", function () {
      document.getElementById("m_action").value = "edit";
      document.getElementById("modelTitle").innerText = "แก้ไขข้อมูลสินค้า";
      document.getElementById("manageModalBtn").innerText = "ปรับปรุงข้อมูล";
      try {
        // 1. รับค่า JSON String จาก data-product แล้ว Parse แปลงเป็น JS Object
        const data = JSON.parse(this.dataset.product);
        document.getElementById("productId").value = data.Product_id;
        document.getElementById("productName").value = data.Product_name;
        document.getElementById("categoryCode").value = data.Product_type;
        document.getElementById("categorySelect").value = data.Product_type;
        document.getElementById("stockQty").value = data.Product_count;
        document.getElementById("unitName").value = data.Product_unit;
        document.getElementById("costPrice").value = data.Product_cost;
        document.getElementById("sellPrice").value = data.Product_price;
        document.getElementById("minQty").value = data.Product_low;
        document.getElementById("maxQty").value = data.Product_high;
        document.getElementById("description").value = data.Product_detail;
        document.getElementById("statusSelect").value = data.Product_status;
        document.getElementById("imageOld").value = data.Product_picture;
        document.getElementById("productImg").src =
          data.Product_picture || "img/empty.jpg";
        toggleModal(true);
      } catch (error) {
        console.error("การแปลงข้อมูล JSON ผิดพลาด:", error);
      }
    });
  });

  closeModalBtn.addEventListener("click", () => toggleModal(false));

  categorySelect.addEventListener("change", (e) => {
    document.getElementById("categoryCode").value = e.target.value;
  });

  // Handle Image Upload Preview
  imageInput.addEventListener("change", (input) => {
    if (input.files && input.files[0]) {
      const reader = new FileReader();

      document.getElementById("productImg").src = URL.createObjectURL(
        input.files[0],
      );

      reader.onload = (e) => {
        document.getElementById("imageInput").src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  });

  // Handle Form Submission
  productForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // ดึงค่าจากฟอร์มเพื่อนำไปประมวลผลต่อ (เช่น ส่ง API)
    // const formElement = document.getElementById("productForm");
    const formData = new FormData(productForm);
    const action = document.getElementById("m_action").value;

    // console.log(Object.fromEntries(formData));
    // alert("goto productProcess.php to=" + action);

    fetch("productProcess.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          alert(data.message);
          toggleModal(false);
          window.location.reload();
        } else {
          console.log(data.message);
          alert("ข้อผิดพลาด: " + data.message);
          console.log(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์!");
      });
  });
});

function deleteData(productId) {
  if (confirm("ยืนยันการลบรายการสินค้า รหัส " + productId + " ?")) {
    const formData = new FormData();
    formData.append("action", "delete");
    formData.append("productId", productId);

    // console.log(Object.fromEntries(formData));
    // alert("goto productProcess.php to=delete");

    fetch("productProcess.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          alert(data.message);
          window.location.reload();
        } else {
          alert("ข้อผิดพลาด: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์!");
      });
  }
}
