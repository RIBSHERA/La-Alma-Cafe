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

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Management</title>
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
        font-weight: 450;  
        font-size: 1.5rem; 
        color: #000000ff;
        font-family: 'Western Handmade';
      }

      .pricehighlight{
        background: #E0AA3E;
        border-radius: 8px;
        max-width: max-content;
      }

      .scrollspy {
        overflow-y: scroll;
        padding: 20px; 
        border-radius: 8px;
        height: 900px;      
        scrollbar-width: none; 
        
      }
      .logbox {
        background: url('menuback.png')  center center fixed;
        font-family: 'Western Handmade';
        font-size: 1.5rem;
        color: #080808ff;
        border: 1px solid #030303; 
        padding: 20px; 
        border-radius: 8px; 
        background-color: #EFDECD;
        max-width: 600px;
        min-height: 500px;
      }
      .glass {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 30px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      }
      .glass:hover{
        transform: scale(1.015);
        border-color: rgba(255, 255, 255, 0.6);
      }
      
    </style>
  </head>
  <body>
    <br>
   
    
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

                <a type="button" class="btn btn-primary form-control btn-lg glass" data-bs-toggle="modal" data-bs-target="#Addmenu">
                  <div class="h-100 p-3 d-flex justify-content-center align-items-center text-center">
                      <div class="fs-1 fw-bold ">ADD PRODUCT</div>
                  </div>
                </a>
                <br><br>

                <a type="button" class="btn btn-warning form-control btn-lg glass" href="AdminMenu.php">
                 <div class="h-100 p-3 d-flex justify-content-center align-items-center text-center">
                      <div class="fs-1 fw-bold ">BACK</div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

      <div class="col-8">
        <div data-bs-spy="scroll" data-bs-target="#simple-list-example" data-bs-offset="0" data-bs-smooth-scroll="true" class="scrollspy " tabindex="0">
        
          <!-- 1st category --------------------------------------------------------------------------->
            <section id="simple-list-item-1">
            <h4 class="titles"><b>Coffee</b></h4>
                <div class="row">
                
                <?php
            $sql = "SELECT * FROM COFFEE_TABLE";
            $result = sqlsrv_query($conn, $sql);

            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            ?>
              <div class="col-md-4 mb-4 d-flex">
                <div class="card h-100 w-100 glass rounded-10 overflow-hidden" style="width: 18rem;">
                  <img src="<?= $row['PRODUCT_IMAGE'] ?>" class="card-img-top">

                  <div class="card-body iteminfo">
                    <h5>
                      <span class="titles card-title fs-7"><?= htmlspecialchars($row['PRODUCT_NAME']) ?></span>
                    </h5>

                    <p class="card-text">
                      <?= htmlspecialchars($row['DESCRIPTION']) ?>
                    </p>
                    </div>

                    <div class="card-footer iteminfo">
                    <p>
                      <span class="pricehighlight"><?= htmlspecialchars($row['SIZE_1']) ?> - ₱<?= $row['PRICE_1'] ?>
                    </p>

                    <?php if (!empty($row['SIZE_2'])) { ?>
                      <p>
                        <span class="pricehighlight"><?= htmlspecialchars($row['SIZE_2']) ?> - ₱<?= $row['PRICE_2'] ?></span>
                      </p>
                    <?php } ?>
                    <form method="POST" action="Delete.php"
                          onsubmit="return confirm('Delete this item?');">

                      <input type="hidden" name="id" value="<?= $row['COFFEE_ID'] ?>">
                      <input type="hidden" name="category" value="Coffee">

                      <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            <?php } ?>

            </div>
          </section>
          <!-- 1st category --------------------------------------------------------------------------->
          <br><br><br>

          <!-- 2nd category --------------------------------------------------------------------------->
            <section id="simple-list-item-2">
            <h4 class="titles"><b>Non-Coffee</b></h4>
                <div class="row">
                
                <?php
                $sql = "SELECT * FROM NON_COFFEE_TABLE";
                $result = sqlsrv_query($conn, $sql);

                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                ?>
                  <div class="col-md-4 mb-4 d-flex">
                    <div class="card h-100 w-100 glass rounded-10 overflow-hidden" style="width: 18rem;">
                      <img src="<?= $row['PRODUCT_IMAGE'] ?>" class="card-img-top">

                      <div class="card-body iteminfo">
                        <h5>
                          <span class="titles card-title fs-7"><?= htmlspecialchars($row['PRODUCT_NAME']) ?></span>
                        </h5>
                        
                        <p class="card-text">
                          <?= htmlspecialchars($row['DESCRIPTION']) ?>
                        </p>
                        </div>

                        <div class="card-footer iteminfo">
                        <p>
                          <span class="pricehighlight"><?= htmlspecialchars($row['SIZE_1']) ?> - ₱<?= $row['PRICE_1'] ?>
                        </p>

                        <?php if (!empty($row['SIZE_2'])) { ?>
                          <p>
                            <span class="pricehighlight"><?= htmlspecialchars($row['SIZE_2']) ?> - ₱<?= $row['PRICE_2'] ?>
                          </p>
                        <?php } ?>
                        
                        <form method="POST" action="Delete.php"
                              onsubmit="return confirm('Delete this item?');">

                          <input type="hidden" name="id" value="<?= $row['NON_COFFEE_ID'] ?>">
                          <input type="hidden" name="category" value="Non-Coffee">

                          <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </section>
          <!-- 2nd category --------------------------------------------------------------------------->
           <br><br><br>

          <!-- 3rd category --------------------------------------------------------------------------->
            <section id="simple-list-item-3">
            <h4 class="titles"><b>Breads</b></h4>
                <div class="row">
                
                <?php
                $sql = "SELECT * FROM BREAD_TABLE";
                $result = sqlsrv_query($conn, $sql);

                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                ?>
                  <div class="col-md-4 mb-4 d-flex">
                    <div class="card h-100 w-100 glass rounded-10 overflow-hidden" style="width: 18rem;">
                      <img src="<?= $row['PRODUCT_IMAGE'] ?>" class="card-img-top">

                      <div class="card-body iteminfo">
                        <h5>
                          <span class="titles card-title fs-7"><?= htmlspecialchars($row['PRODUCT_NAME']) ?></span>
                        </h5>

                        <p class="card-text">
                          <?= htmlspecialchars($row['DESCRIPTION']) ?>
                        </p>
                        </div>

                        <div class="card-footer iteminfo">
                        <p>
                           <span class="pricehighlight">₱<?= $row['PRICE'] ?>
                        </p>

                        <form method="POST" action="Delete.php"
                              onsubmit="return confirm('Delete this item?');">

                          <input type="hidden" name="id" value="<?= $row['BREAD_ID'] ?>">
                          <input type="hidden" name="category" value="Breads">

                          <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </section>
            <!-- 3rd category --------------------------------------------------------------------------->
           <br><br><br>

           <!-- 4th category --------------------------------------------------------------------------->
            <section id="simple-list-item-4">
            <h4 class="titles"><b>Desserts</b></h4>
                <div class="row">
                
                <?php
                $sql = "SELECT * FROM DESSERT_TABLE";
                $result = sqlsrv_query($conn, $sql);

                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                ?>
                  <div class="col-md-4 mb-4 d-flex">
                    <div class="card h-100 w-100 glass rounded-10 overflow-hidden" style="width: 18rem;">
                      <img src="<?= $row['PRODUCT_IMAGE'] ?>" class="card-img-top">

                      <div class="card-body iteminfo">
                        <h5>
                          <span class="titles card-title fs-7"><?= htmlspecialchars($row['PRODUCT_NAME']) ?></span>
                        </h5>

                        <p class="card-text">
                          <?= htmlspecialchars($row['DESCRIPTION']) ?>
                        </p>
                        </div>

                        <div class="card-footer iteminfo">
                        <p>
                           <span class="pricehighlight">₱<?= $row['PRICE'] ?>
                        </p>

                        <form method="POST" action="Delete.php"
                              onsubmit="return confirm('Delete this item?');">

                          <input type="hidden" name="id" value="<?= $row['DESSERT_ID'] ?>">
                          <input type="hidden" name="category" value="Desserts">

                          <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </section>
            <!-- 4th category --------------------------------------------------------------------------->

    <!-- Modals review order ------------------------------------------------------------------------------------->
    <div class="modal fade  " id="Addmenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content logbox">
          <form method="POST" action="SaveAnItem.php" enctype="multipart/form-data">
          <div class="modal-header ">
            <h1 class="modal-title pricehighlight">Add An Item</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body glass ">
            <div class="container-fluid">
              <!-- Category -->
              <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                  <option value="Coffee">Coffee</option>
                  <option value="Non-Coffee">Non-Coffee</option>
                  <option value="Breads">Breads</option>
                  <option value="Desserts">Desserts</option>
                </select>
              </div>

              <!-- Product Name -->
              <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" required>
              </div>

              <!-- Size 1 & Price 1 -->
              <div class="row mb-3">
                <div class="col-md-6" id="size1group">
                  <label class="form-label">Size </label>
                  <input type="text" name="size1" class="form-control">
                </div>
                <div class="col-md-6" id="price1group">
                  <label class="form-label">Price </label>
                  <input type="text" name="price1" class="form-control"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                </div>
              </div>

              <!-- Size 2 & Price 2 -->
              <div class="row mb-3">
                <div class="col-md-6" id="size2group">
                  <label class="form-label">Size 2</label>
                  <input type="text" name="size2" class="form-control">
                </div>
                <div class="col-md-6" id="price2group">
                  <label class="form-label">Price 2</label>
                  <input type="text" name="price2" class="form-control"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label" >Description</label>
                <textarea name="description" rows="4" class="form-control"
                          placeholder="Tell something about the product"></textarea>
              </div>

              <!-- Image -->
              <div class="mb-3">
                <label class="form-label ">Product Image</label>
                <input type="file" name="product_image" class="form-control" required>
              </div>


                
              </div>
           
          </div>
          <div class="modal-footer justify-content-center align-items-center">
                <div>
                <button type="submit" class="btn btn-primary w-100 btn-lg " name="add_item">
                  Add Item
                </button>
          </div>
          </form>
        </div>
      </div>
    
    </div>
    <!-- Modals review order ------------------------------------------------------------------------------------->

    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    


    <script>
    const categorySelect = document.querySelector('select[name="category"]');

    const size1Group  = document.getElementById('size1group');
    const size2Group  = document.getElementById('size2group');
    const price2Group = document.getElementById('price2group');





    //THIS FUNCTION FILTERS OUT WHETHER TO REMOVE PRICE2,SIZE1 AND SIZE2
    function toggleSizePriceFields() {
      const category = categorySelect.value;

      if (category === 'Breads' || category === 'Desserts') {

        //IF THE CATEGORY IS BREAD OR DESSERTS, THIS DISPLAY WILL BE HIDDEN FROM THE FORM
        size1Group.style.display  = 'none';
        size2Group.style.display  = 'none';
        price2Group.style.display = 'none';

        // CLEARING VALUE SO NOTHING WILL BE SUBMITTED
        size1Group.querySelector('input').value  = '';
        size2Group.querySelector('input').value  = '';
        price2Group.querySelector('input').value = '';

      } else {

        size1Group.style.display  = 'block';
        size2Group.style.display  = 'block';
        price2Group.style.display = 'block';
      }
    }

    categorySelect.addEventListener('change', toggleSizePriceFields);
    toggleSizePriceFields();
    </script>


  </body>
</html>