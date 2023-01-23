<?php 

    session_start();
    include '../function.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db; 
        $type = $_POST['type'];
        // checked old data
        $check = $conn->select_manual('category', ['name'], ['name'], [$type]);
        if(!empty($check)) {
            http_response_code(400);
            echo 'มีประเภทสินค้านี้อยู่ในระบบแล้ว';
            return;
        }
   
        $result = $conn->insert('category', ['name', 'user_id'], [$type, $_SESSION['user_id']]);
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
        }
        http_response_code(201);
        echo 'เพิ่มข้อมูลประเภทสินค้าสำเร็จ';
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }
?>
