<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 9; ?>
<?php

include '../backend/function.php';
$conn = new db;
//year
$year_arr = $conn->select_is_not_null('models', 'year');

//class
$class_arr = $conn->select_is_not_null_field('models', 'class, class_year, class_room', 'class');

// term_fees
$term_fees = $conn->select_manaul_field('finances', ['*']);

//product
$product = $conn->select_manaul_field('products', ['*']);




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
              <h1 class="m-0 fw-bold">กำหนดค่าเทอมค่าใช้จ่าย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">กำหนดค่าเทอมค่าใช้จ่าย</li>
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
              <h3 class="card-title">กำหนดค่าเทอมค่าใช้จ่าย</h3>
            </div>
            <form id="form-add">
              <div class="card-body ">
                <div class="row ">
                  <div class="col-md-1 mt-2">
                    <p>ปีการศึกษา</p>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="year" class="form-select" aria-label="Default select example">
                        <option disabled>เลือกปีการศึกษา</option>
                        <?php foreach ($year_arr as $value) { ?>
                          <option value="<?= $value['year'] ?>"><?= $value['year'] ?></option>
                        <?php   } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2"> </div>
                  <div class="col-md-1 mt-2">
                    <p>ระดับชั้น</p>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="class" class="form-select" aria-label="Default select example">
                        <option disabled>เลือกระดับชั้น</option>
                        <?php foreach ($class_arr as $value) { ?>
                          <option value="<?= $value['class'] . ' ' . $value['class_year'] . 'ห้อง' . $value['class_room'] ?>"><?= $value['class'] . ' ' . $value['class_year'] . 'ห้อง' . $value['class_room'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2"> </div>
                  <div class="col-md-1 mt-2">
                    <p>ค่าเทอม</p>
                  </div>
                  <div class="col-md-5">
                    <input required type="text" name="term_fees" id="" class="form-control">
                  </div>
                  <div class="col-12 mt-3">
                    <p>เลือกค่าใช้จ่ายที่ต้องการ</p>
                  </div>
                  <div class="table-responsive mt-2" style="padding-left:-0px !important; padding-right:-0px !important; max-height:800px; overflow-y:auto;">
                    <table class="table table-bordered  table table-hover table-head-fixed text-nowrap ">
                      <thead>
                        <th style="width:10%"> <input type="checkbox" id="checkAll" class="mb-0"> เลือกรายการ</th>
                        <th>ลำดับ</th>
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                        <th>ราคา</th>
                        <th>รายละเอียด</th>
                        <th>ประเภท</th>
                      </thead>
                      <tbody id="product-cost-all">
                        <!-- content table product -->
                        <?php
                        $row = 1;
                        if (empty($product)) { ?>
                          <tr>
                            <td colspan="6" class="text-center">ยังไม่มีรายการ</td>
                          </tr>
                          <?php } else {
                          foreach ($product as $data) {
                            $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$data['category_id']]);
                          ?>
                            <tr>
                              <td>
                                <input type="checkbox" value="<?= $data['id'] ?>" name="finance_order[]" id="finance_order">
                              </td>
                              <td><?= $row++ ?></td>
                              <td><?= $data['code'] ?></td>
                              <td> <?= $data['name'] ?></td>
                              <td> <?= $data['price'] ?></td>
                              <td> <?= $data['detail'] ?></td>
                              <td> <?= $result_select_type['name'] ?></td>
                            </tr>
                        <?php }
                        } ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12 mt-4">
                    <input type="submit" value="บันทึกข้อมูล" class="btn btn-primary btn-sm float-end">
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div class="card card-default my-5">
            <div class="card-header">
              <h3 class="card-title">ค่าเทอมค่าใช้จ่ายทั้งหมด</h3>
            </div>
            <div class="table-responsive card-body p-0">
              <table class="table table-bordered  table table-hover table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th scope="col">ลำดับ</th>
                    <th scope="col">ระดับชั้น</th>
                    <th scope="col">ปีการศึกษา</th>
                    <th scope="col">ค่าเทอม</th>
                    <th scope="col">รายละเอียด</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($term_fees)) { ?>
                    <tr class="outline-tr">
                      <td colspan="5" class="text-muted">ยังไม่มีรายการ</td>
                    </tr>
                  <?php } else { ?>
                    <?php $number = 1;
                    foreach ($term_fees as $value) { ?>
                      <tr class="outline-tr">
                        <th scope="row"><?= $number++ ?></th>
                        <td><?= $value['class'] ?></td>
                        <td><?= $value['year'] ?></td>
                        <td><?= $value['term_fees'] ?></td>
                        <td>
                          <form action="detail_orderPayterm.php" method="post">
                            <input type="hidden" value="<?= $value['id'] ?>" name="id">
                            <button type="submit" class="btn btn-primary btn-sm">รายละเอียด</button>
                          </form>
                      </tr>
                    <?php $number++;
                    } ?>
                  <?php } ?>
                </tbody>
              </table>

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
    $('#form-add').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: '../backend/setting/term_save.php',
        data: $('#form-add').serialize(),
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

    var id = 0;

    function show_modal(e) {
      id = e.dataset.id
      $.ajax({
        url: '../backend/setting/term_show_detail.php',
        data: {
          id: id
        },
        type: 'POST',
        dataType: 'JSON',
        success: function(res) {
          console.log(res['data_product']);
          $('#term_fees-show').val(res['data_finance'].term_fees)
          $('#class-show').val(res['data_finance'].class)
          $('#year-show').val(res['data_finance'].year)
          $('#product_expenses-show').val(res['data_finance'].product_expenses)
          $('#id-show').val(id)
          $('#html_product_list-show').html(res['html_product_list'])
        }
      })
    }

    function link_detail() {
      window.location.href = 'add_order_cost.php?id=' + id;
    }

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

  <script>
    var checkAll = document.getElementById('checkAll');
    var checkList = document.getElementById('finance_order');

    var number = 0;
    checkAll.addEventListener('click', chceklist);


    function chceklist() {
      var form_element = document.forms[0].length;
      number++;
      if (number % 2 == 0) {
        for (i = 0; i < form_element - 1; i++) {
          document.forms[0].elements[i].checked = true;
        }
      } else {
        for (i = 0; i < form_element - 1; i++) {
          document.forms[0].elements[i].checked = false;
        }
      }
    }
  </script>
</body>

</html>