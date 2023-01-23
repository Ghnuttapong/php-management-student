<?php
require_once("../connect.php");
try {

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['show_orderNew'])) {
      $object = new stdClass();
      $txt_search = isset($_POST['text_search_order']) ? $_POST['text_search_order'] : '';

      if ($txt_search != '') {
        $sql = "SELECT students.code AS std_code, students.fullname, orders.code AS order_code,  orders.id AS orders_id, orders.updated_at AS date_order, orders.product_state, orders.product_status, orders.house FROM students INNER JOIN orders ON orders.student_id = students.id WHERE   students.fullname LIKE '%$txt_search%' OR students.firstname LIKE '%$txt_search%' OR students.code LIKE '%$txt_search%' OR  orders.code LIKE '%$txt_search%' AND orders.product_state = 1  ORDER BY orders.updated_at DESC";
        $stmt = $obj->prepare($sql);
      } else {
        $sql = "SELECT students.code AS std_code, students.fullname, orders.code AS order_code,  orders.id AS orders_id, orders.updated_at AS date_order, orders.product_state, orders.product_status, orders.house FROM students INNER JOIN orders ON orders.student_id = students.id WHERE orders.product_state = 1 ORDER BY orders.updated_at DESC ";
        $stmt = $obj->prepare($sql);
      }

      if ($stmt->execute()) {
        $num = $stmt->rowCount();
        $object->count = $num;
        if ($num > 0) {
          $object->data = array();
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $data = $row;
            array_push($object->data, $data);
          }
          $object->RespCode = 200;
          $object->RespMessage = 'success';
          http_response_code(200);
        } else {
          $object->RespCode = 400;
          $object->Log = 0;
          $object->RespMessage = 'bad : Not found data';
          http_response_code(400);
        }
      } else {
        $object->RespCode = 500;
        $object->Log = 1;
        $object->RespMessage = 'bad : bad sql';
        http_response_code(400);
      }
      echo json_encode($object);
    }
    if (isset($_POST['orderSuccess'])) {
      $object = new stdClass();
      $txt_search = isset($_POST['search_order_success']) ? $_POST['search_order_success'] : '';

      if ($txt_search != '') {
        $sql = "SELECT students.code AS std_code, students.fullname, orders.code AS order_code,  orders.id AS orders_id, orders.updated_at AS date_order, orders.product_state, orders.product_status, orders.house FROM students INNER JOIN orders ON orders.student_id = students.id WHERE   students.fullname LIKE '%$txt_search%' OR students.firstname LIKE '%$txt_search%' OR students.code LIKE '%$txt_search%' OR  orders.code LIKE '%$txt_search%' AND orders.product_state = 2  ORDER BY orders.updated_at DESC";
        $stmt = $obj->prepare($sql);
      } else {
        $sql = "SELECT students.code AS std_code, students.fullname, orders.code AS order_code,  orders.id AS orders_id, orders.updated_at AS date_order, orders.product_state, orders.product_status, orders.house FROM students INNER JOIN orders ON orders.student_id = students.id WHERE orders.product_state = 2 ORDER BY orders.updated_at DESC ";
        $stmt = $obj->prepare($sql);
      }

      if ($stmt->execute()) {
        $num = $stmt->rowCount();
        $object->count = $num;
        if ($num > 0) {
          $object->data = array();
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $data = $row;
            array_push($object->data, $data);
          }
          $object->RespCode = 200;
          $object->RespMessage = 'success';
          http_response_code(200);
        } else {
          $object->RespCode = 400;
          $object->Log = 0;
          $object->RespMessage = 'bad : Not found data';
          http_response_code(400);
        }
      } else {
        $object->RespCode = 500;
        $object->Log = 1;
        $object->RespMessage = 'bad : bad sql';
        http_response_code(400);
      }
      echo json_encode($object);
    }
  }
} catch (PDOException $e) {
  http_response_code(500);
  echo "error";
}
