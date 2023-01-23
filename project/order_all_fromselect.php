<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 5;
require_once("../backend/function.php");
$conn = new db;
$array = "";
$count_order = isset($_SESSION["count_order"]) ? $_SESSION["count_order"] : 0;
$_SESSION['total'] = isset($_SESSION["total"]) ? $_SESSION["total"] : 0;

if (isset($_SESSION['data']) != "") {
  $array = $_SESSION['data'];
  $array2 = $_SESSION['data'];
  usort($array, function ($a, $b) {
    return $a['id'] - $b['id'];
  });

  $input = array_map("unserialize", array_unique(array_map("serialize", $array)));
  usort($input, function ($a, $b) {
    return $a['id'] - $b['id'];
  });


  $data =   $array;
  $order = 1;
  $total = 0;
  $count_products = 0;
  $count_delete = 0;

  $count  = count($array) > 0  ?  count($array) : 0;
  $_SESSION["count_order"] = $count;
  $count_order = isset($_SESSION["count_order"]) ? $_SESSION["count_order"] : 0;


  if (count($array) > 0) {
    for ($x = 0; $x < count($array); $x++) {
      $total += $array[$x]['price'];
      $_SESSION['total'] = $total;
    }
  } else {
    $total  = 0;
    $_SESSION['total'] = $total;
  }

  for ($i  = 0; $i < count($input); $i++) {
    $id_for1 = $input[$i]['id'];
    for ($k  = 0; $k < count($array2); $k++) {
      $id_for2 = $array2[$k]['id'];
      if ($id_for1 ==  $id_for2) {
        $count_products  += $array2[$k]['rating'];
        $input[$i]['rating'] =  $count_products;
      }
    }
    $input[$i]['priceAll'] =  $input[$i]['price'] * $count_products;
    $count_products = 0;
  }
  $_SESSION['send_order'] = $input;
}



