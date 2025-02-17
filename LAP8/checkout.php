<?php
session_start();
include 'config.php';

// ตรวจสอบและกำหนดค่าให้ตะกร้าสินค้า
$cart_items = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];

// ตรวจสอบโครงสร้างของสินค้าในตะกร้า
foreach ($cart_items as $key => $item) {
    if (!is_array($item) || !isset($item['product_name']) || !isset($item['price'])) {
        unset($cart_items[$key]); // ลบรายการที่โครงสร้างไม่ถูกต้อง
    }
}

// คำนวณราคารวม
$total_price = !empty($cart_items) ? array_sum(array_column($cart_items, 'price')) : 0;

// ส่วนลดโปรโมชั่น
$promo_code = "EXAMPLECODE";
$discount = 5;
if (isset($_POST['promo']) && $_POST['promo'] === $promo_code) {
    $total_price -= $discount;
}

// ตรวจสอบการสั่งซื้อ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fullname'])) {
    $fullname = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';

    echo "<div class='container mt-5'>";
    echo "<h2 class='text-success'><i class='fa-solid fa-circle-check'></i> การสั่งซื้อสำเร็จ!</h2>";
    echo "<p><strong>ชื่อเต็ม:</strong> " . htmlspecialchars($fullname) . "</p>";
    echo "<p><strong>เบอร์โทร:</strong> " . htmlspecialchars($phone) . "</p>";
    echo "<p><strong>อีเมล:</strong> " . htmlspecialchars($email) . "</p>";

    echo "<h2 class='mt-4'><i class='fa-solid fa-cart-shopping'></i> รายการสินค้า</h2>";
    if (!empty($cart_items)) {
        echo "<ul class='list-group'>";
        foreach ($cart_items as $item) {
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
            echo "<span>" . htmlspecialchars($item['product_name']) . "</span>";
            echo "<span class='badge bg-primary'>$" . number_format($item['price'], 2) . "</span>";
            echo "</li>";
        }
        echo "</ul>";
        echo "<p class='mt-3'><strong>รวมทั้งหมด:</strong> $" . number_format($total_price, 2) . "</p>";
    } else {
        echo "<p class='text-danger'>ไม่มีสินค้าในตะกร้า</p>";
    }
    echo "</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KIT.js" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2><i class="fa-solid fa-cart-shopping"></i> Checkout</h2>
            <p class="lead">กรอกข้อมูลเพื่อดำเนินการสั่งซื้อ</p>
        </div>

        <div class="row">
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">ข้อมูลลูกค้า</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label for="fullname" class="form-label"><i class="fa-solid fa-user"></i> ชื่อเต็ม:</label>
                        <input type="text" class="form-control" name="fullname" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label"><i class="fa-solid fa-phone"></i> เบอร์โทร:</label>
                        <input type="text" class="form-control" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="fa-solid fa-envelope"></i> อีเมล:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <h4 class="mt-4"><i class="fa-solid fa-cart-plus"></i> ตะกร้าสินค้า</h4>
                    <ul class="list-group mb-3">
                    <?php 
                    $grand_total = 0; 
                    if (!empty($cart_items)): 
                        foreach ($cart_items as $item): 
                            $grand_total += $item['price']; 
                    ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0"><?php echo htmlspecialchars($item['product_name']); ?></h6>
                                <input type="number" name="product[<?php echo $item['id']; ?>]" value="<?php echo $_SESSION['cart'][$item['id']]; ?>" class="form-control" min="1">
                            </div>
                            <span class="text-muted">$<?php echo number_format($item['price'], 2); ?></span>
                        </li>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-danger">ไม่มีสินค้าในตะกร้า</li>
                    <?php endif; ?>
                    </ul>

                    <div class="mb-3">
                        <label for="promo" class="form-label"><i class="fa-solid fa-tag"></i> โค้ดส่วนลด:</label>
                        <input type="text" class="form-control" name="promo" placeholder="EXAMPLECODE">
                    </div>

                    <h4 class="mb-3">รวมทั้งหมด: <span class="text-success">$<?php echo number_format($grand_total, 2); ?></span></h4>

                    <button class="btn btn-success btn-lg w-100" type="submit">
                        <i class="fa-solid fa-credit-card"></i> สั่งซื้อ
                    </button>
                </form>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2025 OTEROBOT</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
