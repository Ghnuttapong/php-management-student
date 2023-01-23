<?php
session_start();
include '../backend/function.php';
$conn = new db;
isset($_SESSION['user_fullname']) && isset($_SESSION['user_role']) ? '' : header("Location: alert_check.php");
$page_nav = 3;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = isset($_POST['id']) ? $_POST['id'] : header("Location: detailExpenses.php");
  $list_cost = isset($_POST['list_cost']) ? $_POST['list_cost'] : header("Location: detailExpenses.php?id=" .  $id . "");
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $id = isset($_GET['id']) ? $_GET['id'] : header("Location: detailExpenses.php");
}


$std_arr = $conn->select_belong(
  'students',
  'order_finance',
  'students.*, order_finance.order_code as order_code, order_finance.status as f_status, order_finance.state as f_state, order_finance.pay as f_pay, order_finance.expenses as f_expenses,
    order_finance.p_id as p_id, order_finance.p_expenses as p_expenses, order_finance.p_pay as p_pay',
  'order_finance.std_id = students.id',
  ['order_finance.std_id'],
  [$id]
);

//all cost
$costAll = $std_arr['f_expenses'] + $std_arr['p_expenses'];
$balance = $costAll  - $std_arr['f_pay'];

$dc_product_list = json_decode($std_arr['p_id']);
$product_list = json_decode(json_encode($dc_product_list), true);
$page_status = $std_arr['f_state'];

date_default_timezone_set("Asia/bangkok");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>โรงเรียนอนุบาลร่มเย็น</title>
  <?php if (isset($_GET['fetAll'])  || isset($_POST['btn_printCost'])) { ?>
    <link rel="stylesheet" href="asset/css/print.css" media="print">
  <?php } else { ?>
    <link rel="stylesheet" href="asset/css/print1.css" media="print">
  <?php  } ?>
  <?php include("linkframework/css.php"); ?>
</head>

