<?php 
    session_start();
    include '../function.php';
    $conn = new db; 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $code = $_POST['code'];
        $name = $_POST['name'];
        $detail = $_POST['detail'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];

        $result = $conn->select_count_where('products', ['code', 'category_id'], [$code, $category_id]);
        if($result > 0) {
            http_response_code(400);
            echo 'มีรหัสสินค้าของประเภทนี้แล้ว';
            return;
        }

        $result = $conn->insert('products', ['code', 'name', 'detail', 'price', 'category_id', 'user_id'], 
                                [$code, $name, $detail == ''? null: $detail, $price, $category_id, $_SESSION['user_id']]);
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
            return;
        }
        http_response_code(201);
        echo 'เพิ่มข้อมูลสินค้าสำเร็จ';
    }else {
        http_response_code(405);
        echo json_encode('Method not allowed');
    }
?>