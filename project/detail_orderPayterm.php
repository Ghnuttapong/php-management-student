<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 9; ?>
<?php

include '../backend/function.php';
$conn = new db;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id =  isset($_POST['id']) ? $_POST['id'] : header("Location: order_pay_term.php");
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $id =  isset($_GET['id']) ? $_GET['id'] : header("Location: order_pay_term.php");
}

$detail_finance = $conn->select_manual("finances", ["*"], ["id"], [$id]);
$product = json_decode($detail_finance['product_list']);
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
              <h1 class="m-0 fw-bold">เเก้ไขค่าเทอมค่าใช้จ่าย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="order_pay_term.php">กลับ</a></li>
                <li class="breadcrumb-item active">เเก้ไขค่าเทอมค่าใช้จ่าย</li>
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
              <h3 class="card-title">เเก้ไขค่าเทอมค่าใช้จ่าย</h3>
            </div>
            <form id="form-edit">
              <div class="card-body ">
                <div class="row ">
                  <div class="col-md-2  ">
                    <p class="mb-0">ปีการศึกษา</p>
                  </div>
                  <div class="col-md-4">
                    <p class="mb-3"><?= $detail_finance['year'] ?></p>
                  </div>
                  <div class="col-md-2  ">
                    <p class="mb-0">ระดับชั้น</p>
                  </div>
                  <div class="col-md-4">
                    <p class="mb-3"><?= $detail_finance['class'] ?></p>
                  </div>
                  <div class="col-md-2  ">
                    <p class="mb-0">ค่าเทอม</p>
                  </div>
                  <div class="col-md-7">
                    <input type="number" name="term_fees" id="" class="form-control mb-3" value="<?= $detail_finance['term_fees'] ?>">
                  </div>
                  <div class="col-12 mt-3">
                    <p>รายการค่าใช้จ่ายทั้งหมด</p>
                  </div>
                  <div class="table-responsive mt-2" style="padding-left:-0px !important; padding-right:-0px !important; max-height:600px; overflow-y:auto;">
                    <table class="table table-bordered  table table-hover table-head-fixed text-nowrap ">
                      <thead>
                        <th>ลำดับ</th>
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                        <th>ราคา</th>
                        <th>รายละเอียด</th>
                        <th>ประเภท</th>
                      </thead>
                      <tbody id="product-cost-all">
                        <?php
                        $number = 1;
                        $position = 0;
                        foreach (range(1, count($product)) as $data) {
                          $detile_cost = $conn->select_manual("products", ["*"], ["id"], [$product[$position++]]);
                          $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$detile_cost['category_id']]);
                        ?>
                          <tr>
                            <td><?= $number++ ?></td>
                            <td><?= $detile_cost['code'] ?></td>
                            <td><?= $detile_cost['name'] ?></td>
                            <td><?= $detile_cost['price'] ?></td>
                            <td><?= $detile_cost['detail'] ?></td>
                            <td><?= $result_select_type['name'] ?></td>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12 mt-4 ">
                    <a href="order_pay_term.php" class="btn btn-secondary mx-2 btn-sm float-end">ยกเลิก</a>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="submit" value="บันทึกข้อมูล" class="btn btn-primary btn-sm float-end">
                    <a href="add_order_cost.php?id=<?= $id ?>" class="btn btn-warning mx-2 btn-sm float-end">เพิ่มค่าใช้จ่าย</a>
                  </div>
                </div>
              </div>
            </form>
          </div>

        </div>
      </section>
      <!-- /.content -->
    </div>

  </div>
  <!-- ./wrapper -->


  <?php include("linkframework/js.php"); ?>

  <script>
    $('#form-edit').submit(function(e) {
      e.preventDefault()
      $.ajax({
        url: '../backend/setting/term_update.php',
        data: $('#form-edit').serialize(),
        type: 'POST',
        success: function(res) {
          Swal.fire({
            icon: 'success',
            title: res,
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload()
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
</body>

</html>