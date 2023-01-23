<?php
session_start();
require_once("../connect.php");

try {
  $_SESSION['data'];
  if ($_SESSION['data'] == null) {
    $_SESSION['data'] =  $_SESSION['data'][] = [];
  } else {
    $_SESSION['data'] = $_SESSION['data'];

    $array = $_SESSION['data'];
    $count  = count($array) > 0  ?  count($array) : 0;
    $_SESSION["count_order"] = $count;
  }
  $mid = isset($_POST['id']) ? $_POST['id'] : 0;
  try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $sql = "SELECT * FROM products WHERE id = :id";
      $stmt = $obj->prepare($sql);
      $stmt->bindParam(':id', $mid);
      if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $items = array(
              "id" => $id,
              "code" => $code,
              "name" => $name,
              "detail" => $detail,
              "type" => $category_id,
              "rating" => 1,
              "price" => $price,
              "priceAll" => $price * 1,
            );
            $_SESSION['array'] = $items;
            array_push($_SESSION['data'], $_SESSION['array']);
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

        echo json_encode($object);
      } else {
        $object->RespCode = 500;
        $object->Log = 1;
        $object->RespMessage = 'bad : bad sql';
        http_response_code(400);
      }
    } else {
      http_response_code(405);
    }
  } catch (PDOException $e) {
    http_response_code(500);
    echo $e->getMessage();
  }
} catch (PDOException $e) {
  $e->getMessage();
  header('Location: ../../project/select_cost_product.php');
}
