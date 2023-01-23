<?php 

    include '../function.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db; 
        $year = $_POST['year'];
        $id = $_POST['id'];
   
        $result = $conn->update('models', ['year'], [$year, $id] );
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
        }
        http_response_code(201);
        echo 'อัพเดทข้อมูลชั้นสำเร็จ';
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }
?>