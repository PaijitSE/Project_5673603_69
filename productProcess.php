<?php
session_start();
require_once('db.php');

// check send-data method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === '2') {
    $action = $_POST['action'] ?? '';
    $productId = trim($_POST['productId'] ?? '');
    $productName = trim($_POST['productName'] ?? '');
    $categoryCode = trim($_POST['categoryCode'] ?? '');
    $stockQty = trim($_POST['stockQty'] ?? '');
    $unitName = trim($_POST['unitName'] ?? '');
    $costPrice = trim($_POST['costPrice'] ?? '');
    $sellPrice = trim($_POST['sellPrice'] ?? '');
    $minQty = trim($_POST['minQty'] ?? '');
    $maxQty = trim($_POST['maxQty'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $statusSelect = trim($_POST['statusSelect'] ?? '');
    $imageOld = trim($_POST['imageOld'] ?? 'img/empty.jpg');

    //ตรวจสอบความถูกต้องของข้อมูล
    if ($action !== "delete") {
        if (empty($productId) || empty($productName) || empty($categoryCode) || empty($stockQty) || empty($unitName) || empty($costPrice) || empty($sellPrice)) {
            echo json_encode(["status" => "error", "message" => "❌ กรุณากรอกข้อมูลสำคัญให้ครบถ้วน!"]);
            exit();
        }
    }

    //จัดการอัปโหลดรูปภาพสินค้า
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['name'] !== "") {

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(["status" => "error", "message" => "ไฟล์มีปัญหา Code: " . $_FILES['image']['error']]);
            exit();
        }

        // 💡 เปลี่ยนโฟลเดอร์เก็บภาพเป็น uploads/admins/
        $upload_dir = 'img/Product/';
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                echo json_encode(["status" => "error", "message" => "❌ ไม่สามารถสร้างโฟลเดอร์ $upload_dir ได้!"]);
                exit();
            }
        }

        $file_info = pathinfo($_FILES["image"]["name"]);
        $file_ext = strtolower($file_info['extension']);
        $new_filename = "" . $productId . $file_ext;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo json_encode(["status" => "error", "message" => "❌ ระบบเซิร์ฟเวอร์ปฏิเสธการบันทึกไฟล์ (Permission Denied)"]);
            exit();
        }
    } else {
        $target_file = $imageOld;
    }

    //ตรวจสอบการจัดการข้อมูล
    if ($action === 'add') {
        $sql = "INSERT INTO product (Product_id, Product_name, Product_type, Product_count, Product_unit, Product_cost, Product_price, Product_low, Product_high, Product_detail, Product_status, Product_picture) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql2 = "INSERT INTO product (Product_id, Product_name, Product_type, Product_count, Product_unit, Product_cost, Product_price, Product_low, Product_high, Product_detail, Product_status, Product_picture) 
                VALUES ('$productId', '$productName', '$categoryCode', $stockQty, '$unitName', $costPrice, $sellPrice, $minQty, $maxQty, '$description', '$statusSelect', '$target_file')";
        $result = $conn->prepare($sql);
        $result->bind_param("sssisddiisss", $productId, $productName, $categoryCode, $stockQty, $unitName, $costPrice, $sellPrice, $minQty, $maxQty, $description, $statusSelect, $target_file);

        if ($result->execute()) {
            echo json_encode(["status" => "success", "message" => "1-เพิ่มสินค้าใหม่และรูปภาพสำเร็จ!" . $sql2]);
        } else {
            echo json_encode(["status" => "error", "message" => "1-เกิดข้อผิดพลาด เพิ่มสินค้าไม่สำเร็จ: " . $conn->error]);
        }
    } else if ($action === 'edit') {
        $sql = "UPDATE product SET Product_name=?, Product_type=?, Product_count=?, Product_unit=?, Product_cost=?, Product_price=?, Product_low=?, Product_high=?, Product_detail=?, Product_status=?, Product_picture=?   
                WHERE (Product_id = ?)";
        $result = $conn->prepare($sql);
        $result->bind_param("ssisddiissss", $productName, $categoryCode, $stockQty, $unitName, $costPrice, $sellPrice, $minQty, $maxQty, $description, $statusSelect, $target_file, $productId);

        if ($result->execute()) {
            echo json_encode(["status" => "success", "message" => "2-ปรับปรุงข้อมูลสินค้าสำเร็จ!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "2-เกิดข้อผิดพลาด ปรับปรุงไม่สำเร็จ : " . $conn->error]);
        }
    } else if ($action === 'delete') {
        $sql = "DELETE FROM product WHERE (Product_id = ?)";
        $result = $conn->prepare($sql);
        $result->bind_param("s", $productId);

        if ($result->execute()) {
            echo json_encode(["status" => "success", "message" => "3-ลบข้อมูลสินค้าสำเร็จ!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "3-เกิดข้อผิดพลาด Database: " . $conn->error]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "E-ไม่อนุญาตให้เข้าถึงระบบ"]);
}
