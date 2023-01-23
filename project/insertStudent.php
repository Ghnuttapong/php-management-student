<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 1; ?>
<?php
include '../backend/function.php';
$conn = new db;
$year_arr = $conn->select_manaul_field('finances ORDER BY year DESC limit 1', ['*']);
$product = $conn->select_manaul_field('products', ['*']);
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
      <?php
      // echo "<pre>";
      // print_r($product);
      // echo "</pre>";
      ?>
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 fw-bold p-0">เพิ่มนักเรียน</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">กลับ</a></li>
                <li class="breadcrumb-item active">รายชื่อนักเรียน</li>
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
            <form class="col-12 d-flex flex-row-reverse" id="form-btn" method="post">
              <button type="submit" class="btn btn-primary" <?= $year_arr && $class_arr ? '' : 'disabled' ?>>เพิ่ม</button>
              <a href="index.php" class="btn btn-secondary mx-2">ยกเลิก</a>
            </form>

            <div class="row g-2 pr-0 mx-1">
              <div class="col-12">
                <div class="card">
                  <div class="card-header bg-dark" style="margin-top: -1px;">
                    แบบฟอร์มเพิ่มนักเรียน
                  </div>
                  <div class="card-body" style="border-bottom: 1px solid;">

                    <form method="post" id="form-std">
                      <div class="row">
                        <div class="col-xl-12">
                          <p class="mb-0 text-secondary">ข้อมูลนักเรียน</p>
                        </div>
                      </div>
                      <div class="row pt-3">
                        <div class="col-xl-2">
                          <p class="mb-0 fw-bold">เลขประจำตัวนักเรียน</p>
                        </div>
                        <div class="col-xl-10">
                          <input required type="text" class="form-control mb-2" name="code">
                        </div>
                      </div>
                      <div class="row pt-3">
                        <div class="col-xl-2">
                          <p class="mb-0 fw-bold">คำนำหน้า</p>
                        </div>
                        <div class="col-xl-2">
                          <select required class="form-select mb-2" aria-label="Default select example" name="prefix">
                            <option value="" disabled selected>เลือกคำนำหน้า</option>
                            <option value="เด็กหญิง">เด็กหญิง</option>
                            <option value="เด็กชาย">เด็กชาย</option>
                          </select>
                        </div>
                        <div class="col-xl-1 pr-0">
                          <p class="mb-0 fw-bold">ชื่อ</p>
                        </div>
                        <div class="col-xl-3 ">
                          <input required type="text" class="form-control mb-2" name="firstname">
                        </div>
                        <div class="col-xl-1 pr-0 ">
                          <p class="mb-0 fw-bold">นามสกุล</p>
                        </div>
                        <div class="col-xl-3">
                          <input required type="text" class="form-control mb-2" name="lastname">
                        </div>
                      </div>
                      <div class="row pt-3">
                        <div class="col-xl-2 pr-0">
                          <p class="mb-0 fw-bold">ชื่อเล่น</p>
                        </div>
                        <div class="col-xl-5">
                          <input required type="text" class="form-control mb-2" name="nickname">
                        </div>
                      </div>
                    </form>

                    <form method="post" id="form-select" class="row pt-3">
                      <div class="col-xl-2">
                        <p class="mb-0 fw-bold">ระดับชั้น</p>
                      </div>
                      <div class="col-xl-4">
                        <select required class="form-select mb-2" aria-label="Default select example" name="class">
                          <option value="" selected disabled>เลือกระดับชั้น</option>
                          <?php foreach ($class_arr as $value) { ?>
                            <option value="<?= $value['class'] ?>"><?= $value['class'] ?></option>
                          <?php  } ?>
                        </select>
                      </div>
                      <div class="col-xl-1">
                        <p class="mb-0 fw-bold ">ปีการศึกษา</p>
                      </div>
                      <div class="col-xl-5">
                        <select required class="form-select mb-2" aria-label="Default select example" name="year">
                          <option value="" selected disabled>เลือกปีการศึกษา</option>
                          <?php foreach ($year_arr as $value) { ?>
                            <option selected value="<?= $value['year'] ?>"><?= $value['year'] ?></option>
                          <?php  } ?>
                        </select>
                      </div>
                    </form>

                  </div>

                  <form method="post" id="form-parent" class="card-body">
                    <div class="row">
                      <div class="col-xl-12">
                        <p class="mb-0 text-secondary">ข้อมูลผู้ปกครอง</p>
                      </div>
                    </div>

                    <div class="row pt-3">
                      <div class="col-xl-2">
                        <p class="mb-0 fw-bold">คำนำหน้า</p>
                      </div>
                      <div class="col-xl-2">
                        <input required type="text" class="form-control mb-2" name="p_prefix">
                      </div>
                      <div class="col-xl-1 pr-0">
                        <p class="mb-0 fw-bold ">ชื่อ</p>
                      </div>
                      <div class="col-xl-3">
                        <input required type="text" class="form-control mb-2" name="p_firstname">
                      </div>
                      <div class="col-xl-1 pr-0">
                        <p class="mb-0 fw-bold ">นามสกุล</p>
                      </div>
                      <div class="col-xl-3">
                        <input required type="text" class="form-control mb-2" name="p_lastname">
                      </div>
                    </div>


                    <div class="row pt-3">
                      <div class="col-xl-2">
                        <p class="mb-0 fw-bold">ความเกี่ยวข้องกับนักเรียน</p>
                      </div>
                      <div class="col-xl-10">
                        <input required type="text" class="form-control mb-2" name="p_relative">
                      </div>
                    </div>

                    <div class="row pt-3">
                      <div class="col-xl-2">
                        <p class="mb-0 fw-bold">เบอร์ติดต่อ</p>
                      </div>
                      <div class="col-xl-10">
                        <input required type="text" class="form-control mb-2" name="phone">
                      </div>
                    </div>

                    <div class="row pt-3">
                      <div class="col-xl-2">
                        <p class="mb-0 fw-bold">ที่อยู่ปัจจุบัน</p>
                      </div>
                      <div class="col-xl-10">
                        <div class="form-floating">
                          <textarea class="form-control mb-2" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="address"></textarea>
                        </div>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>


          <div class="box_add_edit_form mb-5 p-0 ">
            <div class="header">
              ค่าใช้จ่ายทั้งหมด
            </div>
            <div class="content " style="padding:0px 0px 10px !important;">
              <div class="d-flex justify-content-between px-2 py-3 align-items-center flex-wrap">
                <p class="text-secondary mt-2 mb-0">โปรดเลือกค่าใช้จ่ายที่ต้องการ</p>
              </div>
              <form class="table-responsive card-body p-0" id="form-check" style="max-height:850px; overflow-y: auto">
                <table class="table table-bordered  table table-hover table-head-fixed text-nowrap">
                  <thead>
                    <th style="width:10%">เลือกรายการ</th>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>ราคา</th>
                    <th>รายละเอียด</th>
                    <th>ประเภท</th>
                  </thead>
                  <tbody id="product-cost-all">
                    <!-- content table product -->
                  </tbody>
                </table>
              </form>
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
    var form = $('#form-add');

    $('#form-btn').submit(function(e) {
      e.preventDefault()
      $.ajax({
        url: '../backend/students/save.php',
        type: 'post',
        data: $('#form-std, #form-select, #form-parent, #form-check').serialize(),
        success: res => {
          swal.fire({
            icon: 'success',
            title: res,
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'insertStudent.php'
            }
          })
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

  <script>
    var search_product = document.getElementById("form-select");


    search_product.addEventListener("change", (e) => {
      e.preventDefault();
      show_table_product();
    });

    const show_table_product = async (e) => {

      const formData = new FormData(search_product);
      formData.append("text_search_order", 1);

      const data = await fetch("../backend/search_all/search_all.php", {
        method: "POST",
        body: formData
      })
      const response = await data.text();
      console.log(response);
      document.getElementById("product-cost-all").innerHTML = response;
    }

    show_table_product();
  </script>


  <script>

  </script>
</body>

</html>