<?php

include '../function.php';
date_default_timezone_set("Asia/bangkok");
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new db;

    $id = $_POST['id'];
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
    $status = $_POST['status'];
    $note = $_POST['note'];


    $user_fullname = $_SESSION['user_fullname'];
    $result = $conn->update(
        'students',
        ['code', 'prefix', 'firstname', 'lastname', 'fullname', 'nickname', 'class', 'year', 'p_prefix', 'p_firstname', 'p_lastname', 'p_fullname', 'p_relative', 'phone', 'address', 'status', 'note', 'user_fullname', 'updated_at'],
        [$code, $prefix, $firstname, $lastname, $prefix . $firstname . ' ' . $lastname, $nickname, $class,  $year, $p_prefix, $p_firstname, $p_lastname, $p_prefix . $p_firstname . ' ' . $p_lastname, $p_relative, $phone, $address, $status, $note, $user_fullname, date('Y-m-d H:i:s'), $id]
    );

    $result = $conn->select_manual('order_finance', ['*'], ['std_id'], [$id]);


    echo 'อัพเดทสำเร็จ';
    http_response_code(201);
} else {
    http_response_code(405);
    echo json_encode('Method not allowed');
}
