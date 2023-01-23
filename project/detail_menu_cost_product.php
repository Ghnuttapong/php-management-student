<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$_SESSION['user_role']  == "admin" ? '' : header("Location: index.php");
$page_nav = 5;
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : false;
date_default_timezone_set("Asia/bangkok");
?>

<?php
require_once("../backend/function.php");
$conn = new db;
$id = isset($_GET['id']) ? $_GET['id'] : header("Location: menu_cost_product.php");
$result = $conn->select_belong('products', 'users', 'products.* , users.fullname', 'products.user_id = users.id', ['products.id'], [$id]);
$result_select_type = $conn->select_manual('category', ['*'], ['id'], [$result['category_id']]);
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
              <h1 class="m-0 fw-bold">ข้อมูลสินค้า</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="menu_cost_product.php">กลับ</a></li>
                <li class="breadcrumb-item active">ข้อมูลสินค้า</li>
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
          // print_r($result);
          // echo "</pre>";
          ?>
          <form id="form_update_product" method="post">
            <div class="d-flex justify-content-between align-items-center">
              <p class="mb-0">เเก้ไขล่าสุด <?php $orgDate = $result['updated_at'];
                                            $newDate = date("d-m-Y H:i:s", strtotime($orgDate));
                                            echo   $newDate . "   " . $result['fullname'];   ?> </p>
              <div>
                <?php if ($is_edit) { ?>
                  <a class="btn btn-secondary  mx-2" href="detail_menu_cost_product.php?id=<?= $result['id'] ?>">ยกเลิก</a>
                  <button type="submit" name="submit_datail-product" class="btn btn-primary">บันทึก</button>
                <?php } else { ?>
                  <a class="btn btn-dark px-3" href="detail_menu_cost_product.php?is_edit=1&id=<?= $result['id'] ?>">เเก้ไขข้อมูล</a>
                <?php } ?>
              </div>
            </div>
            <div class="box_add_edit_form">
              <div class="header d-flex justify-content-between align-items-center">
                <p class="mb-0">ข้อมูลสินค้า</p>
                <div class="position-relative dropstart">
                  <button class="btn " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v text-white"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#delete_product_cost"><i class="fas fa-trash-alt"></i> ลบรายการนี้</a></li>
                  </ul>
                </div>
              </div>
              <div class="content row">
                <input type="hidden" name="id" value="<?= $result['id'] ?>">

                <p class="mb-2 fw-bold col-md-2">หมายเลขรายการสินค้า</p>
                <div class="col-md-3 mb-3 ">
                  <?php if ($is_edit == false) { ?>
                    <?= $result['code']; ?>
                  <?php } else { ?>
                    <input type="text" class="form-control" name="code" required value="<?= $result['code'] ?>">
                  <?php } ?>
                </div>

                <p class="mb-2 fw-bold col-md-1">ชื่อ</p>
                <div class="col-md-6 mb-3 ">
                  <?php if ($is_edit == false) { ?>
                    <?= $result['name']; ?>
                  <?php } else { ?>
                    <input type="text" class="form-control" name="name" required value="<?= $result['name']; ?>">
                  <?php } ?>
                </div>

                <p class="mb-2 fw-bold col-md-2">ประเภท</p>
                <div class="col-md-3 mb-3 ">
                  <?php if ($is_edit == false) { ?>
                    <?= $result_select_type['name']; ?>
                  <?php } else { ?>
                    <select class="form-select" aria-label="Default select example" name="category_id">
                      <option disabled>ประเภทสินค้า/ค่าใช้จ่าย</option>
                      <?php foreach ($result_select_Alltype as $data) { ?>
                        <option <?= $data['name'] == $result_select_type['name'] ? ' selected' : '' ?> value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
                      <?php } ?>
                    </select>
                  <?php } ?>
                </div>

                <p class="mb-2 fw-bold col-md-1">ราคา</p>
                <div class="col-md-6 mb-3 ">
                  <?php if ($is_edit == false) {
                    $price = $result['price'];
                  ?>
                    <?= number_format($price, 2) . " บาท"; ?>
                  <?php } else { ?>
                    <input type="text" class="form-control" name="price" value="<?= $result['price'] ?>">
                  <?php } ?>
                </div>

                <p class="mb-2 fw-bold col-md-2">รายระเอียด</p>
                <div class="col-md-10 mb-3">
                  <?php if ($is_edit == false) { ?>
                    <?= $result['detail']; ?>
                  <?php } else { ?>
                    <textarea class="form-control " placeholder="" id="floatingTextarea2" style="height: 100px" name="detail"><?= $result['detail'] ?></textarea>
                  <?php } ?>
                </div>

                <p class="mb-2 fw-bold col-md-2">สถานะ</p>
                <div class="col-md-4 mb-3">
                  <?php if ($is_edit == false) { ?>
                    <?php if ($result['status'] == "true") { ?>
                      <p class="text-success mb-0 fw-bold">เปิดการใช้งาน</p>
                    <?php } else { ?>
                      <p class="text-danger mb-0 fw-bold">ปิดการใช้งาน</p>
                    <?php } ?>
                  <?php } else { ?>
                    <select class="form-select" aria-label="Default select example" name="status">
                      <?php if ($result['status'] == "true") { ?>
                        <option value="true" selected>เปิดการใช้งาน</option>
                        <option value="false">ปิดการใช้งาน</option>
                      <?php } else { ?>
                        <option value="true">เปิดการใช้งาน</option>
                        <option value="false" selected>ปิดการใช้งาน</option>
                      <?php } ?>
                    </select>
                  <?php } ?>
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



  <!-- Modal -->
  <div class="modal fade" id="delete_product_cost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" id="form_delete_product" method="post">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">ลบรายการสินค้า/รายจ่าย</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" value="<?= $result['id'] ?>" name="id">
          <p>คุณต้องการลบ สินค้า/รายจ่าย <span class="fw-bold"> <?= $result['name'] ?> </span> ใช่หรือไม่</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" class="btn btn-danger px-3">ลบ</button>
        </div>
      </form>
    </div>
  </div>

  <?php include("linkframework/js.php"); ?>
  <script>
    var form_update = document.getElementById("form_update_product");
    var form_delete = document.getElementById("form_delete_product");

    form_delete.addEventListener("submit", async (e) => {
      e.preventDefault();
      const Formdata = new FormData(form_delete);

      if (form_delete.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      } else {
        const data = await fetch("../backend/products/delete.php", {
          method: "POST",
          body: Formdata
        })
        const res = await data.text();
        if (res == "ลบข้อมูลสำเร็จ") {
          Swal.fire({
            icon: 'success',
            title: res,
          })
          setInterval(() => {
            location.assign("menu_cost_product.php");
          }, 2000);
        } else {
          Swal.fire({
            icon: 'error',
            title: res,
          })
          setInterval(() => {
            location.assign("menu_cost_product.php");
          }, 2000);
        }
      }
    })
    form_update.addEventListener("submit", async (e) => {
      e.preventDefault();
      const Formdata = new FormData(form_update);

      if (form_update.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      } else {
        const data = await fetch("../backend/products/update.php", {
          method: "POST",
          body: Formdata
        })
        const res = await data.text();
        if (res == "อัพเดทข้อมูลสินค้าสำเร็จ") {
          Swal.fire({
            icon: 'success',
            title: res,
          })
          setInterval(() => {
            location.assign("detail_menu_cost_product.php?id=<?= $result['id'] ?>");
          }, 1000);
        } else {
          Swal.fire({
            icon: 'error',
            title: res,
          })
          setInterval(() => {
            location.assign("detail_menu_cost_product.php?id=<?= $result['id'] ?>");
          }, 1000);
        }
      }
    })
  </script>
</body>

</html>