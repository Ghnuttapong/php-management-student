<?php

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['name']) && isset($_POST['email'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $cause = $_POST['cause'];
  $password_new = $_POST['password_new'];
  $header = "request new password of member";

  require_once "PHPMailer/PHPMailer.php";
  require_once "PHPMailer/SMTP.php";
  require_once "PHPMailer/Exception.php";

  $emailaddress = "patiphonwongsee01@gmail.com";
  $emailsend = "ผู้ส่ง : " . $email . " <br/> ข้อความ : ต้องการขอรหัสผ่านใหม่เป็น : " . $password_new . "<br/> เนื่องจาก : " . $cause . "<br/> ชื่อผู้ใช้คือ : " . $name;

  $mail = new PHPMailer();

  // SMTP Settings
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = true;
  $mail->Username = "iceiiiii1998@gmail.com"; // enter your email address
  $mail->Password = "drrifytcwxgwayro"; // enter your password
  $mail->Port = 465;
  $mail->SMTPSecure = "ssl";

  //Email Settings
  $mail->isHTML(true);
  $mail->setFrom($emailaddress, $email);
  $mail->addAddress($emailaddress); // Send to mail
  $mail->Subject = $header;
  $mail->Body =  $emailsend;

  if ($mail->send()) {
    $status = "success";
    $response = "Email is sent";
  } else {
    $status = "failed";
    $response = "Something is wrong" . $mail->ErrorInfo;
  }

  exit(json_encode(array("status" => $status, "response" => $response)));
}
