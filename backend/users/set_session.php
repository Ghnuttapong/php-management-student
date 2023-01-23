<?php
require_once("../connect.php");
session_start();
$id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = :id";
$set_user = $obj->prepare($sql);
$result = $set_user->execute(['id' =>  $id]);
if ($result) {
  $row = $set_user->fetch(PDO::FETCH_ASSOC);
  $_SESSION['user_id'] = $row['id'];
  $_SESSION['user_firstname'] = $row['firstname'];
  $_SESSION['user_fullname'] = $row['fullname'];
  $_SESSION['user_role'] = $row['role'];
  header("Location: ../../project/personal_data.php");
  // echo "hi";
}
