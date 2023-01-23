<?php

    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;

        $id = $_POST['id'];

        
        $result = $conn->select_manual('models', ['year'], ['id'], [$id]);
        http_response_code(200);
        echo json_encode($result);
    } else {
        http_response_code(405);
        echo 'Method not allowed';
    }


?>