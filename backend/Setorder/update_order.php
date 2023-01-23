<?php
session_start();
require_once("../connect.php");
try {
  date_default_timezone_set("Asia/Bangkok");
  $array = $_SESSION['update_orderAll'];
  $id = isset($_POST['id_order']) ? $_POST['id_order'] : '';


  $list = isset($_SESSION['update_order']) ? $_SESSION['update_order'] : false;
  $listAll = isset($_SESSION['update_orderAll']) ? $_SESSION['update_orderAll'] : false;
  $count_order = isset($_SESSION["total_order_success"]) ? $_SESSION["total_order_success"] : 0;
  $product_expenses = $_SESSION['total_price'];
  $user_fullname = $_SESSION['user_fullname'];
  $date_checkReport = date("Y-m-d");
  $house = date("H:i:s");

  $list_order =  json_encode($list);
  $listAll_order =  json_encode($listAll);

  if (count($array) > 0) {
    try {
      $sql = "UPDATE orders SET  list_order = :list_order, listAll_order = :listAll_order, count_order = :count_order, product_expenses = :product_expenses, user_fullname = :user_fullname, date_checkReport = :date_checkReport, house = :house WHERE id = :id";
      $result = $obj->prepare($sql);
      $result->execute([
        'list_order' => $list_order,
        'listAll_order' => $listAll_order,
        'count_order' => $count_order,
        'product_expenses' => $product_expenses,
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
  }
} catch (PDOException $e) {
  echo "NO connect data";
}
