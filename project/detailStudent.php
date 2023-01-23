<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 1;
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : false;
$id = isset($_GET['id']) ? $_GET['id'] : header("Location: index.php");
?>

<?php
include '../backend/function.php';
$student_1 = 'กำลังศึกษา';
$student_2 = 'พ้นสภาพนักเรียน';
$student_3 = 'จบการศึกษา';
$conn = new db;
$year_arr = $conn->select_manaul_field('finances ORDER BY id DESC limit 1', ['*']);
$class_arr = $conn->select_manaul_field('finances GROUP BY class', ['*']);
$std_arr = $conn->select_belong(
    'students',
    'order_finance',
    'students.*, order_finance.order_code as order_code, order_finance.status as f_status, order_finance.state as f_state, order_finance.pay as f_pay, order_finance.expenses as f_expenses,
    order_finance.p_id as p_id, order_finance.p_expenses as p_expenses, order_finance.p_pay as p_pay',
    'order_finance.std_id = students.id',
    ['order_finance.std_id'],
    [$id]
);

$dc_product_list = json_decode($std_arr['p_id']);
$product_list = json_decode(json_encode($dc_product_list), true);
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
                            <h1 class="m-0 fw-bold p-0">ข้อมูลนักเรียน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">กลับ</a></li>
                                <li class="breadcrumb-item active">ข้อมูลนักเรียน</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <form id="form-edit" class="row">
                        <div class="col-12 d-flex flex-row-reverse">
                            <!-- <a href="" class="btn btn-dark btn-sm px-4">แก้ไข</a> -->
                            <?php if ($is_edit) { ?>
                                <a class="btn btn-secondary  mx-2" href="detailStudent.php?id=<?= $id ?>">ยกเลิก</a>
                                <button type="submit" name="submit_datail-product" class="btn btn-primary">บันทึก</button>
                            <?php } else { ?>

                                <a class="btn btn-primary px-3 mx-2" href="upgrade.php?id_upgrade=<?= $id ?>">เลื่อนชั้น</a>
                                <a class="btn btn-warning px-3 mx-2" href="detailExpenses.php?id=<?= $id ?>">รายละเอียดการชำระ</a>
                                <a class="btn btn-dark px-3" href="detailStudent.php?is_edit=1&id=<?= $id ?>">เเก้ไขข้อมูล</a>
                            <?php } ?>
                        </div>
                        <div class="row g-2 pr-0">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-dark" style="margin-top: -1px;">
                                        <div class="row g-0">
                                            <div class="d-flex flex-wrap justify-content-between">
                                                <div class="mx-2">
                                                    <p class="mb-0">ข้อมูลนักศึกษา</p>
                                                </div>
                                                <div class="">
                                                    <p class="mb-0">แก้ไขล่าสุด <?= date("d-m-Y H:i:s", strtotime($std_arr['updated_at'])) ?> <?= $std_arr['user_fullname'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="border-bottom: 1px solid;">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="mb-0 text-secondary">ข้อมูลนักศึกษา</p>
                                            </div>
                                        </div>
                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">เลขประจำตัวนักเรียน</p>
                                            </div>
                                            <div class="col-xl-10">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" class="form-control" name="code" value="<?= $std_arr['code'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['code'] ?></p>
                                                <?php } ?>

                                            </div>
                                        </div>


                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">คำนำหน้า</p>
                                            </div>
                                            <div class="col-xl-4">
                                                <?php if ($is_edit) { ?>
                                                    <select class="form-select" aria-label="Default select example" name="prefix">
                                                        <option <?= $std_arr['prefix'] == 'เด็กหญิง' ? 'selected' : '' ?> value="เด็กหญิง">เด็กหญิง</option>
                                                        <option <?= $std_arr['prefix'] == 'เด็กชาย' ? 'selected' : '' ?> value="เด็กชาย">เด็กชาย</option>
                                                    </select>
                                                <?php } else { ?>
                                                    <p><?= $std_arr['prefix'] ?></p>
                                                <?php } ?>

                                            </div>
                                            <div class="col-xl-1 pr-0">

                                                <p class="mb-0 fw-bold">ชื่อ</p>
                                            </div>
                                            <div class="col-xl-2 ">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" class="form-control" name="firstname" value="<?= $std_arr['firstname'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['firstname'] ?></p>
                                                <?php } ?>
                                            </div>
                                            <div class="col-xl-1 pr-0 ">
                                                <p class="mb-0 fw-bold">นามสกุล</p>
                                            </div>
                                            <div class="col-xl-2">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" class="form-control" name="lastname" value="<?= $std_arr['lastname'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['lastname'] ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>


                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">ชื่อ-นามสกุล</p>
                                            </div>
                                            <div class="col-xl-4">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" disabled class="form-control" name="" value="<?= $std_arr['fullname'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['fullname'] ?></p>
                                                <?php } ?>
                                            </div>
                                            <div class="col-xl-1 pr-0">
                                                <p class="mb-0 fw-bold">ชื่อเล่น</p>
                                            </div>
                                            <div class="col-xl-5">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" class="form-control" name="nickname" value="<?= $std_arr['nickname'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['nickname'] ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">ระดับชั้น</p>
                                            </div>
                                            <div class="col-xl-4">
                                                <?php if ($is_edit) { ?>
                                                    <select class="form-select" aria-label="Default select example" name="class">
                                                        <?php foreach ($class_arr as $value) { ?>
                                                            <option <?= $value['class'] == $std_arr['class'] ? 'selected' : '' ?> value="<?= $value['class'] ?>"><?= $value['class'] ?></option>
                                                        <?php  } ?>
                                                    </select>
                                                <?php } else { ?>
                                                    <p><?= $std_arr['class'] ?></p>
                                                <?php } ?>
                                            </div>
                                            <div class="col-xl-1">
                                                <p class="mb-0 fw-bold ">ปีการศึกษา</p>
                                            </div>
                                            <div class="col-xl-5">
                                                <?php if ($is_edit) { ?>
                                                    <select class="form-select" aria-label="Default select example" name="year">
                                                        <?php foreach ($year_arr as $value) { ?>
                                                            <option value="<?= $value['year'] ?>"><?= $value['year'] ?></option>
                                                        <?php  } ?>
                                                    </select>
                                                <?php } else { ?>
                                                    <p><?= $std_arr['year'] ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="row pt-4">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">สถานะ</p>
                                            </div>
                                            <div class="col-xl-4">
                                                <?php if ($is_edit) { ?>
                                                    <select class="form-select" aria-label="Default select example" name="status">
                                                        <option <?= $std_arr['status'] == 1 ? 'selected' : '' ?> value="1">กำลังศึกษาอยู่</option>
                                                        <option <?= $std_arr['status'] == 2 ? 'selected' : '' ?> value="2">พ้นสภาพนักเรียน</option>
                                                        <option <?= $std_arr['status'] == 3 ? 'selected' : '' ?> value="3">สำเร็จการศึกษา</option>
                                                    </select>
                                                <?php } else { ?>
                                                    <?php if ($std_arr['status'] == 1) { ?>
                                                        <p class="text-success"><?= $student_1 ?></p>
                                                    <?php } else if ($std_arr['status'] == 2) { ?>
                                                        <p class="text-danger"><?= $student_2 ?></p>
                                                    <?php } else if ($std_arr['status'] == 3) { ?>
                                                        <p class="text-success"><?= $student_3 ?></p>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="col-xl-1">
                                                <p class="mb-0 fw-bold">ค่าเทอม</p>
                                            </div>
                                            <div class="col-xl-2">
                                                <p><?= $std_arr['f_expenses'] ?> บาท</p>
                                            </div>
                                            <div class="col-xl-1">
                                                <p class="mb-0 fw-bold">ยอดค่าใช้จ่าย</p>
                                            </div>
                                            <div class="col-xl-2">
                                                <p><?= $std_arr['p_expenses'] ?> บาท</p>
                                            </div>
                                        </div>
                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">สถานะการจ่ายค่าใช้จ่าย | ค่าเทอม</p>
                                            </div>
                                            <div class="col-xl-4">
                                                <p class="text-<?= $std_arr['f_state'] == 1 || $std_arr['f_state'] == 4 ? 'danger' : 'primary' ?>">
                                                    <?= $std_arr['f_state'] == 1 ? 'รอชำระ' : '' ?>
                                                    <?= $std_arr['f_state'] == 2 ? 'ค้างชำระ' : '' ?>
                                                    <?= $std_arr['f_state'] == 3 ? 'จ่ายเเล้วทั้งหมด' : '' ?>
                                                    <?= $std_arr['f_state'] == 4 ? 'เกินกำหนดชำระ' : '' ?>
                                                </p>
                                            </div>
                                            <div class="col-xl-1">
                                                <p class="mb-0 fw-bold">ยอดจ่ายค่าเทอม</p>
                                            </div>
                                            <div class="col-xl-2">
                                                <p><?= $std_arr['f_pay'] ?> บาท</p>
                                            </div>
                                            <div class="col-xl-1">
                                                <p class="mb-0 fw-bold">คงเหลือ</p>
                                            </div>
                                            <div class="col-xl-2">
                                                <p><?= $std_arr['f_expenses']  - $std_arr['f_pay'] ?> บาท</p>
                                            </div>
                                        </div>
                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">หมายเหตุ</p>
                                            </div>
                                            <div class="col-xl-10">
                                                <?php if ($is_edit) { ?>
                                                    <div class="form-floating">
                                                        <textarea class="form-control" id="floatingTextarea2" name="note" style="height: 100px"><?= $std_arr['note'] ?></textarea>
                                                    </div>
                                                <?php } else { ?>
                                                    <p><?= $std_arr['note'] == null ? '-' : $std_arr['note'] ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <p class="mb-0 text-secondary">ข้อมูลผู้ปกครอง</p>
                                            </div>
                                        </div>

                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">คำนำหน้า</p>
                                            </div>
                                            <div class="col-xl-4">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" class="form-control" name="p_prefix" value="<?= $std_arr['p_prefix'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['p_prefix'] ?></p>
                                                <?php } ?>
                                            </div>
                                            <div class="col-xl-1 pr-0">
                                                <p class="mb-0 fw-bold">ชื่อ</p>
                                            </div>
                                            <div class="col-xl-2">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" class="form-control" name="p_firstname" value="<?= $std_arr['p_firstname'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['p_firstname'] ?></p>
                                                <?php } ?>
                                            </div>
                                            <div class="col-xl-1 pr-0">
                                                <p class="mb-0 fw-bold">นามสกุล</p>
                                            </div>
                                            <div class="col-xl-2">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" class="form-control" name="p_lastname" value="<?= $std_arr['p_lastname'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['p_lastname'] ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">ชื่อ-นามสกุล</p>
                                            </div>
                                            <div class="col-xl-4">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" disabled class="form-control" name="" value="<?= $std_arr['p_fullname'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['p_fullname'] ?></p>
                                                <?php } ?>
                                            </div>
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">ความเกี่ยวข้องกับนักศึกษา</p>
                                            </div>
                                            <div class="col-xl-2">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" class="form-control" name="p_relative" value="<?= $std_arr['p_relative'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['p_relative'] ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">เบอร์ติดต่อ</p>
                                            </div>
                                            <div class="col-xl-10">
                                                <?php if ($is_edit) { ?>
                                                    <input type="text" class="form-control" name="phone" value="<?= $std_arr['phone'] ?>">
                                                    <input type="hidden" name="id" value="<?= $std_arr['id'] ?>">
                                                <?php } else { ?>
                                                    <p><?= $std_arr['phone'] ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="row pt-3">
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">ที่อยู่ปัจจุบัน</p>
                                            </div>
                                            <div class="col-xl-10">
                                                <?php if ($is_edit) { ?>
                                                    <div class="form-floating">
                                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="address"><?= $std_arr['address'] ?></textarea>
                                                    </div>
                                                <?php } else { ?>
                                                    <p><?= $std_arr['address'] ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- //for read, can't edit -->
                        <div class="box_add_edit_form mb-5 p-0">
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
                                            <th>จ่ายเเล้ว</th>
                                            <th>คงเหลือ</th>
                                        </thead>

                                        <tbody>
                                            <?php $number = 1;
                                            foreach ($product_list as $data) {
                                                $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$data['type']]);
                                            ?>
                                                <tr>
                                                    <td><?= $number++ ?></td>
                                                    <td><?= $data['code'] ?></td>
                                                    <td><?= $data['name'] ?></td>
                                                    <td><?= $data['detail'] ?></td>
                                                    <td><?= $result_select_type['name'] ?></td>
                                                    <td><?= number_format($data['price'], 2) ?></td>
                                                    <td><?= number_format($data['pay'], 2) ?></td>
                                                    <td><?= number_format($data['balance'], 2) ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="9" class="text-right">
                                                    <p>
                                                        รวมเป็นเงิน : <?= number_format($std_arr['p_expenses'], 2) ?> บาท
                                                    </p>
                                                    <p>
                                                        จ่ายเล้ว : <?= number_format($std_arr['p_pay'], 2) ?> บาท
                                                    </p>
                                                    <p class="mb-0">
                                                        คงเหลือ : <?= number_format($std_arr['p_expenses'] - $std_arr['p_pay'], 2) ?> บาท
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- //for read, can't edit -->
                    </form>
                </div>
            </section>
            <!-- /.content -->
        </div>

    </div>
    <!-- ./wrapper -->

    <?php include("linkframework/js.php"); ?>

    <script>
        $('#form-edit').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '../backend/students/update.php',
                type: 'POST',
                data: $('#form-edit').serialize(),
                success: res => {
                    swal.fire({
                        icon: 'success',
                        title: res,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = './index.php'
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