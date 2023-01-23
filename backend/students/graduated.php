<?php

include '../function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new db;
    $year = $_POST['year'];
    $class = $_POST['class'];

    $expenses = $conn->select_manual('finances', ['*'], ['year', 'class'], [$year, $class]);
    if (empty($expenses)) {
        http_response_code(400);
        echo 'ไม่พบรายการเทอมนี้';
        return;
    }

    $std = $conn->select_manual('students', ['*'], ['status'], [1]);
    if (empty($std)) {
        http_response_code(400);
        echo 'ไม่สามารถเปลี่ยนสถานะได้❗❗ กรุณาตรวจสอบข้อมูลนักศึกษาอีกครั้ง';
        return;
    } else {
        $status = 3;
        $result = $conn->update_where('students', ['status'], [$status, $year, $class], 'year = ? AND class');

        if ($result == false) {
            echo 'Server Error';
            http_response_code(500);
            return;
        }
        http_response_code(201);
        echo 'เปลี่ยนสถานะการศึกษาสำเร็จ';
    }
} else {
    http_response_code(405);
    echo 'Method not Allowed';
}
