<?php
session_start();
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 3;
$id = isset($_GET['id']) ? $_GET['id'] : header("Location: management_order_term.php");
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : false;
$is_pay_cost = isset($_GET['is_pay_cost']) ? $_GET['is_pay_cost'] : false;
?>
<?php
$student_1 = 'กำลังศึกษา';
$student_2 = 'พ้นสภาพนักเรียน';
$student_3 = 'จบการศึกษา';
include '../backend/function.php';
$conn = new db;
$std_arr = $conn->select_belong(
    'students',
    'order_finance',
    'students.*,order_finance.std_id as std_id, order_finance.order_code as order_code, order_finance.status as f_status, order_finance.state as f_state, order_finance.pay as f_pay, order_finance.expenses as f_expenses,
    order_finance.p_id as p_id, order_finance.p_expenses as p_expenses, order_finance.p_pay as p_pay',
    'order_finance.std_id = students.id',
    ['order_finance.std_id'],
    [$id]
);



//all cost
$costAll = $std_arr['f_expenses'];
$balance = $costAll  - $std_arr['f_pay'];

$dc_product_list = json_decode($std_arr['p_id']);
$product_list = json_decode(json_encode($dc_product_list), true);

$page_status = $std_arr['f_state'];
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
                            <h1 class="m-0 fw-bold">รายการจ่ายค่าเทอมค่าใช้จ่าย</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="management_order_term.php">กลับ</a></li>
                                <li class="breadcrumb-item active">รายการจ่ายค่าเทอมค่าใช้จ่าย</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <section class="content">
                <form class="container-fluid" id="form-update" method="post">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <?php
                            if ($page_status == 1) { ?>
                                <button class="btn btn-primary px-4" type="button" onclick="confirm_finance(this)" data-id="<?= $std_arr['id'] ?>">ยืนยัน</button>
                                <a class="btn btn-dark px-4" href="print_all.php?id=<?= $id ?>&fetAll=1">ออกบิลรายการทั้งหมด</a>
                                <button type="button" class="btn btn-danger px-4" data-id="<?= $std_arr['id'] ?>" onclick="close_finance(this)">ปิดการชำระ</button>
                            <?php  } else if ($page_status == 2) { ?>
                                <?php if ($is_pay_cost == false) {
                                    if ($is_edit) { ?>
                                        <a class="btn btn-secondary  mx-2" href="detailExpenses.php?id=<?= $std_arr['id'] ?>">ยกเลิก</a>
                                        <input type="submit" class="btn btn-primary" value="บันทึก">
                                        <input type="hidden" name="order_code" value="<?= $std_arr['order_code'] ?>">
                                        <input type="hidden" name="id" value="<?= $std_arr['std_id'] ?>">
                                    <?php } else { ?>
                                        <a class="btn btn-secondary px-3" href="detailExpenses.php?is_edit=1&id=<?= $std_arr['id'] ?>">จ่ายค่าเทอม</a>
                                        <a class="btn btn-dark px-4" href="print_all.php?id=<?= $id ?>&term=1">ออกบิลค่าเทอม</a>
                                        <button type="button" class="btn btn-danger px-4" data-id="<?= $std_arr['id'] ?>" onclick="close_finance(this)">ปิดการชำระ</button>
                                <?php }
                                } ?>
                            <?php  } else if ($page_status == 3) { ?>
                                <a class="btn btn-dark px-4" href="print_all.php?id=<?= $id ?>&term=1">ออกบิลค่าเทอม</a>
                            <?php    } else if ($page_status == 4) { ?>
                                <a class="btn btn-dark px-4" href="print_all.php?id=<?= $id ?>&fetAll=1">ออกบิลรายการทั้งหมด</a>
                            <?php    } ?>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-12">
                            <div class="card" style="border: 1px solid;">
                                <div class="card-header bg-white d" style="border-bottom: 1px solid;">
                                    <div class=" d-flex  justify-content-between flex-wrap">
                                        <p class="mb-1 fw-bold">รายการจ่ายค่าเทอม | เลขที่รายการ <?= $std_arr['order_code'] ?></p>
                                        <p class="mb-1">แก้ไขล่าสุด <?= date('d-m-Y H:i:s', strtotime($std_arr['updated_at'])) ?> <?= $std_arr['user_fullname'] ?></p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row pt-3">
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">ชื่อ - นามสกุล</p>
                                        </div>
                                        <div class="col-xl-4">
                                            <p><?= $std_arr['fullname'] ?></p>
                                        </div>
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">เลขประจำตัว</p>
                                        </div>
                                        <div class="col-xl-4">
                                            <p><?= $std_arr['code'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pt-3">
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">ปีการศึกษา</p>
                                        </div>
                                        <div class="col-xl-4">
                                            <p><?= $std_arr['year'] ?></p>
                                        </div>
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">ระดับชั้น</p>
                                        </div>
                                        <div class="col-xl-4">
                                            <p><?= $std_arr['class'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pt-3">
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">ชื่อผู้ปกครอง</p>
                                        </div>
                                        <div class="col-xl-10">
                                            <p><?= $std_arr['p_fullname'] ?></p>
                                        </div>

                                    </div>
                                    <div class="row pt-3">
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">เบอร์ติดต่อผู้ปกครอง</p>
                                        </div>
                                        <div class="col-xl-4">
                                            <p><?= $std_arr['phone'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pt-3">
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold ">สถานะการจ่ายเงิน</p>
                                        </div>
                                        <div class="col-xl-4">
                                            <?php if ($std_arr['f_status'] == 1) { ?>
                                                <p class="fw-semibold text-primary"><?= "ค้างชำระ" ?></p>
                                            <?php } elseif ($std_arr['f_status'] == 2) { ?>
                                                <p class="fw-semibold text-success"><?= "จ่ายเเล้วทั้งหมด" ?></p>
                                            <?php } elseif ($std_arr['f_status'] == 3) { ?>
                                                <p class="fw-semibold text-danger"><?= "เกินกำหนดชำระ" ?></p>
                                            <?php } elseif ($std_arr['f_status'] == 4) { ?>
                                                <p class="fw-semibold text-danger"><?= "รอชำระ" ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">สถานะการเรียน</p>
                                        </div>
                                        <div class="col-xl-4">
                                            <?php if ($std_arr['status'] == 1) { ?>
                                                <p class="fw-semibold text-success"><?= $student_1 ?></p>
                                            <?php } elseif ($std_arr['status'] == 2) { ?>
                                                <p class="fw-semibold text-danger"><?= $student_2 ?></p>
                                            <?php } elseif ($std_arr['status'] == 3) { ?>
                                                <p class="fw-semibold text-success"><?= $student_3 ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row pt-3">
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">ค่าเทอม</p>
                                        </div>
                                        <div class="col-xl-4">
                                            <p><?= number_format($std_arr['f_expenses'], 2) ?> บาท</p>
                                        </div>
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">ค่าใช้จ่าย</p>
                                        </div>
                                        <div class="col-xl-4">
                                            <p><?= number_format($std_arr['p_expenses'], 2) ?> บาท</p>
                                        </div>
                                    </div>
                                    <div class="row pt-3">
                                        <?php if ($is_edit == 1) { ?>
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">จำนวนที่ต้องการจ่าย</p>
                                            </div>
                                            <div class="col-xl-4">
                                                <input required type="number" class="form-control" name="pay" id="update_pay" value="">
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-xl-2">
                                                <p class="mb-0 fw-bold">ยอดจ่ายค่าเทอม</p>
                                            </div>
                                            <div class="col-xl-4">
                                                <p><?= number_format($std_arr['f_pay'], 2) ?> บาท</p>
                                            </div>
                                        <?php } ?>
                                        <div class="col-xl-2">
                                            <p class="mb-0 fw-bold">คงเหลือ</p>
                                        </div>
                                        <div class="col-xl-4 ">
                                            <p><?= number_format($balance, 2) ?> บาท</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- form pay cost -->
                <form id="<?= $is_pay_cost ?  'form-pay-cost' : 'pay-cost' ?>" action="<?= $is_pay_cost ?  '' : 'print_all.php' ?>" method="POST">
                    <?php if ($page_status == 2) {
                        if (!$is_edit) { ?>
                            <div class="text-end mx-3 mt-2 gap-2">
                                <?php if ($is_pay_cost) { ?>
                                    <a class="btn btn-secondary px-4" href="detailExpenses.php?id=<?= $id ?>">ยกเลิก</a>
                                    <input type="submit" value="บันทึก" class="btn btn-primary px-4">
                                    <input type="hidden" name="order_code" value="<?= $std_arr['order_code'] ?>">
                                    <input type="hidden" name="id" value="<?= $std_arr['std_id'] ?>">
                                <?php } else { ?>
                                    <input type="hidden" name="id" value="<?= $std_arr['id'] ?>">
                                    <a class="btn btn-secondary px-4" href="detailExpenses.php?is_pay_cost=1&id=<?= $id ?>">จ่ายค่าใช้จ่าย</a>
                                    <input class="btn btn-dark px-4" type="submit" value="ออกบิลค่าใช้จ่าย" name="btn_printCost">
                                    <a href="edit_update_cost.php?order_code=<?= $std_arr['order_code'] ?>&edit_cost=2" class="btn btn-primary">
                                        +เพิ่มรายการ
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } else if ($page_status == 3) { ?>
                        <div class="text-end mx-3 mt-2 gap-2">
                            <input type="hidden" name="id" value="<?= $std_arr['id'] ?>">
                            <input class="btn btn-dark px-4" type="submit" value="ออกบิลค่าใช้จ่าย" name="btn_printCost">
                            <a href="edit_update_cost.php?order_code=<?= $std_arr['order_code'] ?>&edit_cost=2" class="btn btn-primary">
                                +เพิ่มรายการ
                            </a>
                        </div>
                    <?php } else if ($page_status == 1) { ?>
                        <div class="text-end mx-3 mt-2 gap-2">
                            <a href="edit_update_cost.php?order_code=<?= $std_arr['order_code'] ?>&edit_cost=1" class="btn btn-primary">
                                เเก้ไขรายการ
                            </a>
                        </div>
                    <?php  } ?>

                    <div class="box_add_edit_form mb-5 p-0 mx-2">
                        <div class="header">
                            ค่าใช้จ่ายเเรกเข้าทั้งหมด
                        </div>
                        <div class="content " style="padding:0px 0px 10px !important;">
                            <div class="table-responsive card-body p-0 mb-3 border-bottom" style=" max-height:600px; overflow-y:auto;">
                                <table class="table table-bordered  table table-hover table-head-fixed text-nowrap w-100">
                                    <thead>
                                        <?php if ($page_status == 2  || $page_status == 3) {
                                            if (!$is_pay_cost) { ?>
                                                <th style="width:10%;"> <input type="checkbox" id="checkAll" class="mb-0"> เลือกรายการที่ต้องการปริ้น</th>
                                        <?php }
                                        } ?>
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
                                        <?php
                                        $number_list = 1;
                                        foreach ($product_list as $data) {
                                            $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$data['type']]);
                                        ?>

                                            <!-- check pay cost -->
                                            <?php if ($is_pay_cost) { ?>

                                                <!-- check status -->
                                                <?php if ($data['status']) { ?>
                                                    <input type="hidden" name="product_pay[]" placeholder="กรอกจำนวนที่ต้องการจ่าย.." value="<?= $data['pay'] ?>" class="form-control">
                                                <?php continue;
                                                } ?>
                                                <tr>
                                                    <td><?= $number_list++ ?></td>
                                                    <td><?= $data['code'] ?></td>
                                                    <td><?= $data['name'] ?></td>
                                                    <td><?= $data['detail'] ?></td>
                                                    <td><?= $result_select_type['name'] ?></td>
                                                    <td><?= number_format($data['price'], 2) ?></td>
                                                    <td>
                                                        <input type="number" name="product_pay[]" placeholder="กรอกจำนวนที่ต้องการจ่าย.." class="form-control">
                                                    </td>
                                                    <td><?= $data['balance'] ?></td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <?php if ($page_status == 2  || $page_status == 3) { ?>
                                                        <td>
                                                            <input type="checkbox" name="list_cost[]" value="<?= $data['id'] ?>" id="list_cost">
                                                        </td>
                                                    <?php } ?>
                                                    <td><?= $number_list++ ?></td>
                                                    <td><?= $data['code'] ?></td>
                                                    <td><?= $data['name'] ?></td>
                                                    <td><?= $data['detail'] ?></td>
                                                    <td><?= $result_select_type['name'] ?></td>
                                                    <td><?= number_format($data['price'], 2) ?></td>
                                                    <td class="<?= $data['status'] ? 'text-success' : 'text-danger' ?>"><?= $data['pay'] ?></td>
                                                    <td><?= $data['balance'] ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
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
                </form>
            </section>
        </div>
        <!-- /.content -->

    </div>
    <!-- ./wrapper -->

    <?php include("linkframework/js.php"); ?>
    <script>
        function confirm_finance(elm) {
            let id = elm.dataset.id
            $.ajax({
                url: '../backend/orders/term_confirm.php',
                type: 'POST',
                data: {
                    student_id: id
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: res,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.assign('./detailexpenses.php?id=<?= $id ?>');
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
        }

        function close_finance(elm) {
            let id = elm.dataset.id
            Swal.fire({
                title: 'ปิดการชำระ',
                text: "คุณต้องการปิดการชำระใช่หรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../backend/orders/term_close.php',
                        type: 'POST',
                        data: {
                            student_id: id
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: res,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.assign('./detailexpenses.php?id=<?= $id ?>');
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
                }
            })
        }

        // จ่ายเงิน
        $('#form-update').submit(e => {
            e.preventDefault();
            $.ajax({
                url: '../backend/orders/term_pay.php',
                method: 'Post',
                data: $('#form-update').serialize(),
                dataType: 'json',
                success: res => {
                    swal.fire({
                        icon: 'success',
                        title: res.msg,
                        text: res.reduce
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.assign('./detailexpenses.php?id=<?= $id ?>');
                        }
                    })
                },
                error: err => {
                    swal.fire({
                        icon: 'error',
                        title: err.responsetext,
                    })
                }
            })

        })

        function complete_finance(elm) {
            let id = elm.dataset.id
            $.ajax({
                url: '../backend/orders/term_complete.php',
                type: 'POST',
                data: {
                    student_id: id,
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: res,
                    })
                    setTimeout(function() {
                        window.location.href = 'detailExpenses.php?id=' + id;
                    }, 1500)
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: err.responseText,
                    })
                }
            })
        }

        $('#form-pay-cost').submit(e => {
            e.preventDefault();
            $.ajax({
                url: '../backend/orders/pay_cost.php',
                method: 'Post',
                data: $('#form-pay-cost').serialize(),
                success: res => {
                    swal.fire({
                        icon: 'success',
                        title: res,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.assign('./detailexpenses.php?id=<?= $id ?>');
                        }
                    })
                },
                error: err => {
                    swal.fire({
                        icon: 'error',
                        title: err.responsetext,
                    })
                }
            })
        })
    </script>
    <script>
        var checkAll = document.getElementById('checkAll');
        var checkList = document.getElementById('list_cost');

        var number = 0;
        checkAll.addEventListener('click', chceklist);


        function chceklist() {
            var form_element = document.forms[1].length;
            console.log(form_element);
            number++;
            if (number % 2 == 0) {
                for (i = 0; i < form_element; i++) {
                    document.forms[1].elements[i].checked = true;
                }
            } else {
                for (i = 0; i < form_element; i++) {
                    document.forms[1].elements[i].checked = false;
                }
            }
        }
    </script>
</body>

</html>