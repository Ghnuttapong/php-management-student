<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$_SESSION['user_role']  == "admin" ? '' : header("Location: index.php");
$page_nav = 8; ?>
<?php

include '../backend/function.php';
$conn = new db;

//role
$role_arr = $conn->select_is_not_null('models', 'role');

$id = isset($_POST['id']) ? $_POST['id'] : header("Location: management_member.php");
$result = $conn->select_manual('users', ['*'], ['id'], [$id]);

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
                                <li class="breadcrumb-item"><a href="./management_member.php">กลับ</a></li>
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
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">แก้ไขสมาชิก</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-edit" method="post">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="prefix">คำนำหน้า <span class="text-danger">*</span></label>
                                        <input required type="text" name="prefix" value="<?= $result['prefix'] ?>" class="form-control mb-3" placeholder="คำนำหน้า">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="firstname">ชื่อ <span class="text-danger">*</span></label>
                                        <input required type="text" name="firstname" value="<?= $result['firstname'] ?>" class="form-control mb-3" placeholder="ชื่อ">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="lastname">นามสกุล <span class="text-danger">*</span></label>
                                        <input required type="text" name="lastname" value="<?= $result['lastname'] ?>" class="form-control mb-3" placeholder="นามสกุล">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="phone">เบอร์ติดต่อ</label>
                                        <input type="text" name="phone" id="phone" value="<?= $result['phone'] ?>" class="form-control mb-3" placeholder="เบอร์ติดต่อ">
                                    </div>
                                    <div class="col-md-8">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="username">ชื่อผู้ใช้ <span class="text-danger">*</span></label>
                                        <input type="text" disabled name="username" value="<?= $result['username'] ?>" class="form-control mb-3" placeholder="ชื่อผู้ใช้">
                                        <input type="hidden" name="id" value="<?= $result['id'] ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="password">รหัสผ่าน <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control mb-3" placeholder="รหัสผ่าน" id="password">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="role">ตำแหน่ง <span class="text-danger">*</span></label>
                                        <select name="role" class="custom-select">
                                            <?php foreach ($role_arr as $value) { ?>
                                                <option <?= $value['role'] === $result['role'] ? 'selected' : '' ?> value="<?= $value['role'] ?>"><?= $value['role'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex gap-2 justify-content-between">
                                        <div>
                                            <input type="checkbox" name="show_password" id="show_password">
                                            <label for="show_password"> เเสดงรหัสผ่าน</label>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="management_member.php" class="btn btn-secondary">ยกเลิก</a>
                                            <input type="submit" value="บันทึกข้อมูล" id="name" class="btn btn-warning text-white">
                                        </div>
                                    </div>
                                </div>
                            </form>
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
        $('#form-edit').submit(e => {
            e.preventDefault();
            $.ajax({
                url: '../backend/users/update.php',
                type: 'post',
                data: $('#form-edit').serialize(),
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: res,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'management_member.php'
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

        var show_password = document.getElementById("show_password");
        var password = document.getElementById("password");

        show_password.addEventListener("click", () => {
            if (show_password.checked == true) {
                password.type = 'text';
            } else if ((show_password.checked == false)) {
                password.type = 'password';
            }
        })
    </script>
</body>

</html>