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
} else{
    echo "Success";
}

//ADDING ORDER IN THE CART
session_start();

$product_id   = $_POST['product_id'];
$product_name = $_POST['product_name'];
$category     = $_POST['category'];
$size         = $_POST['size'];
$price        = $_POST['price'];
$image        = $_POST['image']; 

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$key = $product_id . '_' . $size;

if (isset($_SESSION['cart'][$key])) {
    $_SESSION['cart'][$key]['qty'] += 1;
} else {
    $_SESSION['cart'][$key] = [
        'product_id' => $product_id,
        'name'       => $product_name,
        'category'   => $category,
        'size'       => $size,
        'price'      => $price,
        'qty'        => 1,
        'image'      => $image,
    ];
}

header("Location: OrderingSystem.php");
exit;













?>