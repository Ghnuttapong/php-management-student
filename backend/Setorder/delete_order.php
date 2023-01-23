<?php

require_once 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    $conn = new crud;
    $id = $_POST['id'];
    $result = $conn->delete_order($id);
    http_response_code(200);
    echo 'ลบข้อมูลสำเร็จ';
  } catch (Exception $e) {
    http_response_code(500);
    echo 'ลบข้อมูลwไม่สำเร็จ';
  }
} else {
  echo 'Server Error';
  http_response_code(500);
}
