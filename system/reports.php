<?php
if (!hasPermission(7)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?>
<div id="container" class="container-fluid" has-permission="<?php echo hasPermission(34) ? 'true' : 'false' ?>"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">User Reports</li>
    </ol>
    <div class="col-lg-12"><br />
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#operator-tab">Operator</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#driver-tab">Driver</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#vehicle-tab">Vehicle Unit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#route-tab">Route</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#terminal-tab">Terminal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#insp_clearance-tab">Inspection Clearance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#terminal-vehicles-tab">List of Vehicles per Terminal</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="operator-tab" class="tab-pane active">
                <div id="operator-table" class="table-responsive mt-3">
                </div>
            </div>
            <div id="driver-tab" class="tab-pane fade">
                <div id="driver-table" class="table-responsive mt-3">
                </div>
            </div>
            <div id="vehicle-tab" class="tab-pane fade">
                <div id="vehicle-table" class="table-responsive mt-3">
                </div>
            </div>
            <div id="route-tab" class="tab-pane fade">
                <div id="route-table" class="table-responsive mt-3">
                </div>
            </div>
            <div id="terminal-tab" class="tab-pane fade">
                <div id="terminal-table" class="table-responsive mt-3">
                </div>
            </div>
            <div id="insp_clearance-tab" class="tab-pane fade">
                <div id="insp_clearance-table" class="table-responsive mt-3">
                </div>
            </div>
            <div id="terminal-vehicles-tab" class="tab-pane fade">
                <div id="terminal-vehicles-table" class="table-responsive mt-3">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you want to add a signatory or proceed with the default values?</p>
            </div>
            <div class="modal-footer">
                <button type="button" data-toggle="modal" data-target="#signatoriesModal" class="btn btn-primary" id="addSignatory">Add Signatory</button>
                <button type="button" class="btn btn-outline-warning" id="useDefault">Use Default</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Document Signatories -->
<div class="modal fade" id="signatoriesModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signatoriesModalLabel">Enter Document Signatories</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="signatoriesForm">
                    <div class="col-12 row flex-row">
                        <div class="form-group column col-6 justify-content-between">
                            <div>
                                <label for="prepared_by" class="form-label">Prepared By</label>
                                <input class="form-control" id="prepared_by" name="prepared_by" required>
                            </div>
                            <div class="mt-3">
                                <label for="prepared_plantilla" class="form-label">Plantilla Position</label>
                                <input class="form-control" id="prepared_plantilla" name="prepared_plantilla">
                            </div>
                            <div class="mt-3">
                                <label for="prepared_position" class="form-label">Designated Position</label>
                                <input class="form-control" id="prepared_position" name="prepared_position" required>
                            </div>
                            <div class="mt-3">
                                <label for="prepared_office" class="form-label">Office</label>
                                <input class="form-control" id="prepared_office" name="prepared_office" required>
                            </div>
                        </div>
                        <div class="form-group column col-6 justify-content-between">
                            <div>
                                <label for="recommended_by" class="form-label">Recommended By</label>
                                <input class="form-control" id="recommended_by" name="recommended_by" required>
                            </div>
                            <div class="mt-3">
                                <label for="recommended_plantilla" class="form-label">Plantilla Position</label>
                                <input class="form-control" id="recommended_plantilla" name="recommended_plantilla">
                            </div>
                            <div class="mt-3">
                                <label for="recommended_position" class="form-label">Designated Position</label>
                                <input class="form-control" id="recommended_position" name="recommended_position" required>
                            </div>
                            <div class="mt-3">
                                <label for="recommended_office" class="form-label">Office</label>
                                <input class="form-control" id="recommended_office" name="recommended_office" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Print</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function printVehicleList(data) {
        const {
            group_name,
            terminal_add,
            route_line,
            vehicle_ids,
            case_nos,
            plate_nos,
            driver_names
        } = data;

        // Create the HTML content
        let htmlContent = `
        <html>
        <head>
            <title>List of Vehicles per Terminal</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: center;
                }
                h2,h3,h4 {
                    margin:0;
                }
            </style>
        </head>
        <body>
        <div class="header">
            <h2>${group_name}</h2>
            <h3>(${terminal_add})</h3>
            <h4 style="margin-top:50px">${route_line}</h4>
        </div>
            <table>
                <tr>
                    <th>No</th>
                    <th>Operator</th>
                    <th>Case No.</th>
                    <th>Plate No.</th>
                </tr>`;

        // Split the comma-separated values and iterate over them
        const vehicleIdArray = vehicle_ids.split(', ');
        const caseNoArray = case_nos.split(', ');
        const plateNoArray = plate_nos.split(', ');
        const driverNameArray = driver_names.split(', ');

        vehicleIdArray.forEach((_, index) => {
            htmlContent += `
            <tr>
                <td>${index + 1}</td>
                <td>${driverNameArray[index]}</td>
                <td>${caseNoArray[index]}</td>
                <td>${plateNoArray[index]}</td>
            </tr>`;
        });

        htmlContent += `
            </table>
        </body>
        </html>`;

        // Open the HTML content in a new tab
        const printWindow = window.open('', '_blank');
        printWindow.document.write(htmlContent);
        printWindow.document.close();
    }

    function loadTable(type, id) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'load_table.php?type=' + type, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById(id).innerHTML = xhr.responseText;
                var options;
                if (hasPermission()) {
                    options = {
                        topStart: {
                            buttons: [{
                                    extend: 'copy',
                                    text: 'Copy',
                                    className: 'btn btn-info'
                                },
                                {
                                    extend: 'excel',
                                    text: 'Excel',
                                    className: 'btn btn-success'
                                },
                                {
                                    extend: 'pdf',
                                    text: 'PDF',
                                    className: 'btn btn-danger'
                                },
                                {
                                    extend: 'print',
                                    text: 'Print',
                                    className: 'btn btn-warning'
                                }
                            ]
                        },
                        bottomStart: {
                            pageLength: {
                                menu: [10, 25, 50, 100],
                            },
                        },
                    }
                } else {
                    options = {
                        topStart: null,
                        bottomStart: {
                            pageLength: {
                                menu: [10, 25, 50, 100],
                            },
                        },
                    }
                }
                $(`#dataTable_${type}`).DataTable({
                    layout: options
                });
            }
        };
        xhr.send();
    }

    function printInspectionClearance(clearanceData, isDefault) {
        const data = JSON.parse(clearanceData)
        if (isDefault) {
            var prepared_by = 'JESSE A. ABALORA';
            var prepared_plantilla = 'Traffic Aide I';
            var prepared_position = 'Officer-In-Charge';
            var prepared_office = 'Transportation Planning Division, TPMO';

            var recommended_by = 'RODRIGO M. DE DIOS';
            var recommended_plantilla = 'City Govt. Dept. Head II';
            var recommended_position = 'Officer-In-Charge';
            var recommended_office = 'Traffic and Parking Management Office';

            generateTemplate(data, prepared_by, prepared_plantilla, prepared_position, prepared_office, recommended_by, recommended_plantilla, recommended_position, recommended_office);
        }

        $('#signatoriesForm').on('submit', function(event) {
            event.preventDefault();

            var prepared_by = $('#prepared_by').val();
            var prepared_plantilla = $('#prepared_plantilla').val();
            var prepared_position = $('#prepared_position').val();
            var prepared_office = $('#prepared_office').val();

            var recommended_by = $('#recommended_by').val();
            var recommended_plantilla = $('#recommended_plantilla').val();
            var recommended_position = $('#recommended_position').val();
            var recommended_office = $('#recommended_office').val();

            generateTemplate(data, prepared_by, prepared_plantilla, prepared_position, prepared_office, recommended_by, recommended_plantilla, recommended_position, recommended_office);
            $('#signatoriesModal').modal('hide');
        });
    }

    function generateTemplate(data, prepared_by, prepared_plantilla, prepared_position, prepared_office, recommended_by, recommended_plantilla, recommended_position, recommended_office) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'inspection_clearance.html', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var template = xhr.responseText;

                var options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                var today = new Date();

                template = template.replace('{terminal_add}', data.terminal_add);
                template = template.replace('{group_name}', data.group_name);
                template = template.replace('{insp_date}', data.insp_date);
                template = template.replace('{reso_name}', data.reso_name);
                template = template.replace('{route_line}', data.route_line);
                template = template.replace('{total_vehicle_units}', data.total_vehicle_units);
                template = template.replace('{date}', today.toLocaleDateString("en-US", options));
                template = template.replace('{officer_list}', data.officer_list);
                template = template.replace('{billboard}', data.billboard);
                template = template.replace('{comfort_room}', data.comfort_room);
                template = template.replace('{tenm_away}', data.tenm_away);
                template = template.replace('{lot_area}', data.lot_area);
                template = template.replace('{waiting_shed}', data.waiting_shed);
                template = template.replace('{xerox}', data.xerox);
                template = template.replace('{remark}', data.insp_remark);

                template = template.replace('{prepared_by}', prepared_by);
                if (prepared_plantilla !== '') {
                    template = template.replace('{prepared_plantilla}', prepared_plantilla);
                    template = template.replace('{prepared_position}', prepared_position);
                    template = template.replace('{prepared_office}', prepared_office);
                } else {
                    template = template.replace('{prepared_plantilla}', prepared_position);
                    template = template.replace('{prepared_position}', prepared_office);
                    template = template.replace('{prepared_office}', '');
                }

                template = template.replace('{recommended_by}', recommended_by);
                if (recommended_plantilla !== '') {
                    template = template.replace('{recommended_plantilla}', recommended_plantilla);
                    template = template.replace('{recommended_position}', recommended_position);
                    template = template.replace('{recommended_office}', recommended_office);
                } else {
                    template = template.replace('{recommended_plantilla}', recommended_position);
                    template = template.replace('{recommended_position}', recommended_office);
                    template = template.replace('{recommended_office}', '');
                }

                var printWindow = window.open('', '_blank');
                printWindow.document.write(template);
                printWindow.document.close();
                printWindow.print();
            }
        };
        xhr.send();
    }

    function hasPermission() {
        return document.getElementById('container').getAttribute('has-permission') == 'true';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('insp_clearance-table');
        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-primary')) {
                var data = event.target.getAttribute('data-clearance');
                document.getElementById('addSignatory').setAttribute('data-clearance', data);
                document.getElementById('useDefault').setAttribute('data-clearance', data);
            }
        });
        var confirmAddSignatory = document.getElementById('addSignatory');
        confirmAddSignatory.addEventListener('click', function() {
            var data = event.target.getAttribute('data-clearance');
            printInspectionClearance(data, false)
        });

        var useDefault = document.getElementById('useDefault');
        useDefault.addEventListener('click', function() {
            var data = event.target.getAttribute('data-clearance');
            printInspectionClearance(data, true)
        });

        loadTable('operator', 'operator-table');
        loadTable('driver', 'driver-table');
        loadTable('vehicle_unit', 'vehicle-table');
        loadTable('route', 'route-table');
        loadTable('terminal', 'terminal-table');
        loadTable('insp_clearance', 'insp_clearance-table');
        loadTable('terminal-vehicles', 'terminal-vehicles-table');
    });
</script>