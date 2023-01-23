<?php 

    include '../function.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db; 
        $id = $_POST['id'];
   
        $result = $conn->deletebyid('models', $id);
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
        }
        http_response_code(201);
        echo 'ลบข้อมูลสำเร็จ';
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }
?>