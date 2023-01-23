<?php
session_start();
include '../function.php';
date_default_timezone_set("Asia/bangkok");
$conn = new db;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $category_id = $_POST['category_id'];

    $result = $conn->update(
        'products',
        ['code', 'name', 'detail', 'price', 'category_id', 'status', 'user_id', 'updated_at'],
        [$code, $name, $detail == '' ? null : $detail, $price, $category_id, $status, $_SESSION['user_id'], date('Y-m-d H:i:s'), $id]
    );
    if ($result == false) {
        http_response_code(500);
        echo 'Server Error';
        return;
    }
    http_response_code(201);
    echo 'อัพเดทข้อมูลสินค้าสำเร็จ';
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
