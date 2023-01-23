<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 10; ?>
<?php

include '../backend/function.php';
$conn = new db;
//category
$category_arr = $conn->select_manaul_field('category', ['*']);
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
                            <h1 class="m-0 fw-bold">ตั้งค่าทั่วไป</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="setting_general.php">กลับ</a></li>
                                <li class="breadcrumb-item active">ตั้งค่าทั่วไป</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="d-flex justify-content-end">
                        <button data-bs-toggle="modal" data-bs-target="#modal_add" type="button" class="btn btn-primary my-2">+ เพิ่ม</button>
                    </div>

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">เพิ่มลบแก้ไข ตัวเลือก ประเภทรายการสินค้า</h3>
                        </div>
                        <div class="table-responsive card-body p-0">
                            <table class="table table-bordered  table table-hover table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 70%;">ประเภท</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($category_arr)) { ?>
                                        <tr class="outline-tr">
                                            <td colspan="2" class="text-muted">ยังไม่มีรายการ</td>
                                        </tr>
                                    <?php } else { ?>
                                        <?php foreach ($category_arr as $value) { ?>
                                            <tr class="outline-tr">
                                                <td><?= $value['name'] ?></td>
                                                <td>
                                                    <button data-bs-toggle="modal" data-bs-target="#modal_detail" onclick="show_modal(this)" data-id="<?= $value['id'] ?>" type="button" class="btn btn-warning text-white btn-sm">แก้ไข</button>
                                                </td>
                                            </tr>
                                        <?php  }  ?>
                                    <?php  } ?>
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

    <!-- Modal -->
    <div class="modal fade" id="modal_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มประเภทสินค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-add">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <p>ประเภทที่จะเพิ่ม</p>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="type" id="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขประเภทสินค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-edit">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <p>ประเภทสินค้า</p>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="type" id="type-show" class="form-control">
                                <input type="hidden" name="id" id="id-show" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-warning text-white">แก้ไข</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include("linkframework/js.php"); ?>

    <script>
        $('#form-add').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '../backend/setting/g_cate_save.php',
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

        function show_modal(e) {
            let id = e.dataset.id
            $.ajax({
                url: '../backend/setting/g_cate_show_detail.php',
                data: {
                    id: id
                },
                type: 'POST',
                dataType: 'JSON',
                success: function(res) {
                    $('#type-show').val(res.name)
                    $('#id-show').val(id)
                }
            })
        }

        $('#form-edit').submit(function(e) {
            e.preventDefault()
            $.ajax({
                url: '../backend/setting/g_cate_update.php',
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

</body>

</html>