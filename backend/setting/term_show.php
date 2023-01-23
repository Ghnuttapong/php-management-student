<?php
    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;

        $result = $conn->select_manaul_field('finances', ['*']);
        http_response_code(200);
        echo json_encode($result);
    } else {
        http_response_code(405);
        echo 'Method not allowed';
    }


?>