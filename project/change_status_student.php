<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 2; ?>
<?php
include '../backend/function.php';
$conn = new db;
$year_arr = $conn->select_manaul_field('finances GROUP BY year', ['*']);
$class_arr = $conn->select_manaul_field('finances GROUP BY class', ['*']);
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
  <!-- page to web -->
  <input type="number" id="nav_page" value="<?= $page_nav  ?>" class="d-none">

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
              <h1 class="m-0 fw-bold">เปลี่ยนสถานะนักเรียน</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">เปลี่ยนสถานะนักเรียน</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 ">
              <div class="card">
                <div class="card-header bg-dark">
                  เปลี่ยนสถานะการศึกษา
                </div>
                <div class="card-body">
                  <form action="" id="form-graduated">
                    <div class="row">
                      <div class="col-6 d-flex">
                        <div class="col-2 p-0 m-0">
                          <p class="mb-0 fw-bold">ปีการศึกษา</p>
                        </div>
                        <div class="col-6">
                          <select required class="form-select" name="year" aria-label="Default select example">
                            <option selected disabled> --- เลือกปีการศึกษา --- </option>
                            <?php foreach ($year_arr as $value) { ?>
                              <option value="<?= $value['year'] ?>"><?= $value['year'] ?></option>
                            <?php } ?>
                          </select>
                        </div>

                      </div>
                      <div class="col-6 d-flex">
                        <div class="col-2">
                          <p class="mb-0 fw-bold">ระดับชั้น</p>
                        </div>
                        <div class="col-6">
                          <select required class="form-select" name="class" aria-label="Default select example">
                            <option disabled selected> --- เลือกระดับชั้น --- </option>
                            <?php foreach ($class_arr as $value) { ?>
                              <option value="<?= $value['class'] ?>"><?= $value['class'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="row g-3">
                        <div class="col-12">
                          <p class="mb-0 fw-bold"> <span class="text-danger">หมายเหตุ*</span> เป็นการเปลี่ยนแปลงสถานะนักเรียน จากศึกษาอยู่เป็นสำเร็จการศึกษา</p>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col-12 justify-content-end d-flex">
                          <input type="submit" class="btn btn-primary btn-sm " value="บันทึกข้อมูล" <?= $year_arr && $class_arr ? '' : 'disabled' ?>>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>

  </div>
  <!-- ./wrapper -->

  <?php include("linkframework/js.php"); ?>
  <script>
    $('#form-graduated').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: '../backend/students/graduated.php',
        type: 'POST',
        data: $('#form-graduated').serialize(),
        success: function(res) {
          Swal.fire({
            icon: 'success',
            title: res,
          })
          setTimeout(() => {
            window.location.href = './index.php'
          }, 2000);
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