<?php
session_start();
include 'config.php';

if (!empty($_POST['product'])) {
    foreach ($_POST['product'] as $productId => $quantity) {
        $_SESSION['cart'][$productId] = max(1, (int)$quantity); // ป้องกันค่าติดลบ
    }
    $_SESSION['message'] = 'Cart update success';
}

header('Location: ' . $base_url . '/cart.php');
exit();
?>
