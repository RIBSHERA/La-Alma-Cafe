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
// FOR CLEARING ALL THE ORDERS FROM THE CART
session_start();
unset($_SESSION['cart']);
header("Location: OrderingSystem.php");
exit;
?>