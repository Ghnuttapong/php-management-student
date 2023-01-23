<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : false;
?>
<?php
$userID = $_SESSION['user_id'];
include '../backend/function.php';
$conn = new db;
$result = $conn->select_manual('users', ['*'], ['id'], [$userID]);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ระบบจัดการนักเรียนเเละค่าใช้จ่าย</title>
  <?php include("linkframework/css.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">


    <?php include("layout/preloder.php"); ?>


    <?php include("layout/header.php"); ?>
    <?php include("layout/slidebar.php"); ?>





    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 fw-bold">ข้อมูลส่วนตัว</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">ข้อมูลส่วนตัว</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <form action="" id="form_personal">
            <div class="d-flex justify-content-end align-items-center">
              <?php if ($is_edit) { ?>
                <a class="btn btn-secondary  mx-2" href="personal_data.php?id=1">ยกเลิก</a>
                <button type="submit" name="submit_datail-product" class="btn btn-primary">บันทึก</button>
              <?php } else { ?>
                <a class="btn btn-secondary px-3" href="personal_data.php?is_edit=1&id=1">เเก้ไขข้อมูล</a>
              <?php } ?>
            </div>
            <div class="box_add_edit_form">
              <div class="header">
                <p class="mb-0">จัดการข้อมูลส่วนตัว</p>
              </div>
              <div class="content row">
                <p class="mb-2 fw-bold col-xl-1">คำนำหน้า</p>
                <div class="col-xl-11 mb-3 ">
                  <?php if ($is_edit == false) { ?>
                    <?= $result['prefix']; ?>
                  <?php } else { ?>
                    <input type="text" class="form-control" name="prefix" required value="<?= $result['prefix'] ?>">
                    <input type="hidden" value="<?= $result['role'] ?>" name="role">
                    <input type="hidden" value="<?= $result['id'] ?>" name="id">
                  <?php } ?>
                </div>

                <p class="mb-2 fw-bold col-xl-1">ชื่อ</p>
                <div class="col-xl-5 mb-3 ">
                  <?php if ($is_edit == false) { ?>
                    <?= $result['firstname']; ?>
                  <?php } else { ?>
                    <input type="text" class="form-control" name="firstname" required value="<?= $result['firstname'] ?>">
                  <?php } ?>
                </div>

                <p class="mb-2 fw-bold col-xl-1">นามสกุล</p>
                <div class="col-xl-5 mb-3 ">
                  <?php if ($is_edit == false) { ?>
                    <?= $result['lastname']; ?>
                  <?php } else { ?>
                    <input type="text" class="form-control" name="lastname" required value="<?= $result['lastname'] ?>">
                  <?php } ?>
                </div>



                <p class="mb-2 fw-bold col-xl-1">เบอร์โทร</p>
                <div class="col-xl-11 mb-3 ">
                  <?php if ($is_edit == false) { ?>
                    <?= $result['phone']; ?>
                  <?php } else { ?>
                    <input type="number" class="form-control" name="phone" required value="<?= $result['phone'] ?>">
                  <?php } ?>
                </div>

                <p class="mb-2 fw-bold col-xl-1">ชื่อผู้ใช้</p>
                <div class="col-xl-5 mb-3 ">
                  <?= $result['username']; ?>
                </div>


                <p class="mb-2 fw-bold col-xl-1">รหัสผ่านของคุณ</p>
                <div class="col-xl-5 mb-3 ">
                  <?php if ($is_edit == false) { ?>
                    <?= "******"; ?>
                  <?php } else { ?>
                    <input type="password" class="form-control" name="password_old" id="password_old" placeholder="โปรดกรอกรหัสเก่าของคุณหากต้องการเปลี่ยน">
                  <?php } ?>
                </div>

                <?php if ($is_edit) { ?>
                  <p class="mb-2 fw-bold col-xl-1">รหัสผ่านใหม่</p>
                  <div class="col-xl-5 mb-3 ">
                    <input type="password" class="form-control" name="password_new" id="password_new" placeholder="โปรดกรอกรหัสใหม่">
                  </div>
                  <div class="col-xl-12 mb-3 ">
                    <input type="checkbox" name="show_password" id="show_password">
                    <labal class="mb-2 fw-bold col-xl-1" for="show_password">เเสดงรหัสผ่าน</labal>
                  </div>
                <?php } ?>
              </div>
            </div>
          </form>
        </div>

      </section>
      <!-- /.content -->
    </div>

  </div>
  <?php include("layout/slidebar.php"); ?>
  <!-- ./wrapper -->

  <?php include("linkframework/js.php"); ?>
  <script>
    var show_password = document.getElementById("show_password");
    var password_new = document.getElementById("password_new");

    show_password.addEventListener("click", () => {
      if (show_password.checked == true) {
        password_new.type = 'text';
      } else if ((show_password.checked == false)) {
        password_new.type = 'password';
      }
    })
  </script>
  <script>
    $('#form_personal').submit(function(e) {
      e.preventDefault()
      $.ajax({
        url: '../backend/users/update_dataPersonal.php',
        type: 'post',
        data: $('#form_personal').serialize(),
        success: function(res) {
          Swal.fire({
            icon: 'success',
            title: res,
          })
          if (res == "อัพเดทข้อมูลเเละรหัสผ่านสำเร็จ") {
            setTimeout(() => {
              window.location.href = 'logout.php'
            }, 2000);
          } else if (res == "อัพเดทข้อมูลสำเร็จ") {
            setTimeout(() => {
              window.location.href = '../backend/users/set_session.php'
            }, 2000);
          }
        },
        error: function(err) {
          Swal.fire({
            icon: 'error',
            title: err.responseText,
          })
        }
      })
    })
  </script>
</body>

</html>