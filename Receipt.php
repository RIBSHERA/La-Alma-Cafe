<?php
$serverName="TOUGH\SQLEXPRESS";
$connectionOptions=[
    "DATABASE"=>"DLSU",
    "Uid"=>"",
    "PWD"=>""
];
$conn=sqlsrv_connect($serverName,$connectionOptions);
if($conn==false){
    die(print_r(sqlsrv_errors(),true));
}


session_start();

//GETTING THE DATA
$customerName  = $_POST['customer_name'] ;
$paymentMethod = $_POST['payment_method'] ;
$discountType  = $_POST['discount_type'] ;
$cashReceived  = floatval($_POST['cash_received'] );
$dineOption    = $_POST['dine_option'] ;

//DISCOUNTS
$discountRate = 0;
if ($discountType === 'Student') {
    $discountRate = 0.10;
} elseif ($discountType === 'PWD') {
    $discountRate = 0.20;
}

//CHECKING THE CART
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: OrderingSystem.php");
    exit;
}


$total = 0;

foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['qty'];
}

$totalDiscount = $total * $discountRate;
$finalTotal    = $total - $totalDiscount;
$change        = $cashReceived - $finalTotal;

if ($cashReceived < $finalTotal) {
    $_SESSION['error'] = 'Insufficient cash received.';
    header("Location: OrderingSystem.php");
    exit;
}

//INSERTING THE DATA
foreach ($_SESSION['cart'] as $item) {

    $category       = $item['category'];
    $productName    = $item['name'];
    $size           = $item['size'] ?: NULL;
    $price          = $item['price'];
    $qty            = $item['qty'];

    $subtotal       = $item['price'] * $item['qty'];
    $itemDiscount   = $subtotal * $discountRate;
    $finalSubtotal  = $subtotal - $itemDiscount;
    

    $sql1 = "
        INSERT INTO ORDER_TABLE
        (
          CUSTOMER_NAME,
          CATEGORY,
          PRODUCT_NAME,
          SIZE,
          PRICE,
          QTY,
          SUBTOTAL,
          PAYMENT_METHOD,
          DISCOUNT_TYPE,
          DISCOUNT_AMOUNT,
          CASH_RECEIVED,
          CHANGE_AMOUNT,
          DINE_OPTION,
          ORDER_DATE
        )
        VALUES 
        ('$customerName', 
        '$category', 
        '$productName', 
        '$size', 
        '$price', 
        '$qty', 
        '$finalSubtotal', 
        '$paymentMethod', 
        '$discountType', 
        '$itemDiscount', 
        '$cashReceived', 
        '$change', 
        '$dineOption', 
        GETDATE())
    ";

    $resultItem = sqlsrv_prepare($conn, $sql1);
    if (!$resultItem || !sqlsrv_execute($resultItem)) {
        die(print_r(sqlsrv_errors(), true));
    }
}

//GETTING THE DATE/TIME
$sql2 = "
    SELECT TOP 1 ORDER_DATE
    FROM ORDER_TABLE
    ORDER BY ORDER_DATE DESC
";
$resultDate = sqlsrv_query($conn, $sql2);
$rowDate = sqlsrv_fetch_array($resultDate, SQLSRV_FETCH_ASSOC);
$receiptDate = $rowDate['ORDER_DATE']->format("F d, Y h:i A");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Receipt</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: url('Recieptbg.jpg') no-repeat center center fixed;
    background-size: cover;
}

@font-face {
        font-family: 'DroidSansMono';
        src: url('Fonts/DroidSansMono.ttf') format('truetype');
        font-weight: bold;
        font-style: normal;
      }

.receiptbody {
    border: 10px solid #3e64e0ff;
    font-size: 1.5rem;
    font-family: 'DroidSansMono';
    
}
</style>
</head>

    <body>
        <div class="container mt-4">
            <div class="card mx-auto receiptbody" style="max-width:490px;">
                <div class="card-body p-4">

                
                <div class="text-center mb-3">
                    <h1 class="mb-1 ">La Alma Cafe</h1>
                    <small class="text-muted">Gracias Por Ordenar</small>
                    <hr>
                </div>

                <!-- INFO -------------->
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Customer</span><span><?= htmlspecialchars($customerName) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Dine</span><span><?= htmlspecialchars($dineOption) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Payment</span><span><?= htmlspecialchars($paymentMethod) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Discount</span><span><?= htmlspecialchars($discountType) ?></span>
                    </div>
                </div>

                <hr>

                <!-- ITEMS ------------------>
                <ul class="list-group list-group-flush mb-2">
                <?php foreach ($_SESSION['cart'] as $item):
                    $lineSubtotal = $item['price'] * $item['qty'];
                ?>
                <li class="list-group-item px-0 ">
                    <div class="d-flex justify-content-between">
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <span>₱<?= number_format($lineSubtotal,2) ?></span>
                    </div>
                    <small class="text-muted">
                        <?= htmlspecialchars($item['size']) ?> Qty: <?= $item['qty'] ?>
                    </small>
                </li>
                <?php endforeach; ?>
                </ul>

                <hr>

                <!-- TOTALS ------------------->
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span><span>₱<?= number_format($total,2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Discount</span><span>- ₱<?= number_format($totalDiscount,2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span><span>₱<?= number_format($finalTotal,2) ?></span>
                    </div>
                </div>

                <hr>

                <!-- PAYMENT ---------------->
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Cash</span><span>₱<?= number_format($cashReceived,2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Change</span><span>₱<?= number_format($change,2) ?></span>
                    </div>
                </div>

                <hr>

                
                <div class="text-center text-muted small">
                    <?= $receiptDate ?><br>
                    <strong>Thank you!</strong>
                </div>

                <div class="text-center mt-3">
                    <a href="OrderingSystem.php?new_order=1" class="btn btn-outline-primary btn-sm">
                        New Order
                    </a>
                </div>

                </div>
            </div>
        </div>
    </body>
</html>
