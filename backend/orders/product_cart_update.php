<?php

include '../function.php';
date_default_timezone_set("Asia/bangkok");
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new db;
    $order_code = $_POST['order_code'];
    if(!isset($_POST['p_id']) && empty($_POST['p_id'])) {
        echo 'กรุณาเลือกสินค้า';
        http_response_code(400);
        return;
    }
    $user_fullname = $_SESSION['user_fullname'];

    // find product cost.
    $p_id = $_POST['p_id'];
    $product_list = array();
    $count_product = count($p_id);
    $p_expenses = 0;
    for ($i = 0; $i < $count_product; $i++) {
        $result = $conn->select_manual('products', ['*'], ['id'], [$p_id[$i]]);
        extract($result);
        $items = array(
            "id" => $id,
            "code" => $code,
            "name" => $name,
            "detail" => $detail,
            "type" => $category_id,
            "price" => $price,
            "pay" => 0,
            "balance" => $price,
            "status" => 0,
        );
        $p_expenses +=  $price;
        array_push($product_list, $items);
    }

    // update finance orders 
    $encode_product = json_encode($product_list);
    $pay = 0;
    $result = $conn->update_where('order_finance', ['p_id', 'p_expenses', 'u_fullname', 'p_pay', 'updated_at'], [$encode_product, $p_expenses, $user_fullname, $pay, date('Y-m-d H:i:s'), $order_code ], 'order_code'  );
    if(!$result) {
        echo 'มีบางอย่างผิดพลาดโปรดติดต่อเจ้าหน้าที่';
        http_response_code(500);
        return;
    }
    echo 'อัพเดทสำเร็จ';
    http_response_code(200);
} else {
    http_response_code(405);
    echo json_encode('Method not allowed');
}



?>