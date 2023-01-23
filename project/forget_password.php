<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ระบบจัดการนักเรียนเเละค่าใช้จ่าย</title>
  <?php include("linkframework/css.php"); ?>
</head>

<body>

  <div class="nav_forgot d-flex align-items-center">
    <div class="d-flex align-items-center">
      <img src="asset/image/logoschool.png" class="mx-2 logo_forget">
      <p class="mb-0 text-white mx-2 fs-3 fw-bold">โรงเรียนอนุบาลร่มเย็น</p>
    </div>
    <a href="login.php" class="ml-auto text-white fs-5"> <span class="fas fa-undo"></span> กลับ</a>
  </div>

  <div class="box-forget">
    <p> <span class="text-danger fw-semibold">หมายเหตุ*</span> หากคุณลืมรหัสผ่านโปรดกรอกข้อมูลข้างล่างเเละส่งมาทาง email ทางเราจะส่งอีเมลเเละรหัสผ่านใหม่ให้กลับคุณในภายหลังทาง email ขอบคุณครับ </p>
    <div class="content-forget">
      <div class="header_box fw-bold">เเบบฟอร์มขอรหัสผ่านใหม่</div>
      <div class="detail_sendemail">
        <form id="myform" method="post">
          <div class="content-show mb-3">
            <p class="msg  fw-bold"></p>
            <i class="fas fa-times-circle" id="closr_x"></i>
          </div>
          <div class="row">
            <div class="col-md-2 fw-bold mb-2">อีเมลของคุณ</div>
            <div class="col-md-10 mb-3">
              <input type="email" id="email" placeholder="email" class="w-100 form-control" name="email" required>
            </div>
            <div class="col-md-2 fw-bold mb-2">ชื่อผู้ใช้ หรือ ชื่อ-นามสกุล</div>
            <div class="col-md-10 mb-3">
              <input type="text" id="username" placeholder="username or fullname" class="w-100 form-control" name="username" required>
            </div>
            <div class="col-md-2 fw-bold mb-2">รหัสผ่านที่ต้องการเปลี่ยน</div>
            <div class="col-md-10 mb-3">
              <input type="text" id="new_password" placeholder="password new" class="w-100 form-control" name="new_password" required>
            </div>
            <div class="col-md-2 fw-bold mb-2">สาเหตุ</div>
            <div class="col-md-10 mb-3">
              <input type="text" id="cause" placeholder="cause " class="w-100 form-control" name="cause" required>
            </div>
          </div>
          <div class="d-flex justify-content-end mt-3">
            <button type="button" class="px-2 btn btn-primary" onclick="sendEmail()">บันทึกข้อมูล</button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <script src="asset/js/jquery.js"></script>
  <script src="asset/js/request_password.js" type="text/javascript"></script>
</body>

</html>