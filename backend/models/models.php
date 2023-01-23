<?php 

    include '../function.php';
    $conn = new db;

    //role
    $role_arr = $conn->select_is_not_null('models', 'role');

    //status_study
    $status_study_arr = $conn->select_is_not_null('models', 'status_study');

    //year
    $year_arr = $conn->select_is_not_null('models', 'year');

    //class
    $class_arr = $conn->select_is_not_null('models', 'class');

    //status_expenses
    $status_expnses = $conn->select_is_not_null('models', 'status_expenses');

    //status_pay
    $status_pay_arr = $conn->select_is_not_null('models', 'status_pay');

    $category_arr = $conn->select_manaul_field('category', ['*']);
?>