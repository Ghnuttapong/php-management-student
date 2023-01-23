<?php
session_start();
unset($_SESSION['update_orderAll']);
unset($_SESSION['update_order']);
unset($_SESSION['total_price']);
unset($_SESSION["total_order_success"]);
echo "<script>location.assign('../../project/management_cost_productNew.php?id=" . $_SESSION["order_id"] . "');</script>";
