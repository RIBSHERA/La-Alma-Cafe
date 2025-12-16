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
    echo "";
}
session_start();

if (isset($_GET['new_order'])) {
    unset($_SESSION['cart']);
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ordering System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
       body {
            background: url('menuback.png') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            margin: 0;
            padding: 0;
       }
       
       @font-face {
        font-family: 'Drawing Summer';
        src: url('Fonts/Drawing Summer.ttf') format('truetype');
        font-weight: bold;
        font-style: normal;
      }

      @font-face {
        font-family: 'Western Handmade';
        src: url('Fonts/Western Handmade.ttf') format('truetype');
        font-weight: bold;
        font-style: normal;
      }
      .cartbody{
        background: url('menuback.png') center center fixed;
      }
      .sidebarcategories{
        font-family: 'Drawing Summer';
        font-size: 5rem;
        color: #ffffff;
      }
      
      .titles{
        font-family: 'Western Handmade';
        font-size: 2.5rem;
        color: #080808ff;
      
       
      }

      .iteminfo{
        font-weight: 500;  
        font-size: 1.5rem; 
        font-family: 'Western Handmade';
        color: black;
      
      }

      .pricehighlight{
        background: #E0AA3E;
        border-radius: 8px;
        max-width: max-content;
        
      }

      .scrollspy {
        height: 400px;
        overflow-y: scroll;
        padding: 20px; 
        border-radius: 8px;
        height: 900px;
        scrollbar-width: none;

      }
      .logbox {
        border: 1px solid #030303; 
        padding: 20px; 
        border-radius: 8px; 
        background-color: #EFDECD;
        max-width: 600px;
        min-height: 500px;
      }
      .glass {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(150px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 30px;
       
      }
      .glass:hover{
        transform: scale(1.015);
        border-color: rgba(255, 255, 255, 0.6);
      }

      .glass2 {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 16px;
        
      }
      
    </style>
  </head>
  <body>
    <br><br>
    <div class="row">
      <div class="col-4 d-flex align-items-center">
        <div class="w-100 ">
            <div id="simple-list-example" class="d-flex flex-column gap-3 text-center sidebarcategories">

              <a class="list-group-item list-group-item-action" href="#simple-list-item-1" >Coffee</a >
              <a class="list-group-item list-group-item-action" href="#simple-list-item-2">Non-Coffee</a>
              <a class="list-group-item list-group-item-action" href="#simple-list-item-3">Breads</a>
              <a  class="list-group-item list-group-item-action" href="#simple-list-item-4">Desserts</a >
              </div>
              <div class="row d-flex justify-content-center align-items-center" style="min-height: 15vh;">
                <div class="col-10">

                  <a type="button" class="btn btn-primary btn-lg w-100 glass" data-bs-toggle="modal" data-bs-target="#ReviewCart">
                    <div class="h-100 p-3 d-flex justify-content-center align-items-center text-center">
                      <div class="fs-1 fw-bold ">REVIEW CART</div>
                    </div>
                  </a>

                  <br><br>
                  <a type="button" class="btn btn-warning form-control btn-lg glass" href="Welcome.html">
                    <div class="h-100  p-3  d-flex justify-content-center align-items-center text-center">
                      <div class="fs-1 fw-bold ">BACK</div>
                    </div>
                  </a>
              </div>

            </div>
        </div>
      </div>
      <div class="col-8">
        <div data-bs-spy="scroll" data-bs-target="#simple-list-example" data-bs-offset="0" data-bs-smooth-scroll="true" class="scrollspy" tabindex="0">
        




          <!-- COFFEE --------------------------------------------------------------------------->
            <section id="simple-list-item-1">
            <h4 class="titles"><b>Coffee</b></h4>
                <div class="row">
                <!-- 1st col -->
                <?php
            $sql = "SELECT * FROM COFFEE_TABLE";
            $result = sqlsrv_query($conn, $sql);

            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            ?>
              <div class="col-md-4 mb-4 d-flex">
                <div class="card h-100 w-100 glass rounded-10 overflow-hidden" style="width: 18rem;">
                  <img src="<?= $row['PRODUCT_IMAGE'] ?>" class="card-img-top">

                    <div class="card-body iteminfo">
                      <h5 class="card-title">
                        <span class="titles fs-7"><?= htmlspecialchars($row['PRODUCT_NAME']) ?></span>
                      </h5>

                      <p class="card-text">
                        <?= htmlspecialchars($row['DESCRIPTION']) ?>
                      </p>
                      </div>

                    <div class="card-footer iteminfo">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="pricehighlight">
                          <!-- SIZE 1 -->
                          <?= htmlspecialchars($row['SIZE_1']) ?> - ₱<?= $row['PRICE_1'] ?>
                        </span>
                        <form method="POST" action="AddToCart.php" class="ms-2">
                            <input type="hidden" name="product_id" value="<?= $row['COFFEE_ID'] ?>">
                            <input type="hidden" name="product_name" value="<?= $row['PRODUCT_NAME'] ?>">
                            <input type="hidden" name="category" value="Coffee">
                            <input type="hidden" name="size" value="<?= $row['SIZE_1'] ?>">
                            <input type="hidden" name="price" value="<?= $row['PRICE_1'] ?>">
                            <input type="hidden" name="image" value="<?= $row['PRODUCT_IMAGE'] ?>">

                            <button type="submit" class="btn btn-success btn-lg ">Add</button>
                        </form>
                        </div>

                        <!-- SIZE 2 -->
                        <?php if (!empty($row['SIZE_2'])) { ?>
                        <div class="d-flex justify-content-between align-items-center gap-2">
                        <span class="pricehighlight">
                            <?= htmlspecialchars($row['SIZE_2']) ?> - ₱<?= $row['PRICE_2'] ?>
                        </span>
                        <form method="POST" action="AddToCart.php" class="ms-2">
                            <input type="hidden" name="product_id" value="<?= $row['COFFEE_ID'] ?>">
                            <input type="hidden" name="product_name" value="<?= $row['PRODUCT_NAME'] ?>">
                            <input type="hidden" name="category" value="Coffee">
                            <input type="hidden" name="size" value="<?= $row['SIZE_2'] ?>">
                            <input type="hidden" name="price" value="<?= $row['PRICE_2'] ?>">
                            <input type="hidden" name="image" value="<?= $row['PRODUCT_IMAGE'] ?>">

                            <button type="submit" class="btn btn-success btn-lg"> Add</button>
                        </form>
                        </div>
                        <?php } ?>
            
                      </div>
                    </div>
                  </div>
            <?php } ?>
            </div>
          </section>
          <!-- COFFEE --------------------------------------------------------------------------->
          <br><br><br>



          <!-- NON-COFFEE --------------------------------------------------------------------------->
            <section id="simple-list-item-2">
            <h4 class="titles"><b>Non-Coffee</b></h4>
                <div class="row">
                <!-- 1st col -->
                <?php
                $sql = "SELECT * FROM NON_COFFEE_TABLE";
                $result = sqlsrv_query($conn, $sql);

                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                ?>
                  <div class="col-md-4 mb-4 d-flex">
                    <div class="card h-100 w-100 glass rounded-10 overflow-hidden" style="width: 18rem;">
                      <img src="<?= $row['PRODUCT_IMAGE'] ?>" class="card-img-top">

                      <div class="card-body iteminfo">
                        <h5 class="card-title">
                          <span class="titles fs-7"><?= htmlspecialchars($row['PRODUCT_NAME']) ?></span>
                        </h5>
                        
                        <p class="card-text">
                          <?= htmlspecialchars($row['DESCRIPTION']) ?>
                        </p>
                        </div>
                        <div class="card-footer iteminfo">

                        <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="pricehighlight">
                          <!-- SIZE 1 -->
                          <?= htmlspecialchars($row['SIZE_1']) ?> - ₱<?= $row['PRICE_1'] ?>
                        </span>
                        <form method="POST" action="AddToCart.php" class="ms-2">
                            <input type="hidden" name="product_id" value="<?= $row['NON_COFFEE_ID'] ?>">
                            <input type="hidden" name="product_name" value="<?= $row['PRODUCT_NAME'] ?>">
                            <input type="hidden" name="category" value="Non-Coffee">
                            <input type="hidden" name="size" value="<?= $row['SIZE_1'] ?>">
                            <input type="hidden" name="price" value="<?= $row['PRICE_1'] ?>">
                            <input type="hidden" name="image" value="<?= $row['PRODUCT_IMAGE'] ?>">

                            <button type="submit" class="btn btn-success btn-lg ">Add</button>
                        </form>
                        </div>

                        <!-- SIZE 2 -->
                        <?php if (!empty($row['SIZE_2'])) { ?>
                        <div class="d-flex justify-content-between align-items-center">
                        <span class="pricehighlight">
                            <?= htmlspecialchars($row['SIZE_2']) ?> - ₱<?= $row['PRICE_2'] ?>
                        </span>
                        <form method="POST" action="AddToCart.php" class="ms-2">
                            <input type="hidden" name="product_id" value="<?= $row['NON_COFFEE_ID'] ?>">
                            <input type="hidden" name="product_name" value="<?= $row['PRODUCT_NAME'] ?>">
                            <input type="hidden" name="category" value="Non-Coffee">
                            <input type="hidden" name="size" value="<?= $row['SIZE_2'] ?>">
                            <input type="hidden" name="price" value="<?= $row['PRICE_2'] ?>">
                            <input type="hidden" name="image" value="<?= $row['PRODUCT_IMAGE'] ?>">

                            <button type="submit" class="btn btn-success btn-lg">Add</button>
                        </form>
                        </div>
                        <?php } ?>
            
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </section>
          <!-- NON-COFFEE --------------------------------------------------------------------------->
           <br><br><br>




          <!-- BREAD --------------------------------------------------------------------------->
            <section id="simple-list-item-3">
            <h4 class="titles"><b>Breads</b></h4>
                <div class="row">
                <!-- 1st col -->
                <?php
                $sql = "SELECT * FROM BREAD_TABLE";
                $result = sqlsrv_query($conn, $sql);

                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                ?>
                  <div class="col-md-4 mb-4 d-flex">
                    <div class="card h-100 w-100 glass rounded-10 overflow-hidden" style="width: 18rem;">
                      <img src="<?= $row['PRODUCT_IMAGE'] ?>" class="card-img-top">

                      <div class="card-body iteminfo">
                        <h5 class="card-title">
                          <span class="titles fs-7"><?= htmlspecialchars($row['PRODUCT_NAME']) ?></span>
                        </h5>

                        <p class="card-text">
                          <?= htmlspecialchars($row['DESCRIPTION']) ?>
                        </p>
                        </div>
                        <div class="card-footer iteminfo">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="pricehighlight">₱<?= $row['PRICE'] ?></span>

                        <form method="POST" action="AddToCart.php" class="ms-2">
                            <input type="hidden" name="product_id" value="<?= $row['BREAD_ID'] ?>">
                            <input type="hidden" name="product_name" value="<?= $row['PRODUCT_NAME'] ?>">
                            <input type="hidden" name="category" value="Breads">
                            <input type="hidden" name="price" value="<?= $row['PRICE'] ?>">
                            <input type="hidden" name="image" value="<?= $row['PRODUCT_IMAGE'] ?>">

                            <button type="submit" class="btn btn-success btn-lg ">Add</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </section>
            <!-- BREAD --------------------------------------------------------------------------->
           <br><br><br>




           <!-- DESSERT --------------------------------------------------------------------------->
            <section id="simple-list-item-4">
            <h4 class="titles"><b>Desserts</b></h4>
                <div class="row">
                <!-- 1st col -->
                <?php
                $sql = "SELECT * FROM DESSERT_TABLE";
                $result = sqlsrv_query($conn, $sql);

                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                ?>
                  <div class="col-md-4 mb-4 d-flex">
                    <div class="card h-100 w-100 glass rounded-10 overflow-hidden" style="width: 18rem;">
                      <img src="<?= $row['PRODUCT_IMAGE'] ?>" class="card-img-top">

                      <div class="card-body iteminfo">
                        <h5 class="card-title">
                          <span class="titles fs-7"><?= htmlspecialchars($row['PRODUCT_NAME']) ?></span>
                        </h5>

                        <p class="card-text">
                          <?= htmlspecialchars($row['DESCRIPTION']) ?>
                        </p>
                        </div>
                        <div class="card-footer iteminfo">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="pricehighlight">₱<?= $row['PRICE'] ?></span>

                        <form method="POST" action="AddToCart.php" class="ms-2">
                            <input type="hidden" name="product_id" value="<?= $row['DESSERT_ID'] ?>">
                            <input type="hidden" name="product_name" value="<?= $row['PRODUCT_NAME'] ?>">
                            <input type="hidden" name="category" value="Desserts">
                            <input type="hidden" name="price" value="<?= $row['PRICE'] ?>">
                            <input type="hidden" name="image" value="<?= $row['PRODUCT_IMAGE'] ?>">

                            <button type="submit" class="btn btn-success btn-lg ">Add</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </section>
            <!-- DESSERT --------------------------------------------------------------------------->




    <!-- MODALS FOR OPENING THE CART ----------------------------------------------->
    <div class="modal fade " id="ReviewCart" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content body cartbody">

      <div class="modal-header">
        <h1 class="modal-title">La Alma Cafe</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>


      <!------- MODAL BODY -------->
      <div class="modal-body iteminfo">
        <?php if (!empty($_SESSION['cart'])): ?>
          <!------- THIS FOR CREATING A LIST BY LOOPING ALL THE DATA'S TO CREATE AN HTML -------->
          <ul class="list-group">
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $key => $item):
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                ?>
            <li class="list-group-item d-flex align-items-center glass2">
                <?php if (!empty($item['image'])): ?>
                    <img src="<?= htmlspecialchars($item['image']) ?>"
                  
                         style="width: 100px; height: 100px; object-fit: cover; margin-right: 15px;">
                <?php else: ?>
                    <div style="width:50px;height:50px;background:#eee;margin-right:15px;"></div>
                <?php endif; ?>

                <div class="flex-grow-1">
                    <h2 class="mb-1"><?= htmlspecialchars($item['name']) ?></h6>

                    <small>
                        <?= htmlspecialchars($item['size']) ?> — ₱<?= number_format($item['price'], 2) ?>
                    </small>

                    <div class="fw-semibold">
                        Qty: <?= $item['qty'] ?>
                    </div>

                    <div class="fw-bold pricehighlight">
                        PHP <?= number_format($subtotal, 2) ?>
                    </div>
                </div>

                <!------- TO REMOVE AN ORDER FROM THE CART -------->
                <form method="post" action="Remove.php">
                    <input type="hidden" name="cart_key" value="<?= $key ?>">
                    <input type="hidden" name="action" value="remove">
                    <button class="btn btn-lg btn-outline-danger">&times;</button>
                </form>

            </li>
            <?php endforeach; ?>
            </ul>
            <!------- THIS FOR CREATING A LIST BY LOOPING ALL THE DATA'S TO CREATE AN HTML -------->


            <hr>
            
            <div class="d-flex align-items-center justify-content-between mt-3">
                  <form method="POST" action="ClearCart.php">
                  <button type="submit" class="btn btn-danger">
                      <h4>Clear Cart</h4>
                  </button>
                </form>
                  <span class="pricehighlight px-3 py-1">
                      <h2 class="fw-bold">Total: ₱<?= number_format($total, 2) ?></h2>
                  </span>
              </div>
               <!-------WHEN CART DOESN'T HAVE AN ORDER TO GET -------->   
              <?php else: ?>
                  <p class="text-center">Your cart is empty.</p>
              <?php endif; ?>
              </div>
              <!-------WHEN CART DOESN'T HAVE AN ORDER TO GET -------->
              <!------- MODAL BODY -------->







              <!-------MODAL FOOTER -------->
              <div class="modal-footer d-flex justify-content-center iteminfo glass2">
                <form method="post" action="Receipt.php" class="w-100">
                <div class="col-md-12">
                  <h1 >Customer Name</h1>
                  <input type="text" name="customer_name" class="form-control w-100" placeholder="Enter customer name" required>
                </div>

                <div class="row g-2">
                  <div class="col-md-6">
                    <h1>Payment Method</h1>
                    <select name="payment_method" class="form-select" required>
                      <option value="">Select</option>
                      <option value="Cash">Cash</option>
                      <option value="GCash">GCash</option>
                      <option value="Card">Card</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <h1>Dine Option</h1>
                    <select name="dine_option" class="form-select" required>
                      <option value="">Select</option>
                      <option value="Dine-In">Dine-In</option>
                      <option value="Take-Out">Take-Out</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <h1>Discount</h1>
                    <select name="discount_type" class="form-select" required>
                      <option value="None">None</option>
                      <option value="Student">Student (10%)</option>
                      <option value="PWD">PWD (20%)</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <h1>Cash Received</h1>
                    <input type="text" name="cash_received" class="form-control" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                  </div>
                </div>

                <div class="mt-3 d-flex align-items-center justify-content-center gap-2">
                  <button type="submit" class="btn btn-success"><h2>Place Order</h2></button>
                </div>

              </form>
              </div>

            </div>
            <!-------MODAL FOOTER -------->
          </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    

    <script>
    const orderTotal = <?= json_encode($total ?? 0) ?>;
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const form = document.querySelector('form[action="Receipt.php"]');
        const cashInput = form.querySelector('input[name="cash_received"]');

        form.addEventListener("submit", function (e) {
            const cashReceived = parseFloat(cashInput.value);

            if (isNaN(cashReceived) || cashReceived < orderTotal) {
                e.preventDefault();
                alert("CASH INSUFFICIENT. TRY AGAIN");
                cashInput.focus();
            }
        });

    });
    </script>

  </body>
</html>