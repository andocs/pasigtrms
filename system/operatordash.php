<?php
if(!hasPermission(1)){
    redirectTo('warning','You do not have access!','trms.php?page=unauthorized');
}
$operatorCount = getRowCount($conn, 'operator');
$driverCount = getRowCount($conn, 'driver');
$vehicleUnitCount = getRowCount($conn, 'vehicle_unit');
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">PUV Operator</li>
    </ol>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        PUV Operator
                    </div>
                    <div class="card-body">
                        <h2 class="card-text" id="operatorCount" style="cursor:pointer" data-toggle="modal" data-target="#dataModal"><?php echo $operatorCount; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        PUV Driver
                    </div>
                    <div class="card-body">
                        <h2 class="card-text" id="driverCount" style="cursor:pointer" data-toggle="modal" data-target="#dataModal"><?php echo $driverCount; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        PUV Unit
                    </div>
                    <div class="card-body">
                        <h2 class="card-text" id="vehicleUnitCount" style="cursor:pointer" data-toggle="modal" data-target="#dataModal"><?php echo $vehicleUnitCount; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-12">
                <div id="chartContainer">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Table content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Initialize Chart.js
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Operators', 'Drivers', 'Vehicle Units'],
            datasets: [{
                label: 'Number of Entries',
                data: [<?php echo $operatorCount; ?>, <?php echo $driverCount; ?>, <?php echo $vehicleUnitCount; ?>],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', // This makes the bar chart horizontal
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('operatorCount').addEventListener('click', function() {
        loadTable('operator');
    });

    document.getElementById('driverCount').addEventListener('click', function() {
        loadTable('driver');
    });

    document.getElementById('vehicleUnitCount').addEventListener('click', function() {
        loadTable('vehicle_unit');
    });

    function loadTable(type) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'load_table.php?type=' + type, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('modalBody').innerHTML = xhr.responseText;
                new DataTable(`#dataTable_${type}`, {
                    layout: {
                        topStart: 'info',
                        bottomStart: {
                            pageLength: {
                                menu: [10, 25, 50, 100],
                            },
                        },
                    },
                });
            }
        };
        xhr.send();
    }
</script>