<?php
$serverName="TOUGH\SQLEXPRESS";
$connectionOptions=[
    "DATABASE"=>"DLSU",
    "Uid"=>"",
    "PWD"=>""
];

//THIS PHP IS FOR DELETING AN PRODUCT IN THE MENU
$conn=sqlsrv_connect($serverName,$connectionOptions);
if($conn==false){
    die(print_r(sqlsrv_errors(),true));
} else{
    echo "Success";
}
if (isset($_POST['id'], $_POST['category'])) {

    $id = $_POST['id'];
    $category = $_POST['category'];

    if ($category === "Coffee") {
        $sql = "DELETE FROM COFFEE_TABLE WHERE COFFEE_ID = ?";
    } 
    else if($category === "Non-Coffee") {
        $sql = "DELETE FROM NON_COFFEE_TABLE WHERE NON_COFFEE_ID = ?";
    }
    else if($category === "Breads") {
        $sql = "DELETE FROM BREAD_TABLE WHERE BREAD_ID = ?";
    }
    else if($category === "Desserts") {
        $sql = "DELETE FROM DESSERT_TABLE WHERE DESSERT_ID = ?";
    }

    sqlsrv_query($conn, $sql, [$id]);
}

header("Location: MenuManagement.php");
exit;


?>