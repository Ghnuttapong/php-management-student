<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 9; ?>
<?php

include '../backend/function.php';
$conn = new db;
$id =  isset($_GET['id']) ? $_GET['id'] : header("Location: order_pay_term.php");
//product
$product = $conn->select_manaul_field('products', ['*']);
$finance_order_id = $conn->select_manual('finances', ['*'], ['id'], [$id]);
$decode_product_list = json_decode($finance_order_id['product_list']);
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
              <h1 class="m-0 fw-bold">เเก้ไขเพิ่มรายการค่าใช้จ่าย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <a href="detail_orderPayterm.php?id=<?= $id ?>">กลับ</a>
                </li>
                <li class="breadcrumb-item active">เเก้ไขเพิ่มรายการค่าใช้จ่าย</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="box_add_edit_form mb-5 p-0 ">
            <div class="header">
              ค่าใช้จ่ายทั้งหมด ของ <?= $finance_order_id['class'] . " ปีการศึกษา " . $finance_order_id['year'] ?>
            </div>
            <form class="content " style="padding:0px 0px 10px !important;" id="form-edit">
              <div class=" table-responsive mt-0" style="padding-left:-0px !important; padding-right:-0px !important;">
                <table class="table table-bordered  table table-hover table-head-fixed text-nowrap ">
                  <thead>
                    <th>รายการที่เลือก</th>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>ราคา</th>
                    <th>รายละเอียด</th>
                    <th>ประเภท</th>
                  </thead>
                  <tbody id="product-cost-all">
                    <!-- content table product -->
                    <input type="hidden" value="<?= $id ?>" name="id">
                    <?php
                    $i = 0;
                    $count_decode_product = count($decode_product_list);
                    foreach ($product as $data) {
                      $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$data['category_id']]);
                    ?>
                      <tr>
                        <td>
                          <!-- ------------------------------------------------------------------------------- -->
                          <?php if ($i < count($decode_product_list)) {  ?>
                            <?php if ($data['id'] == $decode_product_list[$i]) { ?>
                              <input type="checkbox" checked value="<?= $data['id'] ?>" name="product_list[]">
                            <?php $i++;
                            } else { ?>
                              <input type="checkbox" value="<?= $data['id'] ?>" name="product_list[]">
                            <?php } ?>
                          <?php } else { ?>
                            <input type="checkbox" value="<?= $data['id'] ?>" name="product_list[]">
                          <?php } ?>
                          <!-- ------------------------------------------------------------------------------- -->
                        </td>
                        <td><?= $data['code'] ?></td>
                        <td> <?= $data['name'] ?></td>
                        <td> <?= $data['price'] ?></td>
                        <td> <?= $data['detail'] ?></td>
                        <td> <?= $result_select_type['name'] ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="text-end px-2">
                <button class="btn btn-primary px-2" type="submit">บันทึกข้อมูล</button>
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
          })
          setTimeout(function() {
            window.location.reload()
          }, 2000)

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