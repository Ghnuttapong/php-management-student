<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['nodata']) == 1) {
    $ob = new stdClass();
    http_response_code(200);
    $ob->massage = 'กรุณาเข้าสู่ระบบก่อน';
    echo json_encode($ob);
  }
} else {
  http_response_code(500);
  echo 'Server Error';
}
