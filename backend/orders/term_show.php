<?php 
    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $conn = new db;

        $result = $conn->select_manaul_field('order_finance', ['*']);

        echo json_encode($result);
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }

?>