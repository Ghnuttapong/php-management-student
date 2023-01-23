<?php

    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;

        $year = $_POST['year'];
        $class = $_POST['class'];
        $term_fees = $_POST['term_fees'];
        $finance_order = $_POST['finance_order'];

        
        $check = $conn->select_count_where('finances', ['year', 'class'], [$year, $class]);
        if($check > 0) {
            http_response_code(400);
            echo 'มีค่าเทอมปีนี้อยู่ในระบบแล้ว';
            return;
        }

        $finance_order_arr = array();
        $finance_expenses = 0;
        $count_finance_order = count($finance_order);
        for($i = 0; $i < $count_finance_order; $i++) {
            $find_detail_finance = $conn->select_manual('products', ['*'], ['id'], [$finance_order[$i]]); 
            array_push($finance_order_arr, $find_detail_finance['id']);
            $finance_expenses += $find_detail_finance['price'];
        }
        $finance_order_encode = json_encode($finance_order_arr);

        $result = $conn->insert('finances', 
        ['year', 'class', 'term_fees', 'product_list', 'product_expenses'], 
        [$year, $class, $term_fees, $finance_order_encode, $finance_expenses ]);

        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
        }

        http_response_code(200);
        echo 'เพิ่มข้อมูลค่าเทอมสำเร็จ';
    } else {
        http_response_code(405);
        echo 'Method not allowed';
    }


?>