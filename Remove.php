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
//REMOVING A ORDER FROM THE CART
session_start();

if (isset($_POST['cart_key'], $_POST['action'])) {
    $key = $_POST['cart_key'];

    if ($_POST['action'] === 'remove' && isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
    }

    if ($_POST['action'] === 'decrease' && isset($_SESSION['cart'][$key])) {
        if ($_SESSION['cart'][$key]['qty'] > 1) {
            $_SESSION['cart'][$key]['qty']--;
        } else {
            unset($_SESSION['cart'][$key]);
        }
    }
}

header("Location: OrderingSystem.php#ReviewCart");
exit;


?>