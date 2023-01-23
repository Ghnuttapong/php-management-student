<?php
require_once("../backend/function.php");
require_once("../backend/connect.php");
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 3;
$order_code = isset($_GET['order_code']) ? $_GET['order_code'] : header("Location: management_order_term.php");
$edit_cost = isset($_GET['edit_cost']) ? $_GET['edit_cost'] : false;

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
$select_type = isset($_GET['select_type']) ? $_GET['select_type'] : "ทั้งหมด";

$conn = new db;
// finde user
$result_select_Alltype = $conn->select_manaul_field('category', ['*']);
try {
  if ($keyword == "" &&  $select_type == "ทั้งหมด") {
    $sql = "SELECT * FROM products";
  } else if ($keyword != "" && $select_type == "ทั้งหมด") {
    $sql = "SELECT * FROM products WHERE name LIKE '%$keyword%' OR code LIKE '%$keyword%'";
  } else if ($keyword == "" && $select_type != "ทั้งหมด") {
    $sql = "SELECT * FROM products WHERE category_id LIKE '%$select_type%'";
  } else if ($keyword != "" &&  $select_type != "ทั้งหมด") {
    $sql = "SELECT * FROM products WHERE category_id LIKE '%$select_type%' AND name LIKE '%$keyword%' OR code LIKE '%$keyword%'";
  }

  $select = $obj->prepare($sql);
  $select->execute();
  $num = $select->rowCount();
  $result_show_pd = $select->fetchAll();
} catch (Exception $e) {
  // echo "ไม่มีรายการที่ต้องการ";
}

