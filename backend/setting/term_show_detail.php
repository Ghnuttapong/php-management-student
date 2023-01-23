<?php

    include '../function.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db;

        $id = $_POST['id'];

        $result = $conn->select_manual('finances', ['*'], ['id'], [$id]);
        $decode_product_list = json_decode($result['product_list']); 
        $count_decode_product_list = count($decode_product_list);
        $html = '';
        for($i = 0; $i < $count_decode_product_list; $i++){
            $product_list = $conn->select_manual('products', ['name', 'price'], ['id'], [$decode_product_list[$i]]);
            $html .= '
                <div class="d-flex justify-content-between">
                  <p class="col-4   mt-2">' . $product_list['name'] . '</p>
                  <p class="col-6 mt-2">'. number_format($product_list['price'], 2) . " ฿" .'</p>
                </div>
                ';
        }
        http_response_code(200);
        echo json_encode(['data_finance' => $result, 'html_product_list' => $html]);
    } else {
        http_response_code(405);
        echo 'Method not allowed';
    }


?>