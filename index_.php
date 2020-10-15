<?php
session_start();
include "header.php";
include("common/dbcon.php");

$viewmode = '';
$branch = '';
if(isset($_SESSION['viewmode'])){
    $viewmode = $_SESSION['viewmode'];
}
if(isset($_SESSION['branch'])){
    $branch = $_SESSION['branch'];
}

$data = [];
$query = "SELECT * FROM customer";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$filtered_rows = $statement->rowCount();


$query2 = "SELECT * FROM employee";

$statement2 = $connect->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();
$filtered_rows2 = $statement2->rowCount();

$query3 = "SELECT * FROM job";

$statement3 = $connect->prepare($query3);
$statement3->execute();
$result3 = $statement3->fetchAll();
$filtered_rows3 = $statement3->rowCount();

//foreach ($result as $row){
//?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">ภาพรวมระบบ <span style="color: #419641">[<?=$viewmode?>]</span></h1>

</div>
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">พนักงาน</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($filtered_rows) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-primary-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">ลูกค้า</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($filtered_rows2) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary-300"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">งาน</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($filtered_rows3) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list-ol fa-2x text-primary-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">ข้อมูลที่ต้องการ</h6>
                <!--                <div class="dropdown no-arrow">-->
                <!--                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                <!--                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>-->
                <!--                    </a>-->
                <!--                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">-->
                <!--                        <div class="dropdown-header">Dropdown Header:</div>-->
                <!--                        <a class="dropdown-item" href="#">Action</a>-->
                <!--                        <a class="dropdown-item" href="#">Another action</a>-->
                <!--                        <div class="dropdown-divider"></div>-->
                <!--                        <a class="dropdown-item" href="#">Something else here</a>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">ข้อมูลที่ต้องการ</h6>
                <!--                <div class="dropdown no-arrow">-->
                <!--                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                <!--                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>-->
                <!--                    </a>-->
                <!--                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">-->
                <!--                        <div class="dropdown-header">Dropdown Header:</div>-->
                <!--                        <a class="dropdown-item" href="#">Action</a>-->
                <!--                        <a class="dropdown-item" href="#">Another action</a>-->
                <!--                        <div class="dropdown-divider"></div>-->
                <!--                        <a class="dropdown-item" href="#">Something else here</a>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="brand-chart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                    </span>

                    <?php
//                    $data_brand = [];
//                    for ($x = 0; $x <= count($data) - 1; $x++) {
//                        array_push($data_brand, $data[$x]['brand']);
//                    }
                    ?>

                    <input type="hidden" id="brand-list" value="">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
<script>
    var ctx = document.getElementById("brand-chart");
    var brand_chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Direct", "Referral", "Social"],
            datasets: [{
                data: [55, 30, 15],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });

</script>
