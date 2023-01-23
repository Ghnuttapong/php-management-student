<?php
session_start();
include '../function.php';
date_default_timezone_set("Asia/bangkok");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_pay = $_POST['product_pay'];
    $order_code =  $_POST['order_code'];
    $std_id = $_POST['id'];
    $user_fullname = $_SESSION['user_fullname'];

    // new class
    $conn = new db;

    // new payment
    $result = $conn->select_manual('order_finance', ['*'], ['order_code'], [$order_code]);
    $dc_p_id = json_decode($result['p_id']);
    $table_p_id = json_decode(json_encode($dc_p_id), true);
    $count_product_pay = count($product_pay);
    $pay = 0;

    // logic pay
    for ($i = 0; $i < $count_product_pay; $i++) {
        $product_pay[$i] == '' ? $product_pay[$i] = 0 : $product_pay[$i];

        // check overpay
        $check_pay = $product_pay[$i] + $table_p_id[$i]['pay'];
        if ($check_pay >= $table_p_id[$i]['price']) {
            $product_pay[$i] = $table_p_id[$i]['balance'];
        }

        // update state
        $table_p_id[$i]['pay'] += $product_pay[$i];
        $table_p_id[$i]['balance'] = $table_p_id[$i]['price'] - $table_p_id[$i]['pay'];
        if ($table_p_id[$i]['pay'] == $table_p_id[$i]['price']) {
            $table_p_id[$i]['status'] = 1;
        }

        // get all pay
        $pay += $table_p_id[$i]['pay'];
    }
    // save data
    $ec_p_id = json_encode($table_p_id);
    $status = 1;
    $update_payment = $conn->update_where('order_finance', ['p_id', 'p_pay', 'status'], [$ec_p_id, $pay, $status, $order_code], 'order_code');
    if (!$update_payment) {
        echo 'Server Eror';
        http_response_code(500);
        return;
    }

    $update_std =  $conn->update(
        'students',
        ['user_fullname', 'updated_at'],
        [$user_fullname, date('Y-m-d H:i:s'), $std_id]
    );


    // check success order
    $result = $conn->select_manual('order_finance', ['*'], ['order_code'], [$order_code]);
    if ($result['pay'] == $result['expenses'] && $result['p_expenses'] == $result['p_pay']) {
        $state = 3;
        $status = 2;
        $pay = $conn->update_where('order_finance', ['status', 'state'], [$status, $state, $order_code], 'order_code');
    }

    if ($pay) {
        echo 'อัพเดทการทำรายการเรียบร้อยแล้ว';
        http_response_code(200);
        return;
    }

    echo 'Server Error';
    http_response_code(500);
} else {
    http_response_code(403);
    echo 'Method not allowed';
}
