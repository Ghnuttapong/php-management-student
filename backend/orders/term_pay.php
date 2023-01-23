<?php

include '../function.php';
date_default_timezone_set("Asia/bangkok");
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new db;
    $order_code = $_POST['order_code'];
    $std_id = $_POST['id'];
    $pay = $_POST['pay'];

    $result = $conn->select_manual('order_finance', ['*'], ['order_code'], [$order_code]);
    $costAll =  $result['expenses'];

    // check overpay
    $reduce = 0;
    if ($pay + $result['pay'] > $costAll) {
        $pay += $result['pay'];
        $reduce = $pay - $costAll;
        $pay = $costAll;
    } else {
        $pay += $result['pay'];
    }


    $status = 1;
    $user_fullname = $_SESSION['user_fullname'];
    $pay = $conn->update_where('order_finance', ['pay', 'u_fullname', 'updated_at', 'status'], [$pay, $_SESSION['user_fullname'], date('Y-m-d H:i:s'), $status, $order_code], 'order_code');
    $update_std =  $conn->update(
        'students',
        ['user_fullname', 'updated_at'],
        [$user_fullname, date('Y-m-d H:i:s'), $std_id]
    );

    // check success order
    if ($result['pay'] == $result['expenses'] && $result['p_expenses'] == $result['p_pay']) {
        $state = 3;
        $status = 2;
        $pay = $conn->update_where('order_finance', ['status', 'state'], [$status, $state, $order_code], 'order_code');
    }

    if ($pay && $update_std) {
        http_response_code(200);
        echo json_encode(['msg' => 'อัพเดทการทำรายการเรียบร้อยแล้ว', 'reduce' => $reduce > 0 ? 'เงินทอน ' . $reduce . ' บาท' : '']);
        return;
    }
    http_response_code(500);
    echo 'Server Error';
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
