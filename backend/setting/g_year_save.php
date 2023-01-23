<?php 

    include '../function.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db; 
        $term = $_POST['term'];
        $year = $_POST['year'];
        $fullname = $term.'/'.$year;
        // checked old data
        $check = $conn->select_manual('models', ['year'], ['year'], [$fullname]);
        if(!empty($check)) {
            http_response_code(400);
            echo 'มีชั้นปีนี้อยู่ในระบบแล้ว';
            return;
        }
   
        $result = $conn->insert('models', ['year'], [$fullname]);
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
        }
        http_response_code(201);
        echo 'เพิ่มข้อมูลปีการศึกษาสำเร็จ';
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }
?>