$std_detail = $conn->select_belong(
  'students',
  'order_finance',
  'students.*, order_finance.status as f_status, order_finance.pay as f_pay, order_finance.expenses as f_expenses',
  'order_finance.std_id = students.id',
  ['order_finance.std_id'],
  [$_SESSION['student_id']]
);
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


    <?php include("layout/header.php"); ?>
    <?php include("layout/slidebar.php"); ?>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php
      // echo "<pre>";
      // print_r($input);
      // echo "</pre>";
      ?>
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 fw-bold">สั่งรายการสินค้า/ค่าใช้จ่าย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="select_cost_product.php?id=<?= $_SESSION['student_id'] ?>">กลับหน้าสั่งสินค้า</a></li>
                <li class="breadcrumb-item active">สั่งรายการสินค้า/ค่าใช้จ่าย</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid ">
          <div class="table_order_send">
            <div class=" table-responsive p-0  w-100 ">
              <table class="table table-bordered  table table-hover table-head-fixed text-nowrap ">
                <thead>
                  <tr>
                    <th>ลำดับ</th>
                    <th>เลขรายการสินค้า/ค่าใช้จ่าย</th>
                    <th>ชื่อ</th>
                    <th>ประเภท</th>
                    <th>รายละเอียด</th>
                    <th>จำนวน</th>
                    <th>ราคา</th>
                    <th>ราคารวม</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  <?php for ($i  = 0; $i < count($data); $i++) {
                    $count_delete += $data[$i]['rating'];
                    $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$data[$i]['type']]);
                  ?>
                    <tr>
                      <td><?= $order++ ?></td>
                      <td><?= $data[$i]['code'] ?></td>
                      <td><?= $data[$i]['name'] ?></td>
                      <td><?= $result_select_type['name'] ?></td>
                      <td><?= $data[$i]['detail'] ?></td>
                      <td><?= $data[$i]['rating'] ?></td>
                      <td><?= $data[$i]['price'] ?></td>
                      <th><?= $data[$i]['priceAll'] ?></th>
                      <td class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary px-3 mx-1 fw-bold add_order" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" id="<?= $data[$i]['id'] ?>">+</button>
                        <button type="button" class="btn btn-danger px-3 mx-1 fw-bold delete_order" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" id="<?= $count_delete - 1  ?>">-</button>
                      </td>
                    </tr>
                  <?php
                    $count_products = 0;
                  }
                  ?>
                  <tr>
                    <td colspan="1" class="text-left">
                      <p class="mb-0 fw-bold">จำนวนทั้งหมด : <span><?= $count_order ?></span></p>
                    </td>
                    <td colspan="8" class="text-right">
                      <p class="mb-0 fw-bold">ราคาทั้งหมด : <span><?= number_format($_SESSION['total'], 2) . "฿" ?></span></p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <form action="" class="mt-5" id="form_add_order">
            <div class="box_add_edit_form_white">
              <div class="header fw-bold">รายละเอียดนักเรียนที่สินค้า</div>
              <div class="content row">

                <!-- id student -->
                <input type="hidden" name="std_id" value="<?= $std_detail['id']  ?>">

                <p class="mb-2 fw-bold col-md-2">เลขประจำตัวนักเรียน</p>
                <div class="col-md-3  mb-3 ">
                  <p class="mb-0"><?= $std_detail['code'] ?></p>
                </div>

                <p class="mb-2 fw-bold col-md-1">ชื่อ - สกุล</p>
                <div class="col-md-6  mb-3 ">
                  <p class="mb-0"><?= $std_detail['fullname'] ?></p>
                </div>

                <p class="mb-2 fw-bold col-md-2">ที่อยู่ปัจจุบัน</p>
                <div class="col-md-3 mb-3 ">
                  <p class="mb-0"><?= $std_detail['address'] ?></p>
                </div>

                <p class="mb-2 fw-bold col-md-1">เบอร์ติดต่อ</p>
                <div class="col-md-6 mb-3 ">
                  <p class="mb-0"><?= $std_detail['phone'] ?></p>
                </div>

                <p class="mb-2 fw-bold col-md-2">ระดับชั้น</p>
                <div class="col-md-3 mb-3 ">
                  <p class="mb-0"><?= $std_detail['class'] ?></p>
                </div>

                <p class="mb-2 fw-bold col-md-1">ปีการศึกษา</p>
                <div class="col-md-6 mb-3 ">
                  <p class="mb-0"><?= $std_detail['year'] ?></p>
                </div>

                <!-- <p class="mb-2 fw-bold col-md-2">หมายเหตุ</p>
                <div class="col-md-6 mb-3 ">
                  <textarea class="form-control " placeholder="พิมพ์.." id="floatingTextarea2" style="height: 100px" name="note"></textarea>
                </div>-->
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary px-3 mt-4" <?= $count_order == 0 ? 'disabled' : ''  ?>>ยืนยันคำสั่งซื้อ</button>
            </div>
          </form>
        </div>
      </section>
      <!-- /.content -->
    </div>

  </div>
  <!-- ./wrapper -->



  <?php include("linkframework/js.php"); ?>
  <script>
    $("document").ready(() => {
      $(".delete_order").click(function(e) {
        e.preventDefault();
        var mid = $(this).attr("id");
        console.log(mid);

        $.ajax({
          url: "../backend/Setorder/set_cart.php",
          method: "post",
          data: {
            id: mid
          },
          success: function(response) {
            location.reload();
          }
        });
      });

      $(".add_order").click(function(e) {
        e.preventDefault();
        var mid = $(this).attr("id");

        $.ajax({
          url: "../backend/Setorder/set_session_order.php",
          method: "post",
          data: {
            id: mid
          },
          success: function(response) {
            location.reload();
          }
        });
      });

    })

    var form_add_order = document.getElementById("form_add_order");

    form_add_order.addEventListener("submit", async (e) => {
      e.preventDefault();

      const formData = new FormData(form_add_order);

      if (form_add_order.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      } else {
        const data = await fetch("../backend/Setorder/insert_order.php", {
          method: "POST",
          body: formData
        })
        const res = await data.text();
        if (res == "เพิ่มรายการสำเร็จ") {
          Swal.fire({
            icon: 'success',
            title: res,
          })
          setInterval(() => {
            location.assign("../backend/Setorder/unset_session.php");
          }, 2000);
        } else {
          Swal.fire({
            icon: 'error',
            title: res,
          })
          // setInterval(() => {
          //   location.assign("select_cost_product.php?id=<?= $_SESSION['student_id'] ?>");
          // }, 2000);
        }
      }

    })
  </script>
</body>

</html>