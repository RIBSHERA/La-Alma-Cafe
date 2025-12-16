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
    echo"";
}


//TOTAL EARNINGS---------------------------------
$sql1 = "SELECT SUM(SUBTOTAL) AS TOTAL_EARNINGS FROM ORDER_TABLE";
$result = sqlsrv_query($conn, $sql1);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
$totalEarnings = $row['TOTAL_EARNINGS'];



//TOTAL SALES---------------------------
$sql2 = "SELECT SUM(QTY) AS TOTAL_SALES FROM ORDER_TABLE";
$result = sqlsrv_query($conn, $sql2);

$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
$totalSales = $row['TOTAL_SALES'];



//SALES TODAY----------------------------------
$sql3 = "
    SELECT SUM(SUBTOTAL) AS SALES_TODAY
    FROM ORDER_TABLE
    WHERE CAST(ORDER_DATE AS DATE) = CAST(GETDATE() AS DATE)";

$result = sqlsrv_query($conn, $sql3);

$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
$salesToday = $row['SALES_TODAY'];



//SALES CATEGORY--------------------------------------
$sql4 = "
    SELECT CATEGORY, SUM(SUBTOTAL) AS TOTAL_SALES
    FROM ORDER_TABLE
    GROUP BY CATEGORY
    ORDER BY TOTAL_SALES DESC";

$result = sqlsrv_query($conn, $sql4);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

$salesByCategory = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $salesByCategory[] = $row;
}

//SALES GRAPH------------------------------------------------
$sql5 = "
    SELECT 
        CAST(ORDER_DATE AS DATE) AS SALE_DATE,
        SUM(SUBTOTAL) AS TOTAL_SALES
    FROM ORDER_TABLE
    GROUP BY CAST(ORDER_DATE AS DATE)
    ORDER BY SALE_DATE";

$result = sqlsrv_query($conn, $sql5);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

$graphDates = [];
$graphTotals = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $graphDates[]  = $row['SALE_DATE']->format('M d');
    $graphTotals[] = $row['TOTAL_SALES'];
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .box{
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        
    }
    body {
        background: radial-gradient(circle at top, #1a1a1a, #000);
        color: #fff;
        overflow: hidden;
    }

    .dashboard-tile {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 16px;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: all 0.2s ease;
    }

    .dashboard-tile:hover {
        transform: scale(1.015);
        border-color: rgba(255, 255, 255, 0.6);
    }


    .dashboard-tile h3 {
        font-size: 1.4rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    #salesChart {
        height: 100%;
    }

    .bg1{
        background: url('AdminMenubg.png');
        background-position: 80% 20%;  ;
    }

    .bg2{
        background: url('AdminMenubg.png');
        background-position: 80% 60%;  ;
    }
    .bg3{
        background: url('AdminMenubg.png');
        background-position: 80% 90%;  ;
    }
    
    .bg4{
        background: url('AdminMenubg.png');
        background-position: 45% 90%;  ;
    }

    .bg5{
        background: url('AdminMenubg.png');
        background-position: 20% 90%;  ;
    }

    .bg6{
        background: url('AdminMenubg.png');
        background-position: 25% 10%;  ;
    }

    .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 50px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
    }
    
    @font-face {
        font-family: 'Drawing Summer';
        src: url('Fonts/Drawing Summer.ttf') format('truetype');
        font-weight: bold;
        font-style: normal;
    }

      .adminfont{
        font-family: 'Drawing Summer';
        font-size: 1rem;
        color: #ffffff;
      }
</style>
</head>

<body >
   
