<?php
include '../function.php';

session_start();
$conn = new db;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['p_id'])) {
        http_response_code(400);
        echo 'กรุณาเลือกสินค้า';
        return;
    }
    $p_id = $_POST['p_id'];
    $order_code = $_POST['order_code'];
    $result = $conn->select_manual('order_finance', ['p_id'], ['order_code'], [$order_code]);
    $old_cart = json_decode($result['p_id'], true);
    foreach ($p_id as $value) {
        $find_product = $conn->select_manual('products', ['*'], ['id'], [$value]);
        $items = array(
            "id" => $find_product['id'],
            "code" => $find_product['code'],
            "name" => $find_product['name'],
            "detail" => $find_product['detail'],
            "type" => $find_product['category_id'],
            "price" => $find_product['price'],
            "pay" => 0,
            "balance" => $find_product['price'],
            "status" => 0,
        );
        array_push($old_cart, $items);
    }






    $new_pay = 0;
    $new_expenses = 0;
    foreach ($old_cart as $value) {
        $new_pay  += $value['pay'];
        $new_expenses += $value['price'];
    }


    $std_arr = $conn->select_manual('order_finance', ['*'], ['order_code'], [$order_code]);


    $allcost =  $std_arr['expenses'] + $std_arr['p_expenses'] + $new_expenses;
    $all_pay =  $std_arr['pay'] + $std_arr['p_pay'] + $new_pay;

    if ($allcost > 0 && $allcost > $all_pay) {
        $order_code_ud = $std_arr['order_code'];
        $state_order = 2;
        $status_order = 1;
        $update_payment = $conn->update_where('order_finance', ['status', 'state'], [$status_order, $state_order, $order_code_ud], 'order_code');
    }



    $encode_p_id  = json_encode($old_cart);
    $result = $conn->update_where('order_finance', ['p_id', 'p_pay', 'p_expenses'], [$encode_p_id, $new_pay, $new_expenses, $order_code], 'order_code');
    if ($result) {
        echo 'เพิ่มรายการสำเร็จ';
        http_response_code(200);
        return;
    }
    echo 'กรุณาติดต่อเจ้าหน้าที่';
    http_response_code(500);
} else {
    http_response_code(405);
    echo json_encode('Method not allowed');
}
