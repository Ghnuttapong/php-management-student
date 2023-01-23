<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$_SESSION['user_role']  == "admin" ? '' : header("Location: index.php");
$page_nav = 5; ?>

<?php
require_once("../backend/function.php");
$conn = new db;
$result_show_pd = $conn->select_manaul_field('products ORDER BY category_id, code ASC', ['*']);
$result_select_Alltype = $conn->select_manaul_field('category', ['*']);
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
              <h1 class="m-0 fw-bold">จัดการรายการสินค้า/ค่าใช้จ่าย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">จัดการรายการสินค้า/ค่าใช้จ่าย</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="header_menu_cost">
            <form action="" class="d-flex align-items-center form-search-menucost mt-2" id="search_product" method="post">
              <input type="hidden" name="page_forread" value="1">
              <select class="form-select" aria-label="Default select example" name="select_type" id="select_type">
                <option disabled selected value="ทั้งหมด">ประเภทสินค้า/ค่าใช้จ่าย</option>
                <option value="ทั้งหมด">ทั้งหมด</option>
                <?php foreach ($result_select_Alltype as $data) { ?>
                  <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
                <?php } ?>
              </select>
              <div class="input-group mx-2">
                <input type="text" class="form-control" placeholder="ค้นหารายการสินค้า/ค่าใช้จ่าย" name="keyword">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
              </div>
            </form>
            <a href="add_menu_cost_product.php" class="px-2 btn btn-primary mt-2 ">
              + เพิ่มรายการ
            </a>
          </div>

          <div class="list_menu_cost" id="list_menu_cost">
            <!-- //content -->
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>

  </div>
  <!-- ./wrapper -->

  <?php include("linkframework/js.php"); ?>
  <script>
    var select_type = document.getElementById("select_type");
    var search_product = document.getElementById("search_product");


    select_type.addEventListener("change", () => {
      show_product();
    })


    search_product.addEventListener("submit", (e) => {
      e.preventDefault();
      show_product();
    });



    const show_product = async (e) => {

      const formData = new FormData(search_product);
      formData.append("read_product", 1);

      const data = await fetch("../backend/search_all/search_all.php", {
        method: "POST",
        body: formData
      })
      const response = await data.text();
      document.getElementById("list_menu_cost").innerHTML = response;
    }

    show_product();
  </script>
</body>

</html>