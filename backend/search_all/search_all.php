<?php
require_once("../function.php");
require_once("../connect.php");
$conn = new  db;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['read_stdent'])) {
    $select_year = isset($_POST['select_year']) ? $_POST['select_year'] : "ทั้งหมด";
    $select_class = isset($_POST['select_class']) ? $_POST['select_class'] : "ทั้งหมด";
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
    $checknum = 0;

    $sql = "";
    $text = "";
    try {
      if ($keyword == "" && $select_year == "ทั้งหมด" && $select_class == "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id ORDER BY order_finance.state ASC ";
      } else  if ($select_year == "ทั้งหมด" && $select_class != "ทั้งหมด" && $keyword == "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.class LIKE '%$select_class%'  ORDER BY order_finance.state ASC";
      } else  if ($select_year != "ทั้งหมด" && $select_class == "ทั้งหมด" && $keyword == "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.year LIKE '%$select_year%'   ORDER BY order_finance.state ASC";
      } else if ($keyword != "" && $select_year == "ทั้งหมด" && $select_class == "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%'  ORDER BY order_finance.state ASC";
      } else if ($select_year != "ทั้งหมด" &&  $select_class != "ทั้งหมด" && $keyword == "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.class LIKE '%$select_class%' AND students.year LIKE '%$select_year%'     ORDER BY order_finance.state ASC";
      } else if ($select_year != "ทั้งหมด" && $select_class == "ทั้งหมด" && $keyword != "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' AND  students.year LIKE '%$select_year%'   ORDER BY order_finance.state ASC";
      } else if ($select_year == "" ||   $select_year == "ทั้งหมด" &&  $select_class != "ทั้งหมด" && $keyword != "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE   students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' AND  students.class LIKE '%$select_class%'     ORDER BY order_finance.state ASC";
      } else if ($keyword != "" && $select_year != "ทั้งหมด" &&  $select_class != "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE   students.class LIKE students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' AND '%$select_class%' AND  students.year LIKE '%$select_year%'     ORDER BY order_finance.state ASC";
      }


      // $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.fullname LIKE '%เด็กหญิงดาบู ทดสอบ%';  ORDER BY order_finance.state ASC";

      $select = $obj->prepare($sql);
      $select->execute();
      $num = $select->rowCount();
      $result = $select->fetchAll();

      if ($num  > 0) {
        $order = 1;
        foreach ($result as $value) {
          $text .=  "<tr class='outline-tr'>
              <td scope='row'>" .   $order++   . "</td>
              <td> " . $value['code'] . "</td>
              <td> " . $value['fullname'] . "</td>
              <td> " . $value['class'] . "</td>
              <td> " . $value['year'] . "</td>";

          if ($value['f_state'] == 1) {
            $text .= " <td><p class='text-secondary mb-0 fw-bold'>รอยืนยัน</p></td>";
          } else if ($value['f_state'] == 2) {
            $text .= " <td><p class='text-primary mb-0 fw-bold'>กำลังดำเนินการ</p></td>";
          } else if ($value['f_state'] == 3) {
            $text .= " <td><p class='text-success mb-0 fw-bold'>ชำระเงินแล้ว</p></td>";
          } else if ($value['f_state'] == 4) {
            $text .= " <td><p class='text-danger mb-0 fw-bold'>เกินกำหนดชำระ</p></td>";
          }

          if ($value['status'] == 1) {
            $text .= " <td> <p class='text-success mb-0 fw-bold'> กำลังศึกษา </p></td>";
          } else if ($value['status'] == 2) {
            $text .= " <td> <p class='text-danger mb-0 fw-bold'> พ้นสภาพนักเรียน </p></td>";
          } else if ($value['status'] == 3) {
            $text .= " <td> <p class='text-success mb-0 fw-bold'> จบการศึกษา </p></td>";
          }
          $text .=   "<td>
                <a href='detailStudent.php?id=" . $value['id'] . "' class='btn btn-warning btn-sm'>รายละเอียด</a>
              </td>
            </tr>";
        }
        echo json_encode(["text" => $text, "count" => $num]);
      } else {
        $text .= "<tr>
        <td colspan='8' class='text-center' >ไม่มีข้อมูลนักเรียน</td>
        </tr>";
        echo json_encode(["text" => $text, "count" => $num]);
      }
    } catch (Exception $e) {
      echo  $e->getMessage();
      $text .= "<tr>
      <td colspan='8' class='text-center'>error</td>
      </tr>";

      echo json_encode(["text" => $text, "count" => "0"]);
    }
  }

  if (isset($_POST['read_stdent_select_order'])) {
    $select_year = isset($_POST['select_year']) ? $_POST['select_year'] : "";
    $select_class = isset($_POST['select_class']) ? $_POST['select_class'] : "";
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";

    $sql = "";
    $text = "";
    try {
      if ($keyword == "" && $select_year == "ทั้งหมด" && $select_class == "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id ORDER BY order_finance.state ASC ";
      } else  if ($select_year == "ทั้งหมด" && $select_class != "ทั้งหมด" && $keyword == "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.class LIKE '%$select_class%'  ORDER BY order_finance.state ASC";
      } else  if ($select_year != "ทั้งหมด" && $select_class == "ทั้งหมด" && $keyword == "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.year LIKE '%$select_year%'   ORDER BY order_finance.state ASC";
      } else if ($keyword != "" && $select_year == "ทั้งหมด" && $select_class == "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%'  ORDER BY order_finance.state ASC";
      } else if ($select_year != "ทั้งหมด" &&  $select_class != "ทั้งหมด" && $keyword == "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.class LIKE '%$select_class%' AND students.year LIKE '%$select_year%'     ORDER BY order_finance.state ASC";
      } else if ($select_year != "ทั้งหมด" && $select_class == "ทั้งหมด" && $keyword != "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' AND  students.year LIKE '%$select_year%'   ORDER BY order_finance.state ASC";
      } else if ($select_year == "" ||   $select_year == "ทั้งหมด" &&  $select_class != "ทั้งหมด" && $keyword != "") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE   students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' AND  students.class LIKE '%$select_class%'     ORDER BY order_finance.state ASC";
      } else if ($keyword != "" && $select_year != "ทั้งหมด" &&  $select_class != "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE   students.class LIKE students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' AND '%$select_class%' AND  students.year LIKE '%$select_year%'     ORDER BY order_finance.state ASC";
      }

      $select = $obj->prepare($sql);
      $select->execute();
      $num = $select->rowCount();
      $result = $select->fetchAll();

      if ($num  > 0) {
        $order = 1;
        foreach ($result as $data) {
          $text .=  "<tr>
          <td>" . $order++ . "</td>
          <td>" . $data['code'] . "</td>
          <td>" . $data['fullname'] . "</td>
          <td>" . $data['class'] . "</td>
          <td>" . $data['year'] . "</td>
          <td>
            <a href='select_cost_product.php?id=" . $data['id'] . "' class='btn btn-primary px-3' style='--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;'>เลือก</a>
          </td>
        </tr>";
        }
        echo $text;
      } else {
        $text .= "<tr>
        <td colspan='6' class='text-center'>ไม่มีข้อมูลนักเรียน</td>
        </tr>";
        echo $text;
      }
    } catch (Exception $e) {
      echo  $e->getMessage();
      $text .= "<tr>
      <td colspan='6' class='text-center'>error</td>
      </tr>";

      echo $text;
    }
  }

  if (isset($_POST['status1'])) {
    $keyword = isset($_POST['keyword1']) ? $_POST['keyword1'] : "";

    $sql = "";
    $text = "";
    try {
      if ($keyword == "") {
        $sql = "SELECT students.*, order_finance.status as f_status, order_finance.order_code FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE order_finance.state = 1  ORDER BY order_finance.id DESC ";
      } else if ($keyword != "") {
        $sql = "SELECT students.*, order_finance.status as f_status, order_finance.order_code FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE order_finance.state = 1 AND  students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' OR order_finance.order_code LIKE '%$keyword%'      ORDER BY order_finance.id DESC";
      }

      $select = $obj->prepare($sql);
      $select->execute();
      $num = $select->rowCount();
      $result = $select->fetchAll();

      if ($num  > 0) {
        $order = 1;
        foreach ($result as $data) {
          $text .=  "<tr>
          <td style='width:10%;'>" . $order++ . "</td>
          <td>" . $data['code'] . "</td>
          <td>" . $data['order_code'] . "</td>
          <td>" . $data['fullname'] . "</td>
          <td>" . $data['class'] . "</td>
          <td>" . $data['year'] . "</td>
          <td>
            <p class='text-danger mb-0 fw-bold'>รอชำระ</p>
          </td>
          <td>
            <p class='text-secondary mb-0 fw-bold'>รอยืนยัน</p>
          </td>
          <td><a href='detailExpenses.php?&id=" . $data['id'] . "' class='btn btn-primary btn-sm'>รายละเอียด</a></td>
        </tr>";
        }
        echo $text;
      } else {
        $text .= "<tr>
        <td colspan='8' class='text-center'>ไม่มีข้อมูลรายการ</td>
        </tr>";
        echo $text;
      }
    } catch (Exception $e) {
      // echo  $e->getMessage();
      $text .= "<tr>
      <td colspan='8' class='text-center'>error</td>
      </tr>";
      echo $text;
    }
  }

  if (isset($_POST['status2'])) {
    $keyword = isset($_POST['keyword2']) ? $_POST['keyword2'] : "";

    $sql = "";
    $text = "";
    try {
      if ($keyword == "") {
        $sql = "SELECT students.*, order_finance.status as f_status, order_finance.order_code FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE order_finance.state = 2  ORDER BY order_finance.id DESC ";
      } else if ($keyword != "") {
        $sql = "SELECT students.*, order_finance.status as f_status, order_finance.order_code FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE order_finance.state = 2 AND  students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' OR order_finance.order_code LIKE '%$keyword%'      ORDER BY order_finance.id DESC";
      }

      $select = $obj->prepare($sql);
      $select->execute();
      $num = $select->rowCount();
      $result = $select->fetchAll();

      if ($num  > 0) {
        $order = 1;
        foreach ($result as $data) {
          $text .=  "<tr>
          <td style='width:10%;'>" . $order++ . "</td>
          <td>" . $data['code'] . "</td>
          <td>" . $data['order_code'] . "</td>
          <td>" . $data['fullname'] . "</td>
          <td>" . $data['class'] . "</td>
          <td>" . $data['year'] . "</td>";
          if ($data['f_status'] == 1) {
            $text .=   " <td>  <p class='text-primary mb-0 fw-bold'>ค้างชำระ</p></td>";
          } else if ($data['f_status'] == 2) {
            $text .=   " <td>  <p class='text-primary mb-0 fw-bold'>จ่ายเเล้วทั้งหมด</p></td>";
          } else if ($data['f_status'] == 3) {
            $text .=   " <td>  <p class='text-danger mb-0 fw-bold'>เลยกำหนด</p></td>";
          } else if ($data['f_status'] == 4) {
            $text .=   " <td>  <p class='text-danger mb-0 fw-bold'>รอชำระ</p></td>";
          }
          $text .=  "<td>
            <p class='text-warning mb-0 fw-bold'>ยืนยันแล้ว</p>
          </td>
          <td><a href='detailExpenses.php?&id=" . $data['id'] . "' class='btn btn-primary btn-sm'>รายละเอียด</a></td>
        </tr>";
        }
        echo $text;
      } else {
        $text .= "<tr>
        <td colspan='8' class='text-center'>ไม่มีข้อมูลรายการ</td>
        </tr>";
        echo $text;
      }
    } catch (Exception $e) {
      // echo  $e->getMessage();
      $text .= "<tr>
      <td colspan='8' class='text-center'>error</td>
      </tr>";
      echo $text;
    }
  }

  if (isset($_POST['status3'])) {
    $keyword = isset($_POST['keyword3']) ? $_POST['keyword3'] : "";

    $sql = "";
    $text = "";
    try {
      if ($keyword == "") {
        $sql = "SELECT students.*, order_finance.status as f_status, order_finance.order_code FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE order_finance.state = 3  ORDER BY order_finance.id DESC ";
      } else if ($keyword != "") {
        $sql = "SELECT students.*, order_finance.status as f_status, order_finance.order_code FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE order_finance.state = 3 AND  students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' OR order_finance.order_code LIKE '%$keyword%'      ORDER BY order_finance.id DESC";
      }
      $select = $obj->prepare($sql);
      $select->execute();
      $num = $select->rowCount();
      $result = $select->fetchAll();

      if ($num  > 0) {
        $order = 1;
        foreach ($result as $data) {
          $text .=  "<tr>
          <td style='width:10%;'>" . $order++ . "</td>
          <td>" . $data['code'] . "</td>
          <td>" . $data['order_code'] . "</td>
          <td>" . $data['fullname'] . "</td>
          <td>" . $data['class'] . "</td>
          <td>" . $data['year'] . "</td>";
          if ($data['f_status'] == 1) {
            $text .=   " <td>  <p class='text-primary mb-0 fw-bold'>ค้างชำระ</p></td>";
          } else if ($data['f_status'] == 2) {
            $text .=   " <td>  <p class='text-primary mb-0 fw-bold'>จ่ายเเล้วทั้งหมด</p></td>";
          } else if ($data['f_status'] == 3) {
            $text .=   " <td>  <p class='text-danger mb-0 fw-bold'>เลยกำหนด</p></td>";
          } else if ($data['f_status'] == 4) {
            $text .=   " <td>  <p class='text-danger mb-0 fw-bold'>รอชำระ</p></td>";
          }
          $text .=  "<td>
            <p class='text-success mb-0 fw-bold'>สำเร็จ</p>
          </td>
          <td><a href='detailExpenses.php?&id=" . $data['id'] . "' class='btn btn-primary btn-sm'>รายละเอียด</a></td>
        </tr>";
        }
        echo $text;
      } else {
        $text .= "<tr>
        <td colspan='8' class='text-center'>ไม่มีข้อมูลรายการ</td>
        </tr>";
        echo $text;
      }
    } catch (Exception $e) {
      // echo  $e->getMessage();
      $text .= "<tr>
      <td colspan='8' class='text-center'>error</td>
      </tr>";
      echo $text;
    }
  }

  if (isset($_POST['status4'])) {
    $keyword = isset($_POST['keyword4']) ? $_POST['keyword4'] : "";

    $sql = "";
    $text = "";
    try {
      if ($keyword == "") {
        $sql = "SELECT students.*, order_finance.status as f_status, order_finance.order_code FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE order_finance.state = 4  ORDER BY order_finance.id DESC ";
      } else if ($keyword != "") {
        $sql = "SELECT students.*, order_finance.status as f_status, order_finance.order_code FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE order_finance.state = 4 AND  students.code LIKE '%$keyword%' OR  students.fullname LIKE '%$keyword%' OR  students.nickname LIKE '%$keyword%' OR  students.p_fullname LIKE '%$keyword%' OR  students.phone LIKE '%$keyword%' OR order_finance.order_code LIKE '%$keyword%'      ORDER BY order_finance.id DESC";
      }
      $select = $obj->prepare($sql);
      $select->execute();
      $num = $select->rowCount();
      $result = $select->fetchAll();

      if ($num  > 0) {
        $order = 1;
        foreach ($result as $data) {
          $text .=  "<tr>
          <td style='width:10%;'>" . $order++ . "</td>
          <td>" . $data['code'] . "</td>
          <td>" . $data['order_code'] . "</td>
          <td>" . $data['fullname'] . "</td>
          <td>" . $data['class'] . "</td>
          <td>" . $data['year'] . "</td>";
          if ($data['f_status'] == 1) {
            $text .=   " <td>  <p class='text-primary mb-0 fw-bold'>ค้างชำระ</p></td>";
          } else if ($data['f_status'] == 2) {
            $text .=   " <td>  <p class='text-primary mb-0 fw-bold'>จ่ายเเล้วทั้งหมด</p></td>";
          } else if ($data['f_status'] == 3) {
            $text .=   " <td>  <p class='text-danger mb-0 fw-bold'>เลยกำหนด</p></td>";
          } else if ($data['f_status'] == 4) {
            $text .=   " <td>  <p class='text-danger mb-0 fw-bold'>รอชำระ</p></td>";
          }
          $text .=  "<td>
            <p class='text-danger mb-0 fw-bold'>ไม่สำเร็จ</p>
          </td>
          <td><a href='detailExpenses.php?&id=" . $data['id'] . "' class='btn btn-primary btn-sm'>รายละเอียด</a>
        </tr>";
        }
        echo $text;
      } else {
        $text .= "<tr>
        <td colspan='8' class='text-center'>ไม่มีข้อมูลรายการ</td>
        </tr>";
        echo $text;
      }
    } catch (Exception $e) {
      // echo  $e->getMessage();
      $text .= "<tr>
      <td colspan='8' class='text-center'>error</td>
      </tr>";
      echo $text;
    }
  }

  if (isset($_POST['read_product'])) {
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
    $select_type = isset($_POST['select_type']) ? $_POST['select_type'] : "ทั้งหมด";
    $page_forread = isset($_POST['page_forread']) ? $_POST['page_forread'] : "";

    $text = "";
    $sql = "";

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
      $result = $select->fetchAll();

      if ($page_forread == 1) {
        if ($num > 0) {
          http_response_code(200);
          foreach ($result as $data) {
            $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$data['category_id']]);
            $price = $data['price'];

            $text .= "
      <div class='menu_cost_product'>
      <div>
      <p class='mb-1'>" . $data['code'] . "</p>
      </div>
      <div>
      <p class='mb-0 fs-4 fw-bold'>" . $data['name'] . "</p>
      <p class='mb-0 fs-4 fw-bold'>" . number_format($price, 2) . " ฿" . "</p>";
            if ($data['detail'] == "") {
              $text .= " <p class='mb-0  fw-bold'>รายละเอียด : <span>-</span></p>";
            } else {
              $text .= " <p class='mb-0  fw-bold'>รายละเอียด : <span>" . $data['detail'] . "</span></p>";
            }
            $text .= "</div>
      <div class='d-flex justify-content-between flex-wrap'>
      <p class='mb-0  fw-bold mt-1'>ประเภท : <span>" . $result_select_type['name'] . "</span></p>
      <a href='detail_menu_cost_product.php?id=" . $data['id'] . "' class='px-2 btn btn-primary mt-1' style='--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;'>รายละเอียด</a>
      </div>
      ";
            $set_class = $data['status'] == 'false' ? "class='status_pd fw-bold'" : "class='status_pd fw-bold d-none'";
            $text .= " <div " . $set_class . "> รายการนี้ปิดใช้งานอยู่ </div>
      </div>";
          }
        } else {
          http_response_code(400);
          echo "<p class='text-center fw-bold fs-2'>ไม่มีรายการที่ต้องการ </p>";
        }
      }

      echo $text;
    } catch (Exception $e) {
      http_response_code(500);
      echo "ไม่มีรายการที่ต้องการ";
    }
  }

  if (isset($_POST['text_search_order'])) {
    $class = isset($_POST['class']) ? $_POST['class'] : false;
    $year = isset($_POST['year']) ? $_POST['year'] : false;

    $sql = "";
    $text = "";
    try {
      if ($class) {
        $detail_finance = $conn->select_manual("finances", ["*"], ["class", "year"], [$class, $year]);
        $product = json_decode($detail_finance['product_list']);
        $position = 0;
        if (count($product) > 0) {
          foreach (range(1, count($product)) as $row) {
            $detile_cost = $conn->select_manual("products", ["*"], ["id"], [$product[$position++]]);
            $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$detile_cost['category_id']]);
            $text .= "<tr>";
            $text .= "<td><input type='checkbox' id='product_id' name='product_id[]' value='" . $detile_cost['id']  . "' checked> </td>
            <td>" . $detile_cost['code'] . "</td>
            <td>" . $detile_cost['name'] . "</td>
            <td>" . $detile_cost['price'] . "</td>
            <td>" . $detile_cost['detail'] . "</td>
            <td>" . $result_select_type['name'] . "</td>";
            $text .= "</tr>";
          }
        } else {
          $text .= "<tr><td colspan='6' class='text-center'>ไม่รายการข้อมูลที่ต้องการ</td></tr>";
        }
        echo $text;
      } else {
        $sql = "SELECT * FROM products";
        $select = $obj->prepare($sql);
        $select->execute();
        $numcount = $select->rowCount();
        $result = $select->fetchAll();

        if ($numcount > 0) {
          foreach ($result as $data) {
            $result_select_type = $conn->select_manual('category', ['*'], ['id'], [$data['category_id']]);
            $text .= "<tr>";
            $text .= "<td><input type='checkbox' id='product_id' name='product_id[]' value='" . $data['id']  . "' checked> </td>
              <td>" . $data['code'] . "</td>
              <td>" . $data['name'] . "</td>
              <td>" . $data['price'] . "</td>
              <td>" . $data['detail'] . "</td>
              <td>" . $result_select_type['name'] . "</td>";
            $text .= "</tr>";
          }
        } else {
          $text .= "<tr><td colspan='6' class='text-center'>ไม่รายการข้อมูลที่ต้องการ</td></tr>";
        }
        echo $text;
      }
    } catch (PDOException $e) {
      http_response_code(500);
      echo "Error: " . $e->getMessage();
    }
  }

  if (isset($_POST['searchReport'])) {
    $select_year = $_POST['select_year'];
    $select_class = $_POST['select_class'];

    $sql = "";
    $text = "";

    try {
      if ($select_year == "ทั้งหมด" &&  $select_class == "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id";
      } else  if ($select_year == "ทั้งหมด" &&  $select_class != "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.class LIKE '%$select_class%'";
      } else  if ($select_year != "ทั้งหมด" &&  $select_class == "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.year LIKE '%$select_year%'";
      } else  if ($select_year != "ทั้งหมด" &&  $select_class != "ทั้งหมด") {
        $sql = "SELECT students.*, order_finance.state as f_state FROM students INNER JOIN order_finance ON order_finance.std_id = students.id WHERE  students.year LIKE '%$select_year%' AND students.class LIKE '%$select_class%'";
      }


      $select = $obj->prepare($sql);
      $select->execute();
      $row_count = $select->rowCount();
      $result = $select->fetchAll();

      $state1 = 0;
      $state2 = 0;
      $state3 = 0;
      $state4 = 0;

      foreach ($result as $row) {
        if ($row['f_state'] == 1) {
          $state1 += 1;
        } else if ($row['f_state'] == 2) {
          $state2 += 1;
        } else if ($row['f_state'] == 3) {
          $state3 += 1;
        } else if ($row['f_state'] == 4) {
          $state4 += 1;
        }
      }

      $text = " <div class='card-body '>
      <div class='row'>
        <div class='col-md-2'>
          <p class='mb-0 fw-bold'>วันที่</p>
        </div>
        <div class='col-md-10 mb-3'>
          " . date('d-m-Y') . "
        </div>
        <div class='col-md-2'>
          <p class='mb-0 fw-bold'>นักเรียนทั้งหมด</p>
        </div>
        <div class='col-md-10 mb-3'>
          " . $row_count . " คน
        </div>
        <div class='col-md-2'>
          <p class='mb-0 fw-bold'>จ่ายแล้วทั้งหมด</p>
        </div>
        <div class='col-md-10 mb-3'>
          " . $state3 . " คน
        </div>
        <div class='col-md-2'>
          <p class='mb-0 fw-bold'>ที่ค้างชำระ</p>
        </div>
        <div class='col-md-10 mb-3'>
        " . $state2 . " คน
        </div>
        <div class='col-md-2'>
          <p class='mb-0 fw-bold'>รอชำระ</p>
        </div>
        <div class='col-md-10 mb-3'>
        " . $state1 . " คน
        </div>
        <div class='col-md-2'>
          <p class='mb-0 fw-bold'>เกินกำหนด</p>
        </div>
        <div class='col-md-10 mb-3'>
        " . $state4 . " คน
        </div>
      </div>
    </div>";

      // echo json_encode($result);
      echo $text;
    } catch (PDOException $e) {
      http_response_code(500);
      echo "ERROR SERVER" . $e->getMessage();
    }
  }
}