// search product order_code in order_finance. set data to loop show in table.
$std_arr = $conn->select_manual('order_finance', ['*'], ['order_code'], [$order_code]);
$product_list = json_decode($std_arr['p_id'], true);
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
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 fw-bold">เพิ่มเเก้ไขรายการจ่ายค่าเทอมค่าใช้จ่าย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="detailExpenses.php?id=<?= $std_arr['std_id'] ?>">กลับ</a></li>
                <li class="breadcrumb-item active">เพิ่มเเก้ไขรายการจ่ายค่าเทอมค่าใช้จ่าย</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->


      <div class="text-end mx-3 mt-2 gap-3">
        <!-- form product update cart -->
        <form id="<?= $edit_cost == 1? 'form-product-update' : 'form-product-confirm' ?>" method="post">
          <input type="hidden" name="order_code" value="<?= $order_code ?>">
          <a href="detailExpenses.php?id=<?= $std_arr['std_id'] ?>" class="btn btn-secondary">
            ยกเลิก
          </a>
          <button type="submit" class="btn btn-primary">
            บันทึก
          </button>
        </form>
      </div>
      <!-- //for read, can't edit -->
      <div class="box_add_edit_form mb-5 p-0 mx-2">
        <div class="header">
          ค่าใช้จ่ายเเรกเข้าทั้งหมด
        </div>
        <div class="content " style="padding:0px 0px 10px !important;">
          <div class="table-responsive card-body p-0">
            <table class="table table-bordered  table table-hover table-head-fixed text-nowrap">
              <thead>
                <th>ลำดับ</th>
                <th>รหัส</th>
                <th>ชื่อ</th>
                <th>รายละเอียด</th>
                <th>ประเภท</th>
                <th>ราคา</th>
                <th style="width:150px;"></th>
              </thead>
              <!-- ---------------------------------------------------------- show product ------------------------------------------------------------- -->
              <tbody id="show_product">
              </tbody>
              <!-- ---------------------------------------------------------- show product ------------------------------------------------------------- -->
            </table>
          </div>
        </div>
      </div>
      <!-- //for read, can't edit -->

      <div class="mx-3 mb-2">
        <div class="header_menu_cost mt-5">
          <form class="d-flex align-items-center form-search-menucost mt-2" id="search_product">
            <input type="hidden" name="order_code" value="<?= $order_code ?>">
            <select class="form-select" aria-label="Default select example" name="select_type" id="select_type" onChange=selectChange(this.value)>
              <option disabled selected value="ทั้งหมด">ประเภทสินค้า/ค่าใช้จ่าย</option>
              <option value="ทั้งหมด">ทั้งหมด</option>
              <?php foreach ($result_select_Alltype as $data) { ?>
                <option value="<?= $data['id'] ?>" <?= $select_type ==  $data['id'] ? 'selected' : '' ?>><?= $data['name'] ?></option>
              <?php } ?>
            </select>
            <div class="input-group mx-2">
              <input type="text" class="form-control" placeholder="ค้นหารายการสินค้า/ค่าใช้จ่าย" name="keyword" value="<?= $keyword ?>">
              <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
            </div>
          </form>
        </div>

        <div class="list_menu_cost" id="list_menu_cost">
          <?php if ($num > 0) { ?>
            <?php foreach ($result_show_pd as $data) {
              $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$data['category_id']]);
              $price = $data['price'];
            ?>
              <div class="menu_cost_product">
                <div>
                  <p class="mb-1"><?= $data['code'] ?></p>
                </div>
                <div>
                  <p class="mb-0 fs-4 fw-bold"><?= $data['name'] ?></p>
                  <p class="mb-0 fs-4 fw-bold"><?= number_format($price, 2) . " ฿"; ?></p>
                  <p class="mb-0  fw-bold">รายละเอียด : <span><?= $data['detail'] == "" ? '-' : $data['detail']; ?></span></p>
                </div>
                <div class="d-flex justify-content-between flex-wrap">
                  <p class="mb-0  fw-bold mt-1">ประเภท : <span><?= $result_select_type['name'] ?></span></p>
                  <?php
                  if ($data['status'] == 'false') { ?>
                    <button class="px-2 btn btn-secondary mt-1 add_order" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" disabled>รายการนี้ปิดการใช้งานอยู่</button>
                  <?php } else { ?>
                    <button data-id="<?= $data['id'] ?>" onclick="add_product(this)" class="px-2 btn btn-primary mt-1 add_order" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" id="<?= $data['id'] ?>">+เพิ่ม</button>
                  <?php } ?>
                </div>
                <div></div>
              </div>
            <?php }
          } else { ?>
            <p class="text-center fw-bold fs-2">ไม่มีรายการที่ต้องการ</p>
          <?php } ?>
        </div>
      </div>
    </div>

    </section>
    <!-- /.content -->
  </div>

  </div>
  <!-- ./wrapper -->

  <?php include("linkframework/js.php"); ?>
  <!-- script cart -->
  <script>
    /* serarch product */
    function selectChange(val) {
      document.getElementById("search_product").submit();
    }

    /* initail array */
    var product_arr = [];
    <?php if($edit_cost == 1) {  ?>
    <?php foreach ($product_list as $value) { ?>
      product_arr.push(<?= $value['id'] ?>)
    <?php }} ?>
    /* show available product */
    function show_product() {
      $.ajax({
        url: '../backend/orders/product_cart.php',
        type: 'post',
        dataType: 'json',
        data: {
            p_id: product_arr,
        },
        success: function(res) {
          $('#show_product').html(res.html)
          $('.product_list').remove();
          res.id_arr.forEach(id => {
            $('<?= $edit_cost == 1? '#form-product-update' : '#form-product-confirm' ?>').append('<input type="hidden" class="product_list" name="p_id[]" value="' + id + '" />')
          }); 
        },
      })
    }
    show_product();

    /* increase product */
    function add_product(elm) {
      let id = elm.dataset.id;
      product_arr.push(id);
      show_product();
    }

    /* decrease product */
    function decrease_product(elm) {
      let index = elm.closest('tr').rowIndex;
      if (index > -1) {
        product_arr.splice(index - 1, 1); // pop index of array
      }
      show_product();
      $('.product_list').remove();
    }

  </script>

<!-- script form -->
  <script>
    /* wait product update state 1 */
    $('#form-product-update').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: '../backend/orders/product_cart_update.php',
        method: 'Post', 
        data: $('#form-product-update').serialize(),
        success: res => {
          swal.fire({
            icon: 'success',
            title: res,
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = './detailExpenses.php?id=<?= $std_arr['std_id'] ?>'
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

    /* paid state 2 */
    $('#form-product-confirm').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: '../backend/orders/product_cart_add.php',
        method: 'Post', 
        data: $('#form-product-confirm').serialize(),
        success: res => {
          swal.fire({
            icon: 'success',
            title: res,
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = './detailExpenses.php?id=<?= $std_arr['std_id'] ?>'
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