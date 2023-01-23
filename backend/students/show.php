<?php

include '../function.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $conn = new db;
    $std_arr = $conn->select_join('order_finance', 'students', ['students.*', 'order_finance.status as f_status'], 'order_finance.std_id = students.id');
    http_response_code(200);
    echo json_encode($result);
} else {
    http_response_code(405);
    echo json_encode('Method not allowed');
}
