<?php

    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;

        $class = $_POST['class'];
        $std_arr = $conn->search_data('students INNER JOIN order_finance ON order_finance.std_id = students.id', ['students.*', 'order_finance.state as f_state'], ['students.class'], [$class]);
        http_response_code(200);
        echo json_encode($std_arr);
    } else {
        http_response_code(405);
        echo 'Method not allowed';
    }


?>