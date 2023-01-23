<?php
session_start();
require_once("../connect.php");
require_once("function.php");
try {
  $conn = new crud;
  date_default_timezone_set("Asia/Bangkok");
  $id = isset($_GET['id']) ? $_GET['id'] : '';
  $keep_rating = count($_SESSION['orderAll']);

  for ($i = 0; $i <  $keep_rating; $i++) {
    $conn->update_rating($_SESSION['orderAll'][$i]['id']);
  }


  $product_state = 2;
  $user_fullname = $_SESSION['user_fullname'];
  $date_checkReport = date("Y-m-d");
  $house = date("H:i:s");

  $sql = "UPDATE orders SET  product_state = :product_state, user_fullname = :user_fullname, date_checkReport = :date_checkReport, house = :house WHERE id = :id";
  $result = $obj->prepare($sql);
  $result->execute([
    'product_state' => $product_state,
    'user_fullname' => $user_fullname,
    'date_checkReport' => $date_checkReport,
    'house' => $house,
    'id' => $id
  ]);

  if ($result) {
    // echo "เเก้ไขรายการสำเร็จ";
    echo "<script>location.assign('../../project/management_cost_productNew.php?id=" . $id . "');</script>";
  }
} catch (PDOException $e) {
  // echo $e->getMessage();
  // echo "NO connect data";
  echo "<script>location.assign('../../project/management_cost_productNew.php?id=" . $id . "');</script>";
}
