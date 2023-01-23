<?php

include '../function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new db;
    $id = $_POST['id'];
    $result = $conn->deletebyid('products', $id);
    if ($result == false) {
        echo 'Server Error';
        http_response_code(500);
        return;
    }
    http_response_code(200);
    echo 'ลบข้อมูลสำเร็จ';
} else {
    echo 'Server Error';
    http_response_code(500);
}
