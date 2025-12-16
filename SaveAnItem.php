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

//THIS PHP IS FOR ADDING AN ITEM TO THE MENU

if (isset($_POST['add_item'])) {

    $category = $_POST['category'];
    $product_name = $_POST['product_name'];
    $size1 = $_POST['size1'];
    $price1 = $_POST['price1'];
    $size2 = $_POST['size2'];
    $price2 = $_POST['price2'];
    $description = $_POST['description'];

    
    $imageName = $_FILES['product_image']['name'];
    $imageTmp = $_FILES['product_image']['tmp_name'];
    $imagePath = "Menu" . $imageName;
    move_uploaded_file($imageTmp, $imagePath);

    if ($category == "Coffee") {
        $sql = "INSERT INTO COFFEE_TABLE
        (CATEGORY, PRODUCT_NAME, SIZE_1, PRICE_1, SIZE_2, PRICE_2, DESCRIPTION, PRODUCT_IMAGE)
        VALUES ('$category', '$product_name', '$size1', '$price1', '$size2', '$price2', '$description', '$imagePath')";
    } 
    else if($category == "Non-Coffee"){
        $sql = "INSERT INTO NON_COFFEE_TABLE
        (CATEGORY, PRODUCT_NAME, SIZE_1, PRICE_1, SIZE_2, PRICE_2, DESCRIPTION, PRODUCT_IMAGE)
        VALUES ('$category', '$product_name', '$size1', '$price1', '$size2', '$price2', '$description', '$imagePath')";
    }
    else if($category == "Breads"){
        $sql = "INSERT INTO BREAD_TABLE
        (CATEGORY, PRODUCT_NAME, PRICE, DESCRIPTION, PRODUCT_IMAGE)
        VALUES ('$category', '$product_name', '$price1', '$description', '$imagePath')";
    }
    else if($category == "Desserts"){
        $sql = "INSERT INTO DESSERT_TABLE
        (CATEGORY, PRODUCT_NAME, PRICE, DESCRIPTION, PRODUCT_IMAGE)
        VALUES ('$category', '$product_name', '$price1', '$description', '$imagePath')";
    }

    $params = [$category, $product_name, $size1, $price1, $size2, $price2, $description, $imagePath];

    sqlsrv_query($conn, $sql, $params);

    header("Location: MenuManagement.php"); 
}














?>
