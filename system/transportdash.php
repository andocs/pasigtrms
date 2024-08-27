<?php
$groupCount = getRowCount($conn, 'trans_group');
$terminalCount = getRowCount($conn, 'terminal');
$routesCount = getRowCount($conn, 'route');
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Public Transport</li>
    </ol>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        Transport Groups
                    </div>
                    <div class="card-body">
                        <h2 class="card-text" id="groupCount" style="cursor:pointer" data-toggle="modal" data-target="#dataModal"><?php echo $groupCount; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        Transport Terminals
                    </div>
                    <div class="card-body">
                        <h2 class="card-text" id="terminalCount" style="cursor:pointer" data-toggle="modal" data-target="#dataModal"><?php echo $terminalCount; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        Transport Routes
                    </div>
                    <div class="card-body">
                        <h2 class="card-text" id="routesCount" style="cursor:pointer" data-toggle="modal" data-target="#dataModal"><?php echo $routesCount; ?></h2>
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

    <script>
        // Initialize Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Groups', 'Terminals', 'Routes'],
                datasets: [{
                    label: 'Number of Entries',
                    data: [<?php echo $groupCount; ?>, <?php echo $terminalCount; ?>, <?php echo $routesCount; ?>],
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
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        document.getElementById('groupCount').addEventListener('click', function() {
            loadTable('trans_group');
        });

        document.getElementById('terminalCount').addEventListener('click', function() {
            loadTable('terminal');
        });

        document.getElementById('routesCount').addEventListener('click', function() {
            loadTable('route');
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
</div>