<?php
session_start();
require_once("../connect.php");
require_once("function.php");
try {
  $conn = new crud;
  date_default_timezone_set("Asia/Bangkok");
  $id = isset($_POST['id_order']) ? $_POST['id_order'] : '';
  $pay_money = isset($_POST['pay_money']) ? $_POST['pay_money'] : 0;
  $pay_money = (int)$pay_money;
  $result = $conn->select_order_detail($id);

  $ckeck_pay = $result['product_expenses'] >= $result['product_pay'] + $pay_money ? true : false;
  if ($ckeck_pay) {
    $product_pay =  $result['product_pay'] + $pay_money;
    $product_status = isset($_POST['status_pay']) ? $_POST['status_pay'] : false;
    $user_fullname = $_SESSION['user_fullname'];
    $date_checkReport = date("Y-m-d");
    $house = date("H:i:s");

    try {
      $sql = "UPDATE orders SET  product_status = :product_status, product_pay = :product_pay,  user_fullname = :user_fullname, date_checkReport = :date_checkReport, house = :house WHERE id = :id";
      $result = $obj->prepare($sql);
      $result->execute([
        'product_status' => $product_status,
        'product_pay' => $product_pay,
        'user_fullname' => $user_fullname,
        'date_checkReport' => $date_checkReport,
        'house' => $house,
        'id' => $id
      ]);

      if ($result) {
        echo "เเก้ไขรายการสำเร็จ";
      }
    } catch (PDOException $e) {
      echo "เเก้ไขรายการไม่สำเร็จ";
    }
  } else {
    echo "เเก้ไขรายการไม่สำเร็จ เนื่องจากข้อมูลไม่ถูกต้อง กรุณากรอกข้อมูลใหม่";
  }
} catch (PDOException $e) {
  echo "NO connect data";
}
