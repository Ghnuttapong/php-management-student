<?php
include '../function.php';
date_default_timezone_set("Asia/bangkok");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new db;
    $id = $_POST['student_id'];
    $user_fullname = $_SESSION['user_fullname'];

    $state = 4;
    $status = 3;
    $result = $conn->update('order_finance', ['state', 'status'], [$state, $status, $id]);
    $result = $conn->update('students', ['status', 'user_fullname', 'updated_at'], [2, $user_fullname, date('Y-m-d H:i:s'), $id]);
    if ($result == false) {
        echo 'Server Error';
        http_response_code(500);
        return;
    }

    http_response_code(201);
    echo 'ปิดบัญชีรายชื่อนี้สำเร็จ';
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
