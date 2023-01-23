<?php
session_start();
include '../function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new db;
    $object  = new stdClass();
    // required username 
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $result = $conn->select_count_where('users', ['username', 'password'], [$username, $password]);
    if ($result == 0) {
        http_response_code(400);
        // $object->RespMessage = 'No username';
        echo 'ไม่พบชื่อผู้ใช้งานชื่อ ' . $username;
        return;
    }

    $result = $conn->select_manual('users', ['*'], ['username', 'password'], [$username, $password]);
    $_SESSION['user_id'] = $result['id'];
    $_SESSION['user_firstname'] = $result['firstname'];
    $_SESSION['user_fullname'] = $result['fullname'];
    $_SESSION['user_role'] = $result['role'];
    http_response_code(200);
    echo 'ยินดีต้อนรับเข้าสู่ระบบ';
    // $object->RespMessage = 'ยินดีต้อนรับเข้าสู่ระบบ';
    // echo json_encode($object);
} else {
    http_response_code(500);
    echo 'Server Error';
    // $object->RespMessage = 'Server Error';
    // echo json_encode($object);
}
