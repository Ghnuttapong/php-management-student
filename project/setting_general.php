<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 10; ?>
<?php

include '../backend/function.php';
$conn = new db;
//year
$year_arr = $conn->select_is_not_null('models', 'year');

//class
$class_arr = $conn->select_is_not_null_field('models', 'class, class_year, class_room', 'class');

// category
$category_arr = $conn->select_manaul_field('category', ['*']);


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


    <?php include("layout/preloder.php");
    ?>


    <?php include("layout/header.php"); ?>
    <?php include("layout/slidebar.php"); ?>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 fw-bold p-0">ตั้งค่าทั่วไป</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">ตั้งค่าทั่วไป</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">เพิ่มลบแก้ไข ตัวเลือก ปีการศึกษาและระดับชั้น</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <select class="form-select" aria-label="Default select example">
                      <?php
                      if ($year_arr) {
                        foreach ($year_arr as $value) { ?>
                          <option value="<?= $value['year'] ?>"><?= $value['year'] ?></option>
                        <?php  }
                      } else { ?>
                        <option>ยังไม่มีรายการปีการศึกษากรุณาเพิ่ม</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label> </label>
                    <a href="setting_general_year.php" class="btn btn-secondary">แก้ไข</a>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <select class="form-select" aria-label="Default select example">
                      <?php if ($class_arr) {
                        foreach ($class_arr as $value) { ?>
                          <option value="<?= $value['class'] . ' ' . $value['class_year'] . 'ห้อง' . $value['class_room'] ?>"><?= $value['class'] . ' ' . $value['class_year'] . 'ห้อง' . $value['class_room'] ?></option>
                        <?php  }
                      } else { ?>
                        <option>ยังไม่มีรายการระดับชั้นกรุณาเพิ่ม</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label> </label>
                    <a href="setting_general_class.php" class="btn btn-secondary">แก้ไข</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">เพิ่มแก้ไข ตัวเลือก ประเภทรายการ</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <select class="form-select" aria-label="Default select example">
                      <?php if ($category_arr) {
                        foreach ($category_arr as $value) { ?>
                          <option value="<?= $value['name'] ?>"><?= $value['name'] ?></option>
                        <?php  }
                      } else { ?>
                        <option>ยังไม่มีรายการประเภทกรุณาเพิ่ม</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label> </label>
                    <a href="setting_general_category.php" class="btn btn-secondary">แก้ไข</a>
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
</body>

</html>