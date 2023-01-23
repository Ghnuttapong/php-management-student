<?php
session_start();
unset($_SESSION['send_order']);
unset($_SESSION['data']);
unset($_SESSION['total']);
unset($_SESSION["count_order"]);
unset($_SESSION["student_id"]);
echo "<script>location.assign('../../project/order_cost_product.php');</script>";
