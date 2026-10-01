<?php
//Module การค้นหาและแสดงสินค้า

$Invid = isset($_GET['inv_id']) ? $_GET['inv_id'] : "";


$invoiceDetail = "SELECT A.*, B.Product_name FROM invoice_detail A INNER JOIN product B ON (A.Product_id = B.Product_id) WHERE 1";

if (!empty($Invid)) {
    $invoiceDetail .= " AND (Inv_no = '$Invid')";
}

$resultInvoiceDetail =  mysqli_query($conn, $invoiceDetail);
