<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 3; ?>
<?php
include '../backend/function.php';
$conn = new db;

$year_arr = $conn->select_manaul_field('finances GROUP BY year', ['*']);
$class_arr = $conn->select_manaul_field('finances GROUP BY class', ['*']);

$finance_state_4 = $conn->select_join_group('order_finance', 'students', 'order_finance.status as f_status, students.*', 'order_finance.std_id = students.id', ['order_finance.state'], [4]);
$finance_state_3 = $conn->select_join_group('order_finance', 'students', 'order_finance.status as f_status, students.*', 'order_finance.std_id = students.id', ['order_finance.state'], [3]);
$finance_state_2 = $conn->select_join_group('order_finance', 'students', 'order_finance.status as f_status, students.*', 'order_finance.std_id = students.id', ['order_finance.state'], [2]);
$finance_state_1 = $conn->select_join_group('order_finance', 'students', 'order_finance.status as f_status, students.*', 'order_finance.std_id = students.id', ['order_finance.state'], [1]);
$finance_count = $conn->select_count_where('order_finance', ['state'], [3]);
$student_count = $conn->select_count_table('students');
$sum_finance = $conn->sum_data('order_finance', 'pay', [], []);
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
              <h1 class="m-0 fw-bold">รายการจ่ายค่าเทอมค่าใช้จ่าย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">รายการจ่ายค่าเทอมค่าใช้จ่าย</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row pt-3">

            <div class="col-12 mb-3 p-1">
              <form class="d-flex flex-wrap" id="search_report" method="POST">
                <div class="mb-3 col-md-3">
                  <select required class="form-select" id="select_year" aria-label="Default select example" name="select_year">
                    <option disabled value="ทั้งหมด"><?= $year_arr ? "เลือกปีการศึกษา" : "ไม่มีรายการปีการศึกษา" ?></option>
                    <option value="ทั้งหมด" selected>ปีการศึกษาทั้งหมด</option>
                    <?php foreach ($year_arr as $value) { ?>
                      <option value="<?= $value['year'] ?>"><?= $value['year'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="mb-3 col-md-3">
                  <select class="form-select" id="select_class" aria-label="Default select example" name="select_class">
                    <option disabled value="ทั้งหมด"><?= $class_arr ? "เลือกระดับชั้น" : "ไม่มีรายการระดับชั้น" ?></option>
                    <option value="ทั้งหมด" selected>ระดับชั้นทั้งหมด</option>
                    <?php foreach ($class_arr as $value) { ?>
                      <option value="<?= $value['class'] ?>"><?= $value['class'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </form>
            </div>
            <div class="col-12">
              <div class="card" id="card_report">
                <!-- report content -->
              </div>
            </div>
            <div class="col-12 ">
              <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                  <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="pt-2 px-3">
                      <h5 class="card-title">รายจ่ายค่าเทอม</h5>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active1 " id="btn_conntent_taborder1" href="#">รายการใหม่</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active2" id="btn_conntent_taborder2" href="#">กำลังดำเนินการ</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active3" id="btn_conntent_taborder3" href="#">จ่ายแล้วทั้งหมด</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active4" id="btn_conntent_taborder4" href="#">ไม่สำเร็จ</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body p-2">
                  <div class="tab-content">
                    <div class="" id="conntent_taborder1">
                      <div class="row">
                        <div class="col-12">
                          <div class="card-header bg-white">
                            <div class="row ">
                              <div class="col-12 d-flex justify-content-between pl-0">
                                <div class="col-2 pl-0">
                                  <div class="w-100 d-flex justify-content-between align-items-center flex-wrap py-2">
                                    <h5 class="fw-bold">รายการใหม่</h5>
                                  </div>
                                </div>
                                <form class="col-3" id="search_student1" method="post">
                                  <div class="input-group mb-3">
                                    <!-- search -->
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" name="keyword1" placeholder="Search...">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                    <!-- search -->
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          <div class="card-body table-responsive p-0 text-center" style="height: 400px;">
                            <table class="table table-bordered  table table-hover table-head-fixed text-nowrap">
                              <thead>
                                <tr>
                                  <th class="pl-3">เลขประจำตัวนักเรียน</th>
                                  <th>ลำดับ</th>
                                  <th>รหัสออเดอร์</th>
                                  <th>ชื่อ-สกุล</th>
                                  <th>ปีการศึกษา</th>
                                  <th>ระดับชั้น</th>
                                  <th>สถานะการจ่ายเงิน</th>
                                  <th>สถานะรายการ</th>
                                  <th>รายละเอียด</th>
                                </tr>
                              </thead>
                              <tbody id="table_ordernew1">
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="" id="conntent_taborder2">
                      <div class="row">
                        <div class="col-12">
                          <div class="card-header bg-white">
                            <div class="row ">
                              <div class="col-12 d-flex justify-content-between pl-0">
                                <div class="col-2 pl-0">
                                  <div class="w-100 d-flex justify-content-between align-items-center flex-wrap py-2">
                                    <h5 class="fw-bold">กำลังดำเนินการ</h5>
                                  </div>
                                </div>
                                <form class="col-3" id="search_student2" method="post">
                                  <div class="input-group mb-3">
                                    <!-- search -->
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" name="keyword2" placeholder="Search...">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                    <!-- search -->
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          <div class="card-body table-responsive p-0 text-center" style="height: 400px;">
                            <table class="table table-bordered  table table-hover table-head-fixed text-nowrap">
                              <thead>
                                <tr>
                                  <th class="pl-3">เลขประจำตัวนักเรียน</th>
                                  <th>ลำดับ</th>
                                  <th>รหัสออเดอร์</th>
                                  <th>ชื่อ-สกุล</th>
                                  <th>ปีการศึกษา</th>
                                  <th>ระดับชั้น</th>
                                  <th>สถานะการจ่ายเงิน</th>
                                  <th>สถานะรายการ</th>
                                  <th>รายละเอียด</th>
                                </tr>
                              </thead>
                              <tbody id="table_ordernew2">
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="" id="conntent_taborder3">
                      <div class="row">
                        <div class="col-12">
                          <div class="card-header bg-white">
                            <div class="row ">
                              <div class="col-12 d-flex justify-content-between pl-0">
                                <div class="col-2 pl-0">
                                  <div class="w-100 d-flex justify-content-between align-items-center flex-wrap py-2">
                                    <h5 class="fw-bold">จ่ายแล้วทั้งหมด</h5>
                                  </div>
                                </div>
                                <form class="col-3" id="search_student3" method="post">
                                  <div class="input-group mb-3">
                                    <!-- search -->
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" name="keyword3" placeholder="Search...">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                    <!-- search -->
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          <div class="card-body table-responsive p-0 text-center" style="height: 400px;">
                            <table class="table table-bordered  table table-hover table-head-fixed text-nowrap">
                              <thead>
                                <tr>
                                  <th class="pl-3">เลขประจำตัวนักเรียน</th>
                                  <th>ลำดับ</th>
                                  <th>รหัสออเดอร์</th>
                                  <th>ชื่อ-สกุล</th>
                                  <th>ปีการศึกษา</th>
                                  <th>ระดับชั้น</th>
                                  <th>สถานะการจ่ายเงิน</th>
                                  <th>สถานะรายการ</th>
                                  <th>รายละเอียด</th>
                                </tr>
                              </thead>
                              <tbody id="table_ordernew3">
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="" id="conntent_taborder4">
                      <div class="row">
                        <div class="col-12">
                          <div class="card-header bg-white">
                            <div class="row ">
                              <div class="col-12 d-flex justify-content-between pl-0">
                                <div class="col-3 pl-0">
                                  <div class="w-100 d-flex justify-content-between align-items-center flex-wrap py-2">
                                    <h5 class="fw-bold">รายการที่ยังจ่ายค่าเทอมไม่ครบ</h5>
                                  </div>
                                </div>
                                <form class="col-3" id="search_student4" method="post">
                                  <div class="input-group mb-3">
                                    <!-- search -->
                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" name="keyword4" placeholder="Search...">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                    <!-- search -->
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          <div class="card-body table-responsive p-0 text-center" style="height: 400px;">
                            <table class="table table-bordered  table table-hover table-head-fixed text-nowrap">
                              <thead>
                                <tr>
                                  <th class="pl-3">เลขประจำตัวนักเรียน</th>
                                  <th>ลำดับ</th>
                                  <th>รหัสออเดอร์</th>
                                  <th>ชื่อ-สกุล</th>
                                  <th>ปีการศึกษา</th>
                                  <th>ระดับชั้น</th>
                                  <th>สถานะการจ่ายเงิน</th>
                                  <th>สถานะรายการ</th>
                                  <th>รายละเอียด</th>
                                </tr>
                              </thead>
                              <tbody id="table_ordernew4">
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>



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
  <script src="./asset/js/managementOrderterm.js"></script>
  <script>
    var search_student1 = document.getElementById("search_student1");
    var search_student2 = document.getElementById("search_student2");
    var search_student3 = document.getElementById("search_student3");
    var search_student4 = document.getElementById("search_student4");
    var search_report = document.getElementById("search_report");
    var select_year = document.getElementById("select_year");
    var select_class = document.getElementById("select_class");

    search_student1.addEventListener("submit", (e) => {
      e.preventDefault();
      status1();
    });
    search_student2.addEventListener("submit", (e) => {
      e.preventDefault();
      status2();
    });
    search_student3.addEventListener("submit", (e) => {
      e.preventDefault();
      status3();
    });
    search_student4.addEventListener("submit", (e) => {
      e.preventDefault();
      status4();
    });

    select_year.addEventListener("change", (e) => {
      e.preventDefault();
      report();
    });

    select_class.addEventListener("change", (e) => {
      e.preventDefault();
      report();
    });

    const status1 = async (e) => {

      const formData = new FormData(search_student1);
      formData.append("status1", 1);

      const data = await fetch("../backend/search_all/search_all.php", {
        method: "POST",
        body: formData
      })
      const response = await data.text();
      document.getElementById("table_ordernew1").innerHTML = response;
    }

    const status2 = async (e) => {

      const formData = new FormData(search_student2);
      formData.append("status2", 1);

      const data = await fetch("../backend/search_all/search_all.php", {
        method: "POST",
        body: formData
      })
      const response = await data.text();
      document.getElementById("table_ordernew2").innerHTML = response;
    }

    const status3 = async (e) => {

      const formData = new FormData(search_student3);
      formData.append("status3", 1);

      const data = await fetch("../backend/search_all/search_all.php", {
        method: "POST",
        body: formData
      })
      const response = await data.text();
      document.getElementById("table_ordernew3").innerHTML = response;
    }

    const status4 = async (e) => {

      const formData = new FormData(search_student4);
      formData.append("status4", 1);

      const data = await fetch("../backend/search_all/search_all.php", {
        method: "POST",
        body: formData
      })
      const response = await data.text();
      document.getElementById("table_ordernew4").innerHTML = response;
    }

    const report = async (e) => {
      const formData = new FormData(search_report);
      formData.append("searchReport", 1);

      const data = await fetch("../backend/search_all/search_all.php", {
        method: "POST",
        body: formData
      })
      const response = await data.text();
      console.log(response);
      document.getElementById("card_report").innerHTML = response;
    }


    status1();
    status2();
    status3();
    status4();
    report();
  </script>
</body>

</html>