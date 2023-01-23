<?php
require_once("../connect.php");
date_default_timezone_set("Asia/Bangkok");
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['read_oneDay'])) {
    $date_oneday = date("Y-m-d");
    $total_income = 0;
    $count_orderday = 0;
    $sql_onedaty = "SELECT * FROM orders WHERE date_checkReport LIKE '%$date_oneday%' AND 	product_state = 2 ";
    $result_search_ondeday =  $obj->query($sql_onedaty);

    while ($row = $result_search_ondeday->fetch(PDO::FETCH_ASSOC)) {
      $count_orderday = $result_search_ondeday->rowCount();
      $total_income += $row['product_expenses'];
    }
    $text = "";
    $text .= "<div class='col-xl-6  fw-bold'><i class='ion ion-stats-bars pr-1 '></i> คำสั่งซื้อที่สำเร็จวันนี้</div>
    <div class='col-xl-6 mb-2'>วันที่ &nbsp;" .  date('d-m-Y') . "</div>
    <div class='col-xl-6 font-five'>รายได้ทั้งหมด</div>
    <div class='col-xl-6 mb-2 '> " . number_format($total_income, 2) . " <span> &nbsp;&nbsp;&nbsp; บาท </span> </div>
    <div class='col-xl-6 font-five'>ออเดอร์ที่สำเร็จ</div>
    <div class='col-xl-6 mb-2'>" . number_format($count_orderday) . " <span> &nbsp;&nbsp;&nbsp;ออเดอร์ </span></div>";
    echo $text;
  }


  if (isset($_GET['read_detail_All'])) {
    $date_now = date("Y-m-d");
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : false;
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : $date_now;

    $totalAll_income = 0;
    $count_orderAll = 0;
    $sql = $from_date && $to_date ? "SELECT * FROM orders WHERE product_state = 2 AND date_checkReport BETWEEN '$from_date' AND '$to_date'" : "SELECT * FROM orders WHERE product_state = 2 ";
    $result_all_success =  $obj->query($sql);

    while ($row = $result_all_success->fetch(PDO::FETCH_ASSOC)) {
      $count_orderAll = $result_all_success->rowCount();
      $totalAll_income += $row['product_expenses'];
    }

    $period = $from_date && $to_date  ?   date("d-m-Y", strtotime($from_date)) . " - " . date("d-m-Y", strtotime($to_date)) : "ทั้งหมด";
    $text = "";
    $text .= "<div class='col-xl-12 mb-2 fw-bold'><i class='ion ion-pie-graph pr-1 '></i> คำสั่งซื้อที่สำเร็จทั้งหมด</div>
    <div class='col-xl-6 font-five'>รายได้ทั้งหมด</div>
    <div class='col-xl-6 mb-2 '>" . number_format($totalAll_income, 2) . " <span> &nbsp;&nbsp;&nbsp;บาท</span></div>
    <div class='col-xl-6 font-five'>ออเดอร์ที่สำเร็จ</div>
    <div class='col-xl-6 mb-2'>" . number_format($count_orderAll) . " <span> &nbsp;&nbsp;&nbsp;ออเดอร์</span></div>
    <div class='col-xl-6 font-five'>ช่วงเวลา</div>
    <div class='col-xl-6 mb-2'>" . $period . "</div>";
    echo $text;
  }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['read_detail_all'])) {
    $date_now = date("Y-m-d");
    $from_date = isset($_POST['from_date']) ? $_POST['from_date'] : false;
    $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : $date_now;

    $totalAll_income = 0;
    $count_orderAll = 0;
    $sql = $from_date && $to_date ? "SELECT * FROM orders WHERE product_state = 2 AND date_checkReport BETWEEN '$from_date' AND '$to_date'" : "SELECT * FROM orders WHERE product_state = 2 ";
    $result_all_success =  $obj->query($sql);

    while ($row = $result_all_success->fetch(PDO::FETCH_ASSOC)) {
      $count_orderAll = $result_all_success->rowCount();
      $totalAll_income += $row['product_expenses'];
    }

    $period = $from_date && $to_date  ?   date("d-m-Y", strtotime($from_date)) . " - " . date("d-m-Y", strtotime($to_date)) : "ทั้งหมด";
    $text = "";
    $text .= "<div class='col-xl-12 mb-2 fw-bold'><i class='ion ion-pie-graph pr-1 '></i> คำสั่งซื้อที่สำเร็จทั้งหมด</div>
    <div class='col-xl-6 font-five'>รายได้ทั้งหมด</div>
    <div class='col-xl-6 mb-2 '>" . number_format($totalAll_income, 2) . " <span> &nbsp;&nbsp;&nbsp;บาท</span></div>
    <div class='col-xl-6 font-five'>ออเดอร์ที่สำเร็จ</div>
    <div class='col-xl-6 mb-2'>" . number_format($count_orderAll) . " <span> &nbsp;&nbsp;&nbsp;ออเดอร์</span></div>
    <div class='col-xl-6 font-five'>ช่วงเวลา</div>
    <div class='col-xl-6 mb-2'>" . $period . "</div>";
    echo $text;
  }

  if (isset($_POST['request_dashboard'])) {
    $object = new stdClass();
    $type_order = isset($_POST['select_type']) ? $_POST['select_type'] : "";

    if ($type_order == "" ||   $type_order == "ทั้งหมด") {
      $sql = "SELECT * FROM products  ORDER BY rating DESC LIMIT 10";
      $stmt = $obj->prepare($sql);
    } else {
      $sql =  "SELECT * FROM products WHERE category_id = :category_id ORDER BY rating DESC LIMIT 10";
      $stmt = $obj->prepare($sql);
      $stmt->bindParam(":category_id", $type_order);
    }

    if ($stmt->execute()) {
      $num = $stmt->rowCount();
      if ($num > 0) {

        $object->name = array();
        $object->rating = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $data = array(
            $name => $name,
            $rating => $rating,
          );
          array_push($object->name, $data[$name]);
          array_push($object->rating, $data[$rating]);
        }
        $object->RespCode = 200;
        $object->RespMessage = 'success';
        $object->type = $type_order;
        http_response_code(200);
      } else {
        $object->RespCode = 400;
        http_response_code(400);
      }

      echo json_encode($object);
    } else {
      http_response_code(400);
    }
  }
}
