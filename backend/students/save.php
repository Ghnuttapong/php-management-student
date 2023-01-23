<?php
session_start();
include '../function.php';
$conn = new db;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $prefix = $_POST['prefix'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $nickname = $_POST['nickname'];
    $class = $_POST['class'];
    $year = $_POST['year'];
    $p_prefix = $_POST['p_prefix'];
    $p_firstname = $_POST['p_firstname'];
    $p_lastname = $_POST['p_lastname'];
    $p_relative = $_POST['p_relative'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if (!isset($_POST['product_id'])) {
        http_response_code(400);
        echo 'โปรดเลือกรายการค่าใช้จ่าย';
        return;
    }

    $product_id = $_POST['product_id'];

    $user_fullname = $_SESSION['user_fullname'];


    // check already exists
    $result = $conn->select_count_where('students', ['code'], [$code]);
    if ($result > 0) {
        http_response_code(400);
        echo 'รหัสนักเรียนนี้มีอยู่ในระบบแล้ว';
        return;
    }

    // เก็บค่าเทอม
    $expenses = $conn->select_manual('finances', ['*'], ['year', 'class'], [$year, $class]);
    if (empty($expenses)) {
        http_response_code(400);
        echo 'ไม่พบรายการจ่ายค่าเทอมนี้';
        return;
    }

    // status
    $status = 1;

    // create students
    $result = $conn->insert(
        'students',
        ['code', 'prefix', 'firstname', 'lastname', 'nickname', 'fullname', 'class',  'year', 'status', 'p_prefix', 'p_firstname', 'p_lastname', 'p_fullname', 'p_relative', 'phone', 'address', 'user_fullname'],
        [$code, $prefix, $firstname, $lastname, $nickname, $prefix . $firstname . ' ' . $lastname, $class, $year, $status, $p_prefix, $p_firstname, $p_lastname, $p_prefix . $p_firstname . ' ' . $p_lastname, $p_relative, $phone, $address, $user_fullname]
    );
    if (!$result) {
        http_response_code(500);
        echo 'Server Error';
        return;
    }

    // genarate order code
    $order_code = $conn->generate_code_order();

    // find product cost.
    $count_product = count($product_id);
    $p_expenses = 0;
    for ($i = 0; $i < $count_product; $i++) {
        $price = $conn->select_manual('products', ['price'], ['id'], [$product_id[$i]]);
        $p_expenses +=  $price['price'];
    }


    // create finance orders 
    $result = $conn->select_manual('students', ['*'], ['code'], [$code]);
    $std_id = $result['id'];

    $array_p_id = array();
    foreach ($product_id as $val) {
        $result = $conn->select_manual('products', ['*'], ['id'], [$val]);
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
        array_push($array_p_id, $items);
    }
    $encode_product = json_encode($array_p_id);

    $result = $conn->insert(
        'order_finance',
        ['std_id', 'order_code', 'expenses', 'p_id', 'p_expenses', 'u_fullname'],
        [$std_id, $order_code, $expenses['term_fees'], $encode_product, $p_expenses, $user_fullname,]
    );
    if (!$result) {
        http_response_code(500);
        echo 'Server Error';
        return;
    }
    http_response_code(201);
    echo 'เพิ่มข้อมูลนักเรียนสำเร็จ';
} else {
    http_response_code(405);
    echo json_encode('Method not allowed');
}
