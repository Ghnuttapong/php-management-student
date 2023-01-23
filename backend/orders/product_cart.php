<?php
include '../function.php';
$conn = new db;
if (isset($_POST['p_id'])) {
    $cart = $_POST['p_id'];
}

$html = '';
$order = 0; // order number loop
$new_pay = 0; // find paid
// sent to frontend
$product_id_arr = array();
$i = 0;
if (!empty($cart)) {
    foreach ($cart as $data) {
        // find detail product
        $product_detail = $conn->select_manual('products', ['*'], ['id'], [$data]);
        // find category product
        $category_detail = $conn->select_manual('category', ['name'], ['id'], [$product_detail['category_id']]);
        array_push($product_id_arr, $product_detail['id']);
        $new_pay += $product_detail['price'];
        $html .= '<tr>';
        $html .= '<td>' . ++$order . '</td>';
        $html .= '<td>' . $product_detail['code'] . '</td>';
        $html .= '<td>' . $product_detail['name'] . '</td>';
        $html .= '<td>' . $product_detail['detail']  . '</td>';
        $html .= '<td>' . $category_detail['name'] . '</td>';
        $html .= '<td>' . $product_detail['price']  . '</td>';
        $html .= '<td class="d-flex justify-content-center"> ';
        $html .= '<button type="button" onclick="decrease_product(this)" data-index=' . $product_detail['id'] . ' class="btn btn-danger px-3 mx-1 fw-bold delete_order" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" id="">-</button>';
        $html .= '</td>';
        $html .= '</tr>';
    }
} else {
    // if empty product 
    $html .= '<tr>';
    $html .= '<td class="text-center" colspan="7"> ';
    $html .= 'ไม่พบรายการ';
    $html .= '</td>';
    $html .= '</tr>';
}
// sum price
$html .= '<tr>';
$html .= '<td colspan="7" class="text-right">';
if (!empty($cart)) {
    $html .=    'รวมเป็นเงิน : ' . number_format($new_pay, 2) . ' บาท';
} else {
    $html .=    'รวมเป็นเงิน : ' . number_format(0, 2) . ' บาท';
}
$html .= '</td>';
$html .= '</tr>';

echo json_encode(['html' => $html, 'id_arr' => $product_id_arr]);

?>