<div class="container-fluid vh-100 p-4 d-flex flex-column gap-3 adminfont ">

    <!-- TOP SECTION -->
    <div class="row flex-grow-1 g-3">

        <!-- HERO TILE --------------------------->
        <div class="col-8">
            <div class="h-100 dashboard-tile p-3 bg6 ">
                <div class="fs-1 fw-bold d-flex flex-column justify-content-center align-items-center text-center">Sales Graph</div>
                <br>
                
                <div style="height:500px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- RIGHT STACK --------------------------->
        <div class="col-4">
            <div class="d-flex flex-column h-100 gap-3 ">

                <div class="flex-fill dashboard-tile p-3 bg1 d-flex flex-column justify-content-center align-items-center text-center">
                     <div class="glass  text-center p-4">
                        <div class="fs-1 fw-bold mb-2">TOTAL EARNINGS</div>
                        <div class="fs-1 fw-bold">₱ <?= number_format($totalEarnings, 2) ?></div>
                    </div>
                </div>

                <div class="flex-fill dashboard-tile p-3 bg2 d-flex flex-column justify-content-center align-items-center text-center">
                    <div class="glass  text-center p-4">
                        <div class="fs-1 fw-bold mb-2">TOTAL SALES</div>
                        <div class="fs-1 fw-bold"><?= number_format($totalSales) ?> items</div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- BOTTOM SECTION ---------------->
    <div class="row flex-grow-0 g-3" style="min-height: 30vh;">

        <div class="col-4">
            <div class="h-100 dashboard-tile p-3 bg5 d-flex justify-content-center align-items-center text-center">

                <div class="d-flex flex-column gap-4 text-center">

                    <a href="MenuManagement.php" class="text-decoration-none adminfont">
                        <div class="fs-1 fw-bold glass">ADDMENU</div>
                    </a>

                    <a href="OrderingSystem.php" class="text-decoration-none adminfont ">
                        <div class="fs-1 fw-bold glass">CASHIER</div>
                    </a>

                    <a href="Welcome.html" class="text-decoration-none adminfont ">
                        <div class="fs-1 fw-bold glass">LOGOUT</div>
                    </a>
                </div>

            </div>
        </div>

        <div class="col-4">
            <div class="h-100 dashboard-tile p-3 bg4">

            <div class="glass p-4 text-center">
                <div class="fs-1 fw-bold outlined-text mb-3">
                    SALES BY CATEGORY
                </div>
                <?php if (!empty($salesByCategory)): ?>
                    <ul class="list-unstyled fs-3 text-start">
                        <?php foreach ($salesByCategory as $cat): ?>
                            <li class="d-flex justify-content-between mb-2">
                                <span><?= htmlspecialchars($cat['CATEGORY']) ?></span>
                                <strong>₱ <?= number_format($cat['TOTAL_SALES'], 2) ?></strong>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted fs-3">No sales data</p>
                <?php endif; ?>
            </div>
        </div>

        </div>

        <div class="col-4">
            <div class="h-100 dashboard-tile p-3 bg3 d-flex flex-column justify-content-center align-items-center text-center">
            <div class="glass text-center p-3">
                <div class="fs-1 fw-bold">
                    SALES TODAY
                </div>
                <div class="fs-1 fw-bold">
                    ₱ <?= number_format($salesToday, 2) ?>
                </div>
            </div>
        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <script>
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($graphDates) ?>,
            datasets: [{
                label: 'Daily Sales (₱)',
                data: <?= json_encode($graphTotals) ?>,
                borderColor: '#f4c430',
                backgroundColor: 'rgba(244, 195, 48, 0.45)',
                tension: 0.4,
                fill: true,

                pointRadius: 10,         
                pointHoverRadius: 12,    
                pointBackgroundColor: '#f4c330f8',
                pointBorderColor: '#f4c330fa',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: 'white', font:{size:30} }
                }
            },
            scales: {
                x: {
                    ticks: { color: 'white', font:{size:50} },
                    grid: { color: 'rgba(255, 217, 0, 0.1)' }
                },
                y: {
                    ticks: { color: 'white', font:{size:20} },
                    grid: { color: 'rgba(255, 255, 255, 1)' }
                }
            }
        }
    });
    </script>

    

</body>

</body>
</html>