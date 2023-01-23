<?php 

    include '../function.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db; 
        $class = $_POST['class'];
        $year = $_POST['year'];
        $room = $_POST['room'];
   
        // checked old data
        $check = $conn->select_manual('models', ['class'], ['class', 'class_year', 'class_room'], [$class, $year, $room]);
        if(!empty($check)) {
            http_response_code(400);
            echo 'มีชั้นปีนี้อยู่ในระบบแล้ว';
            return;
        }

        $result = $conn->insert('models', ['class', 'class_year', 'class_room'], [$class, $year, $room]);
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
        }
        http_response_code(201);
        echo 'เพิ่มข้อมูลระดับชั้นสำเร็จ';
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }
?>
