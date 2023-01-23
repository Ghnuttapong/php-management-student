<?php
session_start();
$x = isset($_POST['id']) ? $_POST['id'] : "";

if (isset($_SESSION['orderAll']) != "") {
  usort($_SESSION['orderAll'], function ($a, $b) {
    return $a['id'] - $b['id'];
  });
  array_splice($_SESSION['orderAll'], $x, 1);
  $array = $_SESSION['orderAll'];
  $count  = count($array) > 0  ?  count($array) : 0;
  $_SESSION["total_order_success"] = $count;
}

echo "success";
