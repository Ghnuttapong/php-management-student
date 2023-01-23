<?php 

    include '../function.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db; 
        $id = $_POST['id'];
        $class = $_POST['class'];
        $class_year = $_POST['class_year'];
        $class_room = $_POST['class_room'];

        $result = $conn->update('models', ['class', 'class_year', 'class_room'], [$class, $class_year, $class_room, $id]);
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
        }
        http_response_code(201);
        echo 'อัพเดทข้อมูลระดับชั้นสำเร็จ';
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }
?>