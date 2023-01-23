<?php 

    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $conn = new db;

        $result = $conn->select_count_table('students');
        echo $result;
    }else {
        http_response_code(405);
        echo 'Method not allowed';
    }
