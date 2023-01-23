<?php
require_once("../connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $prefix = $_POST['prefix'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $phone = $_POST['phone'];
  $password_new = isset($_POST['password_new']) ? $_POST['password_new'] : false;
  $password_old = isset($_POST['password_old']) ? $_POST['password_old'] : false;
  $role = $_POST['role'];
  $fullname = $prefix . $firstname . ' ' . $lastname;
  $hash_old = md5($password_old);
  $hash_new = md5($password_new);

  $sql = "";
  try {

    $sql_select = "SELECT * FROM users WHERE id = :id AND role = :role";
    $check_pw = $obj->prepare($sql_select);
    $check_pw->execute([
      'id' =>  $id,
      'role' =>  $role,
    ]);

    $row_user = $check_pw->fetch(PDO::FETCH_ASSOC);
    $check_update_pw = $row_user['password'] == $hash_old ? true : false;




    if ($password_new && $password_old) {
      if ($check_update_pw) {
        $sql = "UPDATE users SET prefix = :prefix, firstname = :firstname, lastname = :lastname,	fullname = :fullname, phone = :phone, password =:password_new WHERE id = :id ";
        $update = $obj->prepare($sql);
        $result = $update->execute([
          'prefix' =>   $prefix,
          'firstname' =>   $firstname,
          'lastname' =>   $lastname,
          'fullname' =>   $fullname,
          'phone' =>   $phone,
          'password_new' =>   $hash_new,
          'id' =>   $id,
        ]);
        if ($result) {
          http_response_code(201);
          echo 'อัพเดทข้อมูลเเละรหัสผ่านสำเร็จ';
        } else if ($result == false) {
          http_response_code(400);
          echo 'อัพเดทไม่ข้อมูลสำเร็จ';
        }
      } else {
        http_response_code(400);
        echo 'อัพเดทข้อมูลไม่สำเร็จเนื่องจากรหัสผ่านไม่ถูกต้อง';
        // echo $row_user['password'];
        // echo $password_old;
      }
    } else {
      $sql = "UPDATE users SET prefix = :prefix, firstname = :firstname, lastname = :lastname,	fullname = :fullname, phone = :phone WHERE id= :id";
      $update = $obj->prepare($sql);
      $result = $update->execute([
        'prefix' =>   $prefix,
        'firstname' =>   $firstname,
        'lastname' =>   $lastname,
        'fullname' =>   $fullname,
        'phone' =>   $phone,
        'id' =>   $id
      ]);

      if ($result) {
        http_response_code(201);
        echo 'อัพเดทข้อมูลสำเร็จ';
      } else {
        http_response_code(400);
        echo 'อัพเดทไม่ข้อมูลสำเร็จ';
      }
    }

    // echo    $password_old .   $firstname .  $id;
  } catch (PDOException $e) {
    http_response_code(500);
    echo 'Server Error';
  }
}
