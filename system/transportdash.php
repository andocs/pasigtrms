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
                        <h2 class="card-text" id="groupCount" style="cursor:pointer"><?php echo $groupCount; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        Transport Terminals
                    </div>
                    <div class="card-body">
                        <h2 class="card-text" id="terminalCount" style="cursor:pointer"><?php echo $terminalCount; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        Transport Routes
                    </div>
                    <div class="card-body">
                        <h2 class="card-text" id="routesCount" style="cursor:pointer"><?php echo $routesCount; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-12">
                <div id="tableContainer">
                    <!-- The first table will load here by default -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load the first table by default
        window.onload = function() {
            loadTable('trans_group');
        };

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
                    document.getElementById('tableContainer').innerHTML = xhr.responseText;
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
