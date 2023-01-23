<?php

include '../function.php';
session_start();
date_default_timezone_set("Asia/bangkok");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new db;
    $id = $_POST['student_id'];

    $state = 2;
    $user_fullname = $_SESSION['user_fullname'];
    $conn->update(
        'students',
        ['user_fullname', 'updated_at'],
        [$user_fullname, date('Y-m-d H:i:s'), $id]
    );
    $result = $conn->update('order_finance', ['state'], [$state, $id]);
    if ($result == false) {
        echo 'Server Error';
        http_response_code(500);
        return;
    }

    http_response_code(200);
    echo 'ยืนยันค่าใช้จ่าย';
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
