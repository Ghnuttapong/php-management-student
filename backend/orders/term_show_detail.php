<?php 

    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;
        $student_id = $_POST['student_id'];

        $result = $conn->select_belong('order_finance', 'students', 
        'students.* ,
        order_finance.*, order_finance.u_fullname as user_fullname',
        'order_finance.std_id = students.id', 
        ['order_finance.std_id'],
        [$student_id]);

        array_pop($result);

        echo json_encode($result);
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }

?>