<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 1;
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
?>

<?php
include '../backend/function.php';
$conn = new db;
$count_std = $conn->select_count_table('students');
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
              <h1 class="m-0 fw-bold p-0">รายชื่อนักเรียน</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
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
          <form class="row " id="search_student" method="POST">
            <div class="mb-3 col-md-3">
              <select required class="form-select" id="select_year" aria-label="Default select example" name="select_year">
                <option selected disabled value="ทั้งหมด">เลือกปีการศึกษา</option>
                <option value="ทั้งหมด">ปีการศึกษาทั้งหมด</option>
                <?php foreach ($year_arr as $value) { ?>
                  <option value="<?= $value['year'] ?>"><?= $value['year'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3 col-md-3">
              <select class="form-select" id="select_class" aria-label="Default select example" name="select_class">
                <option selected disabled value="ทั้งหมด">เลือกระดับชั้น</option>
                <option value="ทั้งหมด">ระดับชั้นทั้งหมด</option>
                <?php foreach ($class_arr as $value) { ?>
                  <option value="<?= $value['class'] ?>"><?= $value['class'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-3"></div>
            <div class="mb-3 col-md-3">
              <div class="search">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="ค้นหารายชื่อนักเรียน" name="keyword" aria-label="Recipient's username" aria-describedby="button-addon2">
                  <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </div>
          </form>
          <div class="row">
            <div class="col-xl-4 col-md-6">
              <div class="color-card card mb-3 text-light" style="max-width: 18rem;  background-color: #087990;">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h3 id="count_std">
                        <!-- count student count -->
                      </h3>
                      <p>ยอดนักเรียนทั้งหมด</p>
                    </div>
                    <div class="col-4 text-center">
                      <i class="fas fa-users" style="font-size: 55px;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-2 col-md-3">
              <a href="insertStudent.php" class="btn btn-primary btn-sm">+ เพิ่มนักเรียน</a>
            </div>
          </div>
          <div class="row pt-3">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-header bg-dark">
                  รายชื่อนักเรียน
                </div>
                <div class="card-body table-responsive p-0  w-100 table-responsive">
                  <table class="table table-bordered  table table-hover table-head-fixed text-nowrap text-center">
                    <thead class="table">
                      <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">เลขประจำตัว</th>
                        <th scope="col">ชื่อ - นามสกุล</th>
                        <th scope="col">ระดับชั้น/ห้อง</th>
                        <th scope="col">ปีการศึกษา</th>
                        <th scope="col">ค่าเทอม/ค่าใช้จ่าย</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">รายละเอียด</th>
                      </tr>
                    </thead>
                    <tbody id="search_show">
                      <!-- data student -->
                    </tbody>
                  </table>
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
    var select_class = document.getElementById("select_class");
    var select_year = document.getElementById("select_year");
    var search_student = document.getElementById("search_student");
    var count_std = document.getElementById("count_std");

    select_class.addEventListener("change", () => {
      show_student();
    })

    select_year.addEventListener("change", () => {
      show_student();
    })


    search_student.addEventListener("submit", (e) => {
      e.preventDefault();
      show_student();
    });



    const show_student = async (e) => {

      const formData = new FormData(search_student);
      formData.append("read_stdent", 1);

      const data = await fetch("../backend/search_all/search_all.php", {
        method: "POST",
        body: formData
      })
      const response = await data.json();
      console.log(response.text);
      document.getElementById("search_show").innerHTML = response.text;
      count_std.innerText = response.count;
    }


    show_student();
  </script>
</body>

</html>