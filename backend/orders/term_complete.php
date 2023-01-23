<?php


    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;

        $student_id = $_POST['student_id'];

        $update_pay = $conn->update('order_finance', ['state'], [ 3 , $student_id]);
        if($update_pay == false) {
            http_response_code(500);
            echo 'Server Error';
            return ;
        }

        http_response_code(200);
        echo 'อัพเดทการจ่ายเงินเรียบร้อยแล้ว';

    } else {
        http_response_code(405);
        echo 'Method not allowed';
    }

?>