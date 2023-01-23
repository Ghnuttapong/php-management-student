<?php
session_start();
require_once("../connect.php");
try {
  date_default_timezone_set("Asia/Bangkok");
  $numrandom = (rand(100, 1000));
  $array = $_SESSION['data'];


  $count  = count($array) > 0  ?  count($array) : 0;
  $_SESSION["count_order"] = $count;
  usort($_SESSION['data'], function ($a, $b) {
    return $a['id'] - $b['id'];
  });

  $code = date("His") . $numrandom;
  $student_id = isset($_POST['std_id']) ? $_POST['std_id'] : false;
  $list = isset($_SESSION['send_order']) ? $_SESSION['send_order'] : false;
  $listAll = isset($_SESSION['data']) ? $_SESSION['data'] : false;
  $count_order = isset($_SESSION["count_order"]) ? $_SESSION["count_order"] : 0;
  $priceAll = $_SESSION['total'];
  $user_fullname = $_SESSION['user_fullname'];
  $date_checkReport = date("Y-m-d");

  $list_order =  json_encode($list);
  $listAll_order =  json_encode($listAll);

  if (count($array) > 0) {
    try {
      $sql = "INSERT INTO orders(code,  student_id, list_order, listAll_order, count_order, product_expenses, user_fullname, date_checkReport) VALUES(:code,  :student_id, :list_order, :listAll_order, :count_order, :product_expenses, :user_fullname, :date_checkReport)";
      $result = $obj->prepare($sql);
      $result->execute([
        'code' => $code,
        'student_id' => $student_id,
        'list_order' => $list_order,
        'listAll_order' => $listAll_order,
        'count_order' => $count_order,
        'product_expenses' => $priceAll,
        'user_fullname' => $user_fullname,
        'date_checkReport' => $date_checkReport
      ]);

      if ($result) {
        echo "เพิ่มรายการสำเร็จ";
      }
    } catch (PDOException $e) {
      // echo "ไม่สามรถเพิ่มรายการสำเร็จ";
      echo $e->getMessage();
    }
  }
} catch (PDOException $e) {
  echo "NO connect data";
}
