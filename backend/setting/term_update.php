<?php

include '../function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new db;

    $id = $_POST['id'];
    // if have new products
    if (isset($_POST['product_list'])) {
        $product_list = $_POST['product_list'];

        $json_encode_product = json_encode($product_list);

        // find expenses 
        $finance_expenses = 0;
        $count_product_list = count($product_list);
        for ($i = 0; $i < $count_product_list; $i++) {
            $find_detail_finance = $conn->select_manual('products', ['*'], ['id'], [$product_list[$i]]);
            $finance_expenses += $find_detail_finance['price'];
        }

        $result = $conn->update_where('finances', ['product_list', 'product_expenses'], [$json_encode_product, $finance_expenses, $id], 'id');
    } else {
        // update finance term
        // $year = $_POST['year'];
        // $class = $_POST['class'];
        $term_fees = $_POST['term_fees'];

        $result = $conn->update_where('finances', ['term_fees'], [$term_fees, $id], 'id');
    }

    if ($result == false) {
        http_response_code(500);
        echo 'Server Error';
    }

    http_response_code(201);
    echo 'อัพเดทข้อมูลค่าเทอมสำเร็จ';
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
