<?php 

    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;
        $id = $_POST['id'];
        $result = $conn->select_belong('students', 'order_finance', 
        'students.*, order_finance.status as f_status, order_finance.pay as f_pay, order_finance.expenses as f_expenses'
        , 'order_finance.std_id = students.id', ['order_finance.std_id'] , [$id] );

        http_response_code(200);
        echo json_encode($result); 
    } else {
        http_response_code(405);
        echo json_encode('Method not allowed');
    }


?>