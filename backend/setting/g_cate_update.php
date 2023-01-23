<?php 

    include '../function.php';
    date_default_timezone_set("Asia/bangkok");
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db; 
        $type = $_POST['type'];
        $id = $_POST['id'];
   
        $result = $conn->update('category', ['name', 'user_id', 'updated_at'], [$type, $_SESSION['user_id'], date('Y-m-d H:i:s'), $id]);
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
        }
        http_response_code(201);
        echo 'อัพเดทข้อมูลประเภทสินค้าสำเร็จ';
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }
?>