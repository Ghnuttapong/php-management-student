<?php 

    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;
        $id = $_POST['id'];
        $result = $conn->select_belong('products', 'users', 'products.* , users.fullname', 'products.user_id = users.id', ['products.id'] , [$id] );
        http_response_code(200);
        echo json_encode($result); 
    } else {
        http_response_code(405);
        echo json_encode('Method not allowed');
    }
