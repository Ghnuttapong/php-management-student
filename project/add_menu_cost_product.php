<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$_SESSION['user_role']  == "admin" ? '' : header("Location: index.php");
$page_nav = 5;
?>
<?php
require_once("../backend/function.php");
$conn = new db;
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
              <h1 class="m-0 fw-bold">เพิ่มรายการสินค้า/ค่าใช้จ่าย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="menu_cost_product.php">กลับ</a></li>
                <li class="breadcrumb-item active">เพิ่มรายการสินค้า</li>
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
          // print_r($result_select_Alltype);
          // echo "</pre>";
          ?>
          <form method="post" id="form_add_product">
            <div class="d-flex justify-content-end">
              <a href="menu_cost_product.php" class="px-3 btn btn-secondary mx-2">ยกเลิก</a>
              <button type="submit" class="px-3 btn btn-primary" <?php $result_select_Alltype ? '' : 'disabled' ?>>บันทึก</button>
            </div>
            <div class="box_add_edit_form">
              <div class="header">เพิ่มรายการสินค้า</div>
              <div class="content row">

                <p class="mb-2 fw-bold col-md-2">หมายเลขรายการสินค้า</p>
                <div class="col-md-3 mb-3 ">
                  <input type="text" class="form-control" name="code" required>
                </div>

                <p class="mb-2 fw-bold col-md-1">ชื่อ</p>
                <div class="col-md-6 mb-3 ">
                  <input type="text" class="form-control" name="name" required>
                </div>

                <p class="mb-2 fw-bold col-md-2">ประเภท</p>
                <div class="col-md-3 mb-3 ">
                  <select class="form-select" aria-label="Default select example" name="category_id" required>
                    <option disabled value="" selected>ประเภทสินค้า/ค่าใช้จ่าย</option>
                    <?php foreach ($result_select_Alltype as $data) { ?>
                      <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
                    <?php } ?>
                  </select>
                </div>

                <p class="mb-2 fw-bold col-md-1">ราคา</p>
                <div class="col-md-6 mb-3 ">
                  <input type="text" class="form-control" name="price" required>
                </div>

                <p class="mb-2 fw-bold col-md-2">รายระเอียด</p>
                <div class="col-md-10 mb-3">
                  <textarea class="form-control " placeholder="" id="floatingTextarea2" style="height: 100px" name="detail" required></textarea>
                </div>
              </div>
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
    var form_add = document.getElementById("form_add_product");

    form_add.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(form_add);
      formData.append("read_detail_all", 1);

      if (form_add.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      } else {
        const data = await fetch("../backend/products/save.php", {
          method: "POST",
          body: formData
        })
        const response = await data.text();
        if (response == "เพิ่มข้อมูลสินค้าสำเร็จ") {
          Swal.fire({
            icon: 'success',
            title: response,
          })
          form_add.reset();
        } else {
          Swal.fire({
            icon: 'error',
            title: response,
          })
        }
      }
    })

    form_add.addEventListener("keypress", async (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        const formData = new FormData(form_add);
        formData.append("read_detail_all", 1);

        if (form_add.checkValidity() === false) {
          e.preventDefault();
          e.stopPropagation();
          return false;
        } else {
          const data = await fetch("../backend/products/save.php", {
            method: "POST",
            body: formData
          })
          const response = await data.text();
          if (response == "เพิ่มข้อมูลสินค้าสำเร็จ") {
            Swal.fire({
              icon: 'success',
              title: response,
            })
            form_add.reset();
          } else {
            Swal.fire({
              icon: 'error',
              title: response,
            })
          }
        }
      }
    })
  </script>
</body>

</html>