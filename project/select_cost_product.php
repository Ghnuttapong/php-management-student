<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 5; ?>
<?php
require_once("../backend/function.php");
require_once("../backend/connect.php");
$id = isset($_GET['id']) ? $_GET['id'] : '';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
$select_type = isset($_GET['select_type']) ? $_GET['select_type'] : "ทั้งหมด";
$conn = new db;
$result_select_Alltype = $conn->select_manaul_field('category', ['*']);


$_SESSION['student_id'] = $id;

$count = 0;
$_SESSION["count_order"] = isset($_SESSION["count_order"]) ? $_SESSION["count_order"] : 0;
$_SESSION['data'] = isset($_SESSION['data']) ? $_SESSION['data'] : false;

if ($_SESSION['data']) {
  $array = $_SESSION['data'];
  $count  = count($array) > 0  ?  count($array) : 0;
  $_SESSION["count_order"] = $count;
}

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
              <h1 class="m-0 fw-bold">สั่งรายการสินค้า/ค่าใช้จ่าย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="order_cost_product.php">กลับ</a></li>
                <li class="breadcrumb-item active">สั่งรายการสินค้า/ค่าใช้จ่าย</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <?php
          // echo "<pre>";
          // print_r($array);
          // echo "</pre>";
          ?>
          <div class="header_menu_cost">
            <form class="d-flex align-items-center form-search-menucost mt-2" id="search_product">
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
                        <button class="px-2 btn btn-primary mt-1 add_order" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" id="<?= $data['id'] ?>">+เพิ่ม</button>
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

  <div class="cart" onclick="order_send()">
    <div>
      <p class="count_order" id="count_order"><?= $_SESSION["count_order"] ?></p>
      <img src="asset/image/shopping-cart-solid.svg" alt="icon">
    </div>
  </div>

  <?php include("linkframework/js.php"); ?>
  <script>
    $(document).ready(function() {


      var count_order = $('#count_order').text();
      var search_product = $('#search_product');


      if (count_order == 0) {
        $(".cart").hide();
      } else {
        $('.cart').show(100);
      }

      $(".add_order").click(function(e) {
        var mid = $(this).attr("id");
        console.log(mid);
        $.ajax({
          url: "../backend/Setorder/set_session_order.php",
          method: "post",
          data: {
            id: mid
          },
          success: function(response) {
            location.reload();
            // console.log(response);
          }
        });
      });
    });

    function selectChange(val) {
      document.getElementById("search_product").submit();
    }


    const order_send = () => {
      location.assign("order_all_fromselect.php");
    }
  </script>
</body>

</html>