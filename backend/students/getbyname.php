<?php

    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;

        $keyword = $_POST['keyword'];
        
        $result = $conn->search_data('students LEFT JOIN order_finance ON order_finance.std_id = students.id', ['*', 'order_finance.status'], ['students.fullname'], [$keyword]);
        http_response_code(200);
        echo json_encode($result);
    } else {
        http_response_code(405);
        echo 'Method not allowed';
    }


?>