<body class="py-5">

  <?php if (isset($_GET['fetAll'])) { ?>
    <div class="row px-5 py-2">
      <div class="col-7 mb-4 btn_print">
        <a href="detailExpenses.php?id=<?= $id ?>" class="btn btn-default border-dark px-4">กลับ</a>
        <button onclick="window.print()" class="btn btn-primary">พิมพ์เอกสาร</button>
      </div>
      <p class="col-5 text-end fw-bold mb-4">รายการค่าใช้จ่ายหมด</p>
      <div class="col-10 d-flex align-items-center">
        <img src="asset/image/logoschool.png" class="rounded-circle " style="border: 0.5px solid #000; width:170px ">
        <div class="d-flex flex-column align-items-center ml-4 ">
          <h2 class="mb-1 fw-bold">โรงเรียนอนุบาลร่มเย็น</h2>
          <p class="mb-0">Romyen Kindergarten Chiangmai Thailand</p>
          <p class="mb-0">63/2 หมู่ 1 ถ.เชียงใหม่-สันกำเเพง อ.เมือง จ.เชียงใหม่</p>
          <p class="mb-2">Tel: 0-5311-5695 Fax:0-5385-1042</p>
          <p class="mb-0 fw-bold">"เรือนเพาะชำการศึกษา ของต้นกล้าต้นน้อย"</p>
        </div>
      </div>
      <div class="col-2 d-flex align-items-center">
        <div class="d-flex flex-column  ml-4 ">
          <p class="mb-0">เลขที่: <span class="fw-semibold"><?= $std_arr['order_code'] ?></span></p>
          <p class="mb-0">วันที่: <?= date('d/m/Y') ?></p>
        </div>
      </div>

      <div class="col-12 mt-5">
        <p class="mb-1">ชื่อ-นามสกุล&nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['fullname'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">เลขประจำตัว &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['code'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ระดับชั้น &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['class'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ปีการศึกษา &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['year'] ?></span></p>
      </div>

      <div class="col-12 " style="border: 0.5px solid #000; border-radius: 20px; padding: 0px; overflow:hidden; height:auto;">
        <table class="table table-bordered w-100 height:100">
          <thead>
            <th style="width:8%" class="text-center">ลำดับที่</th>
            <th style="width:82%" class="text-center">รายการ</th>
            <th style=" width:10%" class="text-center">จำนวนเงิน (บาท)</th>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">1</td>
              <td>ค่าเทอมนักศึกษา</td>
              <td class="text-center"><?= number_format($std_arr['f_expenses'], 2) ?></td>
            </tr>
            <?php
            $number = 2;
            foreach ($product_list as $i) { ?>
              <tr>
                <td class="text-center"><?= $number++ ?></td>
                <td><?= $i['name'] ?></td>
                <td class="text-center"><?= number_format($i['price'], 2) ?></td>
              </tr>
            <?php } ?>
          <tfoot>
            <tr>
              <td></td>
              <td>รวมทั้งสิ้น</td>
              <td class="text-center"><?= number_format($costAll, 2) ?></td>
            </tr>
          </tfoot>
          </tbody>
        </table>
      </div>
      <div class="col-12">
        <p class="mt-4"><span class="text-danger fw-semibold">หมายเหตุ*</span> รายการทั้งหมดทั้งหมดเป็นทั้งรายการค่าใช้จ่ายเเละค่าเทอม หากมีข้อผิดพลากหรือต้องการ ชำระค่าใช้จ่ายโปรดติดต่อที่ภายการเงิน</p>
      </div>
    </div>
  <?php } else if (isset($_GET['term'])) { ?>
    <div class="row px-5">
      <div class="col-7 mb-4 btn_print">
        <a href="detailExpenses.php?id=<?= $id ?>" class="btn btn-default border-dark px-4">กลับ</a>
        <button onclick="window.print()" class="btn btn-primary">พิมพ์เอกสาร</button>
      </div>
      <p class="col-5 text-end fw-bold mb-4">ใบเสร็จรับเงิน RECEIPT</p>
      <div class="col-10 d-flex align-items-center">
        <img src="asset/image/logoschool.png" class="rounded-circle " style="border: 0.5px solid #000; width:170px ">
        <div class="d-flex flex-column align-items-center ml-4 ">
          <h2 class="mb-1 fw-bold">โรงเรียนอนุบาลร่มเย็น</h2>
          <p class="mb-0">Romyen Kindergarten Chiangmai Thailand</p>
          <p class="mb-0">63/2 หมู่ 1 ถ.เชียงใหม่-สันกำเเพง อ.เมือง จ.เชียงใหม่</p>
          <p class="mb-2">Tel: 0-5311-5695 Fax:0-5385-1042</p>
          <p class="mb-0 fw-bold">"เรือนเพาะชำการศึกษา ของต้นกล้าต้นน้อย"</p>
        </div>
      </div>
      <div class="col-2 d-flex align-items-center">
        <div class="d-flex flex-column  ml-4 ">
          <p class="mb-0">เลขที่: <span class="fw-semibold"><?= $std_arr['order_code'] ?></span></p>
          <p class="mb-0">วันที่: <?= date('d/m/Y') ?></p>
        </div>
      </div>

      <div class="d-flex justify-content-end w-100 mt-5">
        <p class="mb-1 fs-4 " style="border: 1px solid; text-align: center; border-radius: 10px; background: lightgreen;">สำเนา</p>
      </div>
      <div class="col-12 ">
        <p class="mb-1">ได้รับเงินจาก&nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['fullname'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">เลขประจำตัว &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['code'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ระดับชั้น &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['class'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ปีการศึกษา &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['year'] ?></span></p>
      </div>

      <div class="col-12 " style="border: 0.5px solid #000; border-radius: 20px; padding: 0px; overflow:hidden; height:auto;">
        <table class="table table-bordered w-100 height:100">
          <thead>
            <th style="width:8%" class="text-center">ลำดับที่</th>
            <th style="width:62%" class="text-center">รายการ</th>
            <th style=" width:10%" class="text-center">จำนวนเงิน (บาท)</th>
            <th style=" width:10%" class="text-center">จ่ายเเล้ว (บาท)</th>
            <th style=" width:10%" class="text-center">คงเหลือ (บาท)</th>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">1</td>
              <td>ค่าเทอมนักศึกษา</td>
              <td class="text-center"><?= number_format($std_arr['f_expenses'], 2) ?></td>
              <td class="text-center"><?= number_format($std_arr['f_pay'], 2) ?></td>
              <td class="text-center"><?= number_format($std_arr['f_expenses'] - $std_arr['f_pay'], 2) ?></td>
            </tr>
          <tfoot>
            <tr>
              <td class="text-right" colspan="5">รวมทั้งสิ้น : <?= number_format($std_arr['f_expenses'], 2) ?></td>
            </tr>
          </tfoot>
          </tbody>
        </table>
      </div>
      <div class="col-10">
        <p class="mt-4"><span class="text-danger fw-semibold">หมายเหตุ*</span> โปรดเก็บใบเสร็จไว้เพื่อเป็นหลักฐานเเสดงการชำระเงินทุกครั้งชำระเงินเเล้วไม่สามารถเรียกเงินคืนได้</p>
      </div>
      <div class="col-2 text-end">
        <p class="mt-4 mb-2 " style=" text-decoration-line: underline; text-decoration-style: dotted;"><?= $_SESSION['user_fullname'] ?></p>
        <p class="fw-semibold">ผู้รับเงิน</p>
      </div>
    </div>

    <hr class="w-100">

    <div class="row mt-2 px-5">
      <p class="col-12 text-end fw-bold mb-4">ใบเสร็จรับเงิน RECEIPT</p>
      <div class="col-10 d-flex align-items-center">
        <img src="asset/image/logoschool.png" class="rounded-circle " style="border: 0.5px solid #000; width:170px ">
        <div class="d-flex flex-column align-items-center ml-4 ">
          <h2 class="mb-1 fw-bold">โรงเรียนอนุบาลร่มเย็น</h2>
          <p class="mb-0">Romyen Kindergarten Chiangmai Thailand</p>
          <p class="mb-0">63/2 หมู่ 1 ถ.เชียงใหม่-สันกำเเพง อ.เมือง จ.เชียงใหม่</p>
          <p class="mb-2">Tel: 0-5311-5695 Fax:0-5385-1042</p>
          <p class="mb-0 fw-bold">"เรือนเพาะชำการศึกษา ของต้นกล้าต้นน้อย"</p>
        </div>
      </div>
      <div class="col-2 d-flex align-items-center">
        <div class="d-flex flex-column  ml-4 ">
          <p class="mb-0">เลขที่: <span class="fw-semibold"><?= $std_arr['order_code'] ?></span></p>
          <p class="mb-0">วันที่: <?= date('d/m/Y') ?></p>
        </div>
      </div>

      <div class="d-flex justify-content-end w-100 mt-5">
        <p class="mb-1 fs-4 " style="border: 1px solid; text-align: center; border-radius: 10px; background: lightgreen;">ฉบับจริง</p>
      </div>
      <div class="col-12 ">
        <p class="mb-1">ได้รับเงินจาก&nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['fullname'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">เลขประจำตัว &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['code'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ระดับชั้น &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['class'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ปีการศึกษา &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['year'] ?></span></p>
      </div>

      <div class="col-12 " style="border: 0.5px solid #000; border-radius: 20px; padding: 0px; overflow:hidden; height:auto;">
        <table class="table table-bordered w-100 height:100">
          <thead>
            <th style="width:8%" class="text-center">ลำดับที่</th>
            <th style="width:62%" class="text-center">รายการ</th>
            <th style=" width:10%" class="text-center">จำนวนเงิน (บาท)</th>
            <th style=" width:10%" class="text-center">จ่ายเเล้ว (บาท)</th>
            <th style=" width:10%" class="text-center">คงเหลือ (บาท)</th>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">1</td>
              <td>ค่าเทอมนักศึกษา</td>
              <td class="text-center"><?= number_format($std_arr['f_expenses'], 2) ?></td>
              <td class="text-center"><?= number_format($std_arr['f_pay'], 2) ?></td>
              <td class="text-center"><?= number_format($std_arr['f_expenses'] - $std_arr['f_pay'], 2) ?></td>
            </tr>
          <tfoot>
            <tr>
              <td class="text-right" colspan="5">รวมทั้งสิ้น : <?= number_format($std_arr['f_expenses'], 2) ?></td>
            </tr>
          </tfoot>
          </tbody>
        </table>
      </div>
      <div class="col-10">
        <p class="mt-4"><span class="text-danger fw-semibold">หมายเหตุ*</span> โปรดเก็บใบเสร็จไว้เพื่อเป็นหลักฐานเเสดงการชำระเงินทุกครั้งชำระเงินเเล้วไม่สามารถเรียกเงินคืนได้</p>
      </div>
      <div class="col-2 text-end">
        <p class="mt-4 mb-2 " style=" text-decoration-line: underline; text-decoration-style: dotted;"><?= $_SESSION['user_fullname'] ?></p>
        <p class="fw-semibold">ผู้รับเงิน</p>
      </div>
    </div>
  <?php } else if (isset($_POST['btn_printCost'])) {
    $id_print = $_POST['list_cost'];
    $count_list = count($id_print);
  ?>

    <div class=" px-5 mb-4 btn_print btnPrint ">
      <a href="detailExpenses.php?id=<?= $id ?>" class="btn btn-default border-dark px-4">กลับ</a>
      <button class="btn btn-primary " id="manuscript">พิมพ์ต้นฉบับ</button>
      <button class="btn btn-primary " id="copy">พิมพ์สำเนา</button>
    </div>

    <div class=" px-5 mb-4 btn_print  refresh">
      <a href="detailExpenses.php?id=<?= $id ?>" class="btn btn-default border-dark px-4">กลับ</a>
      <button class="btn btn-primary " onclick="location.reload()">รีเฟรชหน้า</button>
    </div>

    <div class="row px-5" id="box_copy">
      <p class="col-12 text-end fw-bold mb-4">ใบเสร็จรับเงิน RECEIPT</p>
      <div class="col-10 d-flex align-items-center">
        <img src="asset/image/logoschool.png" class="rounded-circle " style="border: 0.5px solid #000; width:170px ">
        <div class="d-flex flex-column align-items-center ml-4 ">
          <h2 class="mb-1 fw-bold">โรงเรียนอนุบาลร่มเย็น</h2>
          <p class="mb-0">Romyen Kindergarten Chiangmai Thailand</p>
          <p class="mb-0">63/2 หมู่ 1 ถ.เชียงใหม่-สันกำเเพง อ.เมือง จ.เชียงใหม่</p>
          <p class="mb-2">Tel: 0-5311-5695 Fax:0-5385-1042</p>
          <p class="mb-0 fw-bold">"เรือนเพาะชำการศึกษา ของต้นกล้าต้นน้อย"</p>
        </div>
      </div>
      <div class="col-2 d-flex align-items-center">
        <div class="d-flex flex-column  ml-4 ">
          <p class="mb-0">เลขที่: <span class="fw-semibold"><?= $std_arr['order_code'] ?></span></p>
          <p class="mb-0">วันที่: <?= date('d/m/Y') ?></p>
        </div>
      </div>

      <div class="d-flex justify-content-end w-100 mt-5">
        <p class="mb-1 fs-4 " style="border: 1px solid; text-align: center; border-radius: 10px; background: lightgreen;">สำเนา</p>
      </div>
      <div class="col-12 ">
        <p class="mb-1">ได้รับเงินจาก&nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['fullname'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">เลขประจำตัว &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['code'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ระดับชั้น &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['class'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ปีการศึกษา &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['year'] ?></span></p>
      </div>

      <div class="col-12 " style="border: 0.5px solid #000; border-radius: 20px; padding: 0px; overflow:hidden; height:auto;">
        <table class="table table-bordered w-100 height:100">
          <thead>
            <th style="width:8%" class="text-center">ลำดับที่</th>
            <th style="width:62%" class="text-center">รายการ</th>
            <th style=" width:10%" class="text-center">จำนวนเงิน (บาท)</th>
            <th style=" width:10%" class="text-center">จ่ายเเล้ว (บาท)</th>
            <th style=" width:10%" class="text-center">คงเหลือ (บาท)</th>
          </thead>
          <tbody>

            <?php
            $number = 1;
            foreach ($product_list as $data) {
              for ($i = 0; $i < $count_list; $i++) {
                if ($data['id'] == $id_print[$i]) { ?>
                  <tr>
                    <td class="text-center"><?= $number++ ?></td>
                    <td><?= $data['name'] ?></td>
                    <td class="text-center"><?= number_format($data['price'], 2) ?></td>
                    <td class="text-center"><?= number_format($data['pay'], 2) ?></td>
                    <td class="text-center"><?= number_format($data['balance'], 2) ?></td>
                  </tr>
            <?php }
              }
            } ?>
          <tfoot>
            <tr>
              <td class="text-right" colspan="5">รวมทั้งสิ้น : <?= number_format($std_arr['f_expenses'], 2) ?></td>
            </tr>
          </tfoot>
          </tbody>
        </table>
      </div>
      <div class="col-10">
        <p class="mt-4"><span class="text-danger fw-semibold">หมายเหตุ*</span> โปรดเก็บใบเสร็จไว้เพื่อเป็นหลักฐานเเสดงการชำระเงินทุกครั้งชำระเงินเเล้วไม่สามารถเรียกเงินคืนได้</p>
      </div>
      <div class="col-2 text-end">
        <p class="mt-4 mb-2 " style=" text-decoration-line: underline; text-decoration-style: dotted;"><?= $_SESSION['user_fullname'] ?></p>
        <p class="fw-semibold">ผู้รับเงิน</p>
      </div>
    </div>

    <hr class="none-print">

    <div class="row px-5" id="box_manuscript">
      <p class="col-12 text-end fw-bold mb-4">ใบเสร็จรับเงิน RECEIPT</p>
      <div class="col-10 d-flex align-items-center">
        <img src="asset/image/logoschool.png" class="rounded-circle " style="border: 0.5px solid #000; width:170px ">
        <div class="d-flex flex-column align-items-center ml-4 ">
          <h2 class="mb-1 fw-bold">โรงเรียนอนุบาลร่มเย็น</h2>
          <p class="mb-0">Romyen Kindergarten Chiangmai Thailand</p>
          <p class="mb-0">63/2 หมู่ 1 ถ.เชียงใหม่-สันกำเเพง อ.เมือง จ.เชียงใหม่</p>
          <p class="mb-2">Tel: 0-5311-5695 Fax:0-5385-1042</p>
          <p class="mb-0 fw-bold">"เรือนเพาะชำการศึกษา ของต้นกล้าต้นน้อย"</p>
        </div>
      </div>
      <div class="col-2 d-flex align-items-center">
        <div class="d-flex flex-column  ml-4 ">
          <p class="mb-0">เลขที่: <span class="fw-semibold"><?= $std_arr['order_code'] ?></span></p>
          <p class="mb-0">วันที่: <?= date('d/m/Y') ?></p>
        </div>
      </div>

      <div class="d-flex justify-content-end w-100 mt-5">
        <p class="mb-1 fs-4 " style="border: 1px solid; text-align: center; border-radius: 10px; background: lightgreen;">ต้นฉบับ</p>
      </div>
      <div class="col-12 ">
        <p class="mb-1">ได้รับเงินจาก&nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['fullname'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">เลขประจำตัว &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['code'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ระดับชั้น &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['class'] ?></span></p>
      </div>
      <div class="col-4 mt-2">
        <p class="mb-1">ปีการศึกษา &nbsp;&nbsp;&nbsp;&nbsp;<span class="fw-semibold"><?= $std_arr['year'] ?></span></p>
      </div>

      <div class="col-12 " style="border: 0.5px solid #000; border-radius: 20px; padding: 0px; overflow:hidden; height:auto;">
        <table class="table table-bordered w-100 height:100">
          <thead>
            <th style="width:8%" class="text-center">ลำดับที่</th>
            <th style="width:62%" class="text-center">รายการ</th>
            <th style=" width:10%" class="text-center">จำนวนเงิน (บาท)</th>
            <th style=" width:10%" class="text-center">จ่ายเเล้ว (บาท)</th>
            <th style=" width:10%" class="text-center">คงเหลือ (บาท)</th>
          </thead>
          <tbody>

            <?php
            $number = 1;
            foreach ($product_list as $data) {
              for ($i = 0; $i < $count_list; $i++) {
                if ($data['id'] == $id_print[$i]) { ?>
                  <tr>
                    <td class="text-center"><?= $number++ ?></td>
                    <td><?= $data['name'] ?></td>
                    <td class="text-center"><?= number_format($data['price'], 2) ?></td>
                    <td class="text-center"><?= number_format($data['pay'], 2) ?></td>
                    <td class="text-center"><?= number_format($data['balance'], 2) ?></td>
                  </tr>
            <?php }
              }
            } ?>
          <tfoot>
            <tr>
              <td class="text-right" colspan="5">รวมทั้งสิ้น : <?= number_format($std_arr['f_expenses'], 2) ?></td>
            </tr>
          </tfoot>
          </tbody>
        </table>
      </div>
      <div class="col-10">
        <p class="mt-4"><span class="text-danger fw-semibold">หมายเหตุ*</span> โปรดเก็บใบเสร็จไว้เพื่อเป็นหลักฐานเเสดงการชำระเงินทุกครั้งชำระเงินเเล้วไม่สามารถเรียกเงินคืนได้</p>
      </div>
      <div class="col-2 text-end">
        <p class="mt-4 mb-2 " style=" text-decoration-line: underline; text-decoration-style: dotted;"><?= $_SESSION['user_fullname'] ?></p>
        <p class="fw-semibold">ผู้รับเงิน</p>
      </div>
    </div>


  <?php } ?>



  <?php include("linkframework/js.php"); ?>
  <script>
    var mane_script = document.getElementById("manuscript");
    var copy = document.getElementById("copy");
    var box_copy = document.getElementById("box_copy");
    var box_manuscript = document.getElementById("box_manuscript");

    var div_btn = document.querySelector(".btnPrint");
    var refresh = document.querySelector(".refresh");

    refresh.style.display = 'none';


    mane_script.addEventListener('click', () => {
      box_copy.style.display = 'none';
      div_btn.style.display = 'none';
      window.print();
      refresh.style.display = 'block';
    })

    copy.addEventListener('click', () => {
      box_manuscript.style.display = 'none';
      div_btn.style.display = 'none';
      window.print();
      refresh.style.display = 'block';
    })
  </script>
</body>

</html>