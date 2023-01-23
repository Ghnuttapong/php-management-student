<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$_SESSION['user_role']  == "admin" ? '' : header("Location: index.php");
$page_nav = 8; ?>
<?php

include '../backend/function.php';
$conn = new db;

$users_arr = $conn->select_manaul_field('users', ['*']);
//role
$role_arr = $conn->select_is_not_null('models', 'role');
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
              <h1 class="m-0 fw-bold">จัดการสมาชิก</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">จัดการสมาชิก</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-6">
              <select class="form-select" id="role-search">
                <option selected disabled value=""> --- เลือกตำแหน่ง --- </option>
                <option value="">ทั้งหมด</option>
                <?php foreach ($role_arr as $value) { ?>
                  <option value="<?= $value['role'] ?>"><?= $value['role'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-3">
            </div>
            <div class="col-3">
              <div class="search">
                <form action="" id="form-search">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="keyword" placeholder="ค้นหารายชื่อสมาชิก" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="row my-2">
            <div class="col-md-12">
              <a href="./management_member_add.php" class="btn btn-primary float-end">+เพิ่มสมาชิก</a>
            </div>
          </div>
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">จัดการสมาชิก</h3>
            </div>
            <div class="table-responsive card-body p-0">
              <table class="table table-bordered  table table-hover table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th scope="col">ลำดับ</th>
                    <th scope="col" style="width: 40%;">ชื่อ-นามสกุล</th>
                    <th scope="col">เบอร์มือถือ</th>
                    <th scope="col">ชื่อผู้ใช้</th>
                    <th scope="col">ตำแหน่ง</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody id="search-show">
                  <!-- loading -->
                  <div class="d-none justify-content-center my-5">
                    <div class="spinner-grow text-secondary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
                  <!-- loading -->
                  <?php if (empty($users_arr)) { ?>
                    <tr class="outline-tr">
                      <td colspan="2" class="text-muted">ยังไม่มีรายการ</td>
                    </tr>
                  <?php return;
                  } ?>
                  <?php $i = 1;
                  foreach ($users_arr as $value) { ?>
                    <?php if ($value['id'] === $_SESSION['user_id']) { ?>
                    <?php continue;
                    } ?>
                    <tr class="outline-tr">
                      <td><?= $i++ ?></td>
                      <td><?= $value['fullname'] ?></td>
                      <td class="<?= $value['phone'] == null ? 'text-muted' : '' ?>"><?= $value['phone'] == null ? 'ไม่ได้ระบุ' : $value['phone'] ?></td>
                      <td><?= $value['username'] ?></td>
                      <td><?= $value['role'] ?></td>
                      <td>
                        <form action="management_member_edit.php" method="post">
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <input type="hidden" name="id" value="<?= $value['id'] ?>">
                              <input type="submit" value="แก้ไข" class="btn btn-warning mb-2 text-white btn-sm">
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <button onclick="delete_id(this)" data-id="<?= $value['id'] ?>" type="button" class="btn btn-danger btn-sm mb-2 " <?= $value['id'] ==   $_SESSION['user_id'] ? 'disabled' : '' ?>>ลบ</button>
                            </div>
                          </div>
                        </form>
                      </td>
                    </tr>
                  <?php  } ?>
                </tbody>
                </tr>
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
    function delete_id(e) {
      let id = e.dataset.id
      Swal.fire({
        title: 'ลบข้อมูลสมาชิก',
        text: "คุณต้องการลบใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '../backend/users/delete.php',
            data: {
              id: id
            },
            type: 'POST',
            success: function(res) {
              Swal.fire({
                text: res,
                icon: 'success',
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.reload()
                }
              })
            }
          })
        }
      })
    }

    $('#role-search').on('change', function(e) {
      $.ajax({
        url: '../backend/users/getbyrole.php',
        type: 'post',
        data: {
          role: this.value
        },
        dataType: 'json',
        success: function(res) {
          let html = ''
          let number = 1;
          for (let i = 0; i < res.length; i++) {
            if (res[i].id == <?= $_SESSION['user_id'] ?>) {
              continue;
            }
            html += `
              <tr class="outline-tr">
                <td>${number++}</td>
                <td>${res[i].fullname}</td>
                <td class="${res[i].phone == null ? 'text-muted' : '' }">${res[i].phone == null ? 'ไม่ได้ระบุ' : res[i].phone}</td>
                <td>${res[i].username}</td>
                <td>${res[i].role}</td>
                <td>
                  <form action="management_member_edit.php" method="post">
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <input type="hidden" name="id" value="${res[i].id}">
                        <input type="submit" value="แก้ไข" class="btn btn-warning mb-2 text-white btn-sm">
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <button onclick="delete_id(this)" data-id="${res[i].id}" type="button" class="btn btn-danger btn-sm mb-2 ">ลบ</button>
                      </div>
                    </div>
                  </form>
                </td>
              </tr>
          `
            $('#search-show').html(html)
          }
        }
      })
    })

    $('#form-search').submit(function(e) {
      e.preventDefault()
      $.ajax({
        url: '../backend/users/getbyname.php',
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
          let html = ''
          let number = 1;
          for (let i = 0; i < res.length; i++) {
            html += `
              <tr class="outline-tr">
                <td>${number++}</td>
                <td>${res[i].fullname}</td>
                <td class="${res[i].phone == null ? 'text-muted' : '' }">${res[i].phone == null ? 'ไม่ได้ระบุ' : res[i].phone}</td>
                <td>${res[i].username}</td>
                <td>${res[i].role}</td>
                <td>
                  <form action="management_member_edit.php" method="post">
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <input type="hidden" name="id" value="${res[i].id}">
                        <input type="submit" value="แก้ไข" class="btn btn-warning mb-2 text-white btn-sm">
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <button onclick="delete_id(this)" data-id="${res[i].id}" type="button" class="btn btn-danger btn-sm mb-2 ">ลบ</button>
                      </div>
                    </div>
                  </form>
                </td>
              </tr>
          `
            $('#search-show').html(html)
          }
        }
      })
    })
  </script>
</body>

</html>