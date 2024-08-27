<?php
if (!hasPermission(2)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">PUV Vehicle Unit</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Vehicle Unit Records
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(11) ? 'block' : 'none'; ?>">Add New</button>
        </div>
        <br />
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Created At</th>
                        <th>Plate Number</th>
                        <th>Vehicle Type</th>
                        <th>Route</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT 
                        vehicle_unit.*,
                        unit_type.modal_name,
                        operator.id AS operator_id,
                        operator.optr_name,
                        operator_residency.resi_code AS resi_code,
                        terminal.id AS terminal_id,
                        terminal.terminal_name,
                        terminal.terminal_add,
                        trans_group.id AS group_id,
                        trans_group.group_name,
                        cases.id AS case_id,
                        cases.case_no,
                        cases.case_granted,
                        cases.case_expire,
                        route.id AS route_id,
                        route.route_line,
                        route.route_struct,
                        GROUP_CONCAT(driver.id SEPARATOR ", ") AS driver_ids,
                        GROUP_CONCAT(driver.driver_name SEPARATOR ", ") AS driver_names,
                        GROUP_CONCAT(driver_residency.resi_code SEPARATOR ", ") AS driver_resi_codes
                    FROM vehicle_unit
                    LEFT JOIN unit_type ON vehicle_unit.vtype_id = unit_type.vtype_id
                    LEFT JOIN operator ON vehicle_unit.optr_id = operator.id
                    LEFT JOIN residency AS operator_residency ON operator.resi_id = operator_residency.id
                    LEFT JOIN terminal ON vehicle_unit.terminal_id = terminal.id
                    LEFT JOIN trans_group ON vehicle_unit.group_id = trans_group.id
                    LEFT JOIN cases ON vehicle_unit.case_id = cases.id
                    LEFT JOIN vehicle_driver ON vehicle_unit.id = vehicle_driver.veh_id
                    LEFT JOIN route ON cases.route_id = route.id
                    LEFT JOIN driver ON vehicle_driver.driver_id = driver.id
                    LEFT JOIN residency AS driver_residency ON driver.resi_id = driver_residency.id
                    GROUP BY vehicle_unit.id';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_assoc($result)) {
                        $vehicleData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . $row['created_at'] . '</td>';
                        echo '<td>' . $row['plate_no'] . '</td>';
                        echo '<td>' . $row['modal_name'] . '</td>';
                        echo '<td>' . $row['route_line'] . '</td>';
                        echo '<td>';
                        if (hasPermission(2)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-vehicle="' . $vehicleData . '">VIEW</button>';
                        }
                        if (hasPermission(12)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-vehicle="' . $vehicleData . '">EDIT</button>';
                        }
                        if (hasPermission(13)) {
                            echo '<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="' . htmlspecialchars($row['id']) . '">DELETE</button>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" id="addModalForm" action="trms.php?page=vehicletrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Vehicle Unit</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a id="add-info-tab" class="nav-link active" data-toggle="tab" href="#add-basic-info">Basic Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#add-additional-info">Additional Info</a>
                        </li>
                        <li class="nav-item">
                            <a id="add-drivers-tab" class="nav-link" data-toggle="tab" href="#add-drivers-info">Drivers</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="add-basic-info" class="tab-pane active">
                            <div class="form-group row mt-3">
                                <?php
                                // Fetch the current year
                                $current_year = date('Y');

                                // Fetch the highest current ID for the current year
                                $query = "
                                    SELECT MAX(CAST(SUBSTRING(veh_id, LENGTH('V$current_year-') + 1) AS UNSIGNED)) AS max_id
                                    FROM vehicle_unit
                                    WHERE veh_id LIKE 'V$current_year-%'
                                ";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_assoc($result);

                                // Increment the max ID by 1
                                $next_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
                                $next_id_padded = str_pad($next_id, 5, '0', STR_PAD_LEFT); // Format the number with leading zeros
                                $prefixed_id = "V$current_year-$next_id_padded"; // Combine year and number
                                ?>
                                <div class="col-6">
                                    <label for="veh_id" class="form-label">Vehicle ID</label>
                                    <input class="form-control" name="veh_id" value="<?php echo htmlspecialchars($prefixed_id); ?>" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="vtype_id" class="form-label">Vehicle Type</label>
                                    <select class="form-select" name="vtype_id" required>
                                        <option value="" selected>Select</option>
                                        <?php
                                        $vtype_query = 'SELECT * FROM unit_type';
                                        $vtype_result = mysqli_query($conn, $vtype_query) or die(mysqli_error($conn));
                                        while ($vtype_row = mysqli_fetch_assoc($vtype_result)) {
                                            echo "<option value='" . htmlspecialchars($vtype_row['vtype_id']) . "'>" . htmlspecialchars($vtype_row['modal_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="plate_no" class="form-label">Plate Number</label>
                                <input class="form-control" name="plate_no" required>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-6">
                                    <label for="terminal_id" class="form-label">Vehicle Terminal</label>
                                    <select class="form-select terminal-select" name="terminal_id" onchange="updateCaseOptions('add', this)" required>
                                        <option value="" selected>Select</option>
                                        <?php
                                        $terminal_query = 'SELECT * FROM terminal';
                                        $terminal_result = mysqli_query($conn, $terminal_query) or die(mysqli_error($conn));
                                        while ($terminal_row = mysqli_fetch_assoc($terminal_result)) {
                                            echo "<option value='" . htmlspecialchars($terminal_row['id']) . "' data-route-id='" . htmlspecialchars($terminal_row['route_id']) . "'>" . htmlspecialchars($terminal_row['terminal_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="optr_id" class="form-label">Vehicle Operator</label>
                                    <select class="form-select" name="optr_id" required>
                                        <option value="" selected>Select</option>
                                        <?php
                                        $optr_query = 'SELECT * FROM operator';
                                        $optr_result = mysqli_query($conn, $optr_query) or die(mysqli_error($conn));
                                        while ($optr_row = mysqli_fetch_assoc($optr_result)) {
                                            echo "<option value='" . htmlspecialchars($optr_row['id']) . "'>" . htmlspecialchars($optr_row['optr_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col-6">
                                    <label for="case_id" class="form-label">Case No.</label>
                                    <select class="form-select cases-select" name="case_id" id="caseSelect" required>
                                        <option value="" selected>Select</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="group_id" class="form-label">Transport Group</label>
                                    <select class="form-select" name="group_id" required>
                                        <option value="" selected>Select</option>
                                        <?php
                                        $group_query = 'SELECT * FROM trans_group';
                                        $group_result = mysqli_query($conn, $group_query) or die(mysqli_error($conn));
                                        while ($group_row = mysqli_fetch_assoc($group_result)) {
                                            echo "<option value='" . htmlspecialchars($group_row['id']) . "'>" . htmlspecialchars($group_row['group_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="add-additional-info" class="tab-pane fade">
                            <div class="form-group row mt-3">
                                <div class="col-6">
                                    <label for="cr_no" class="form-label">CR Number</label>
                                    <input class="form-control" name="cr_no" required>
                                </div>
                                <div class="col-6">
                                    <label for="engine_no" class="form-label">Engine Number</label>
                                    <input class="form-control" name="engine_no" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="chassis_no" class="form-label">Chassis Number</label>
                                <input class="form-control" name="chassis_no" required>
                            </div>
                        </div>
                        <div id="add-drivers-info" class="tab-pane fade driver-pane">
                            <div class="form-group mt-3">
                                <div class="row">
                                    <label class="form-label">Drivers</label>
                                </div>
                                <div id="add_drivers_info">
                                    <div class="form-group row mt-2">
                                        <div class="col-11">
                                            <select class="form-select driver-select" name="drivers[]" onchange="updateDriverOptions('add')" required>
                                                <option value="" selected>Select Driver</option>
                                                <?php
                                                $driver_query = 'SELECT * FROM driver';
                                                $driver_result = mysqli_query($conn, $driver_query) or die(mysqli_error($conn));
                                                while ($driver_row = mysqli_fetch_assoc($driver_result)) {
                                                    echo "<option value='" . htmlspecialchars($driver_row['id']) . "'>" . htmlspecialchars($driver_row['driver_name']) . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="btn btn-primary" onclick="addDriverRow('add')" onchange="updateDriverOptions('add')">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Record</button>
                        <button type="reset" class="btn btn-outline-warning">Clear Entry</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form role="form" method="post" action="trms.php?page=vehicletrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Vehicle Unit</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="row col-12 text-center pt-3">
                    <h2 id="header_edit_veh_id"></h2>
                </div>
                <div class="modal-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a id="edit-info-tab" class="nav-link active" data-toggle="tab" href="#edit-basic-info">Basic Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#edit-additional-info">Additional Info</a>
                        </li>
                        <li class="nav-item">
                            <a id="edit-drivers-tab" class="nav-link" data-toggle="tab" href="#edit-drivers-info">Drivers</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="edit-basic-info" class="tab-pane active">
                            <div class="form-group row mt-3">
                                <input class="form-control" name="id" id="edit_veh_id" readonly hidden>
                                <div class="col-6">
                                    <label for="edit_plate_no" class="form-label">Plate Number</label>
                                    <input class="form-control" name="plate_no" id="edit_plate_no" required>
                                </div>
                                <div class="col-6">
                                    <label for="edit_vtype_id" class="form-label">Vehicle Type</label>
                                    <select class="form-select" name="vtype_id" id="edit_vtype_id" required>
                                        <?php
                                        $vtype_query = 'SELECT * FROM unit_type';
                                        $vtype_result = mysqli_query($conn, $vtype_query) or die(mysqli_error($conn));
                                        while ($vtype_row = mysqli_fetch_assoc($vtype_result)) {
                                            echo "<option value='" . htmlspecialchars($vtype_row['vtype_id']) . "'>" . htmlspecialchars($vtype_row['modal_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col-6">
                                    <label for="edit_terminal_id" class="form-label">Vehicle Terminal</label>
                                    <select class="form-select terminal-select" name="terminal_id" id="edit_terminal_id" onchange="updateCaseOptions('edit', this)" required>
                                        <?php
                                        $terminal_query = 'SELECT * FROM terminal';
                                        $terminal_result = mysqli_query($conn, $terminal_query) or die(mysqli_error($conn));
                                        while ($terminal_row = mysqli_fetch_assoc($terminal_result)) {
                                            echo "<option value='" . htmlspecialchars($terminal_row['id']) . "' data-route-id='" . htmlspecialchars($terminal_row['route_id']) . "'>" . htmlspecialchars($terminal_row['terminal_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="edit_optr_id" class="form-label">Vehicle Operator</label>
                                    <select class="form-select" name="optr_id" id="edit_optr_id" required>
                                        <?php
                                        $optr_query = 'SELECT * FROM operator';
                                        $optr_result = mysqli_query($conn, $optr_query) or die(mysqli_error($conn));
                                        while ($optr_row = mysqli_fetch_assoc($optr_result)) {
                                            echo "<option value='" . htmlspecialchars($optr_row['id']) . "'>" . htmlspecialchars($optr_row['optr_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col-6">
                                    <label for="edit_case_id" class="form-label">Case No.</label>
                                    <select class="form-select cases-select" name="case_id" id="edit_case_id" required>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="edit_group_id" class="form-label">Transport Group</label>
                                    <select class="form-select" name="group_id" id="edit_group_id" required>
                                        <?php
                                        $group_query = 'SELECT * FROM trans_group';
                                        $group_result = mysqli_query($conn, $group_query) or die(mysqli_error($conn));
                                        while ($group_row = mysqli_fetch_assoc($group_result)) {
                                            echo "<option value='" . htmlspecialchars($group_row['id']) . "'>" . htmlspecialchars($group_row['group_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="edit-additional-info" class="tab-pane fade">
                            <div class="form-group row mt-3">
                                <div class="col-6">
                                    <label for="edit_cr_no" class="form-label">CR Number</label>
                                    <input class="form-control" name="cr_no" id="edit_cr_no" required>
                                </div>
                                <div class="col-6">
                                    <label for="edit_engine_no" class="form-label">Engine Number</label>
                                    <input class="form-control" name="engine_no" id="edit_engine_no" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="edit_chassis_no" class="form-label">Chassis Number</label>
                                <input class="form-control" name="chassis_no" id="edit_chassis_no" required>
                            </div>
                        </div>
                        <div id="edit-drivers-info" class="tab-pane fade">
                            <div class="form-group mt-3">
                                <div class="row">
                                    <label class="form-label col-8">Drivers</label>
                                    <label class="form-label col-4">Residency</label>
                                </div>
                                <div id="edit_drivers_info"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Vehicle Unit</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="row col-12 text-center pt-3">
                <div class="d-flex flex-column col-4 offset-md-4 justify-content-center">
                    <h2 id="view_plate_no"></h2>
                    <h5 id="view_modal_name"></h5>
                    <h7 id="view_veh_id">
                        </h5>
                </div>
                <div class="col-4" id="qrContainer">
                </div>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a id="view-info-tab" class="nav-link active" data-toggle="tab" href="#view-basic-info">Basic Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#view-additional-info">Additional Info</a>
                    </li>
                    <li class="nav-item">
                        <a id="view-drivers-tab" class="nav-link" data-toggle="tab" href="#view-drivers-info">Drivers</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="view-basic-info" class="tab-pane active">
                        <div class="form-group row mt-3">
                            <div class="col-4">
                                <label for="view_case_no" class="form-label">Case/Decision</label>
                                <input class="form-control" id="view_case_no" readonly>
                            </div>
                            <div class="col-4">
                                <label for="view_case_granted" class="form-label">Granted</label>
                                <input class="form-control" id="view_case_granted" readonly>
                            </div>
                            <div class="col-4">
                                <label for="view_case_expired" class="form-label">Expiration</label>
                                <input class="form-control" id="view_case_expired" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="view_route_line" class="form-label">Route Line</label>
                            <input class="form-control" id="view_route_line" readonly>
                        </div>
                        <div class="form-group">
                            <label for="view_route_struct" class="form-label">Route Structure</label>
                            <input class="form-control" id="view_route_struct" readonly>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-8">
                                <label for="view_terminal_name" class="form-label">Terminal</label>
                                <div class="d-flex flex-column gap-3">
                                    <input class="form-control" id="view_terminal_name" readonly>
                                    <input class="form-control" id="view_terminal_add" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="view_status" class="form-label">Status</label>
                                <input class="form-control" id="view_status" value="On-Process" readonly>
                            </div>
                        </div>
                    </div>
                    <div id="view-additional-info" class="tab-pane fade">
                        <div class="form-group row mt-3">
                            <div class="col-4">
                                <label for="view_cr_no" class="form-label">CR Number</label>
                                <input class="form-control" id="view_cr_no" readonly>
                            </div>
                            <div class="col-4">
                                <label for="view_engine_no" class="form-label">Engine Number</label>
                                <input class="form-control" id="view_engine_no" readonly>
                            </div>
                            <div class="col-4">
                                <label for="view_chassis_no" class="form-label">Chassis Number</label>
                                <input class="form-control" id="view_chassis_no" readonly>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-8">
                                <label for="view_operator_name" class="form-label">Operator</label>
                                <input class="form-control" id="view_operator_name" readonly>
                            </div>
                            <div class="col-4">
                                <label for="view_operator_res" class="form-label">Residency</label>
                                <input class="form-control" id="view_operator_res" readonly>
                            </div>
                        </div>
                    </div>
                    <div id="view-drivers-info" class="tab-pane fade">
                        <div class="form-group mt-3">
                            <div class="row">
                                <label class="form-label col-8">Drivers</label>
                                <label class="form-label col-4">Residency</label>
                            </div>
                            <div id="view_drivers_info"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Vehicle Unit</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this vehicle unit?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(type, vehicleData) {
        console.log(vehicleData)
        const plate = document.getElementById(`${type}_plate_no`);
        document.getElementById(`${type}_cr_no`).value = vehicleData.cr_no;
        document.getElementById(`${type}_engine_no`).value = vehicleData.engine_no;
        document.getElementById(`${type}_chassis_no`).value = vehicleData.chassis_no;

        if (type === 'view') {
            plate.innerText = vehicleData.plate_no;
            fetch('generate_qr.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(vehicleData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.qrCodeUrl) {
                        document.getElementById('qrContainer').innerHTML =
                            '<img height="120px" src="' + data.qrCodeUrl + '" alt="QR Code">';
                    } else {
                        document.getElementById('qrContainer').innerHTML =
                            '<p>Error: ' + (data.error || 'Unknown error') + '</p>';
                    }
                })
                .catch(error => {
                    document.getElementById('qrContainer').innerHTML =
                        '<p>Error: ' + error.message + '</p>';
                });
                document.getElementById(`${type}_operator_res`).value = vehicleData.resi_code;
                document.getElementById(`${type}_veh_id`).innerText = vehicleData.veh_id;
                document.getElementById(`${type}_case_no`).value = vehicleData.case_no;
                document.getElementById(`${type}_modal_name`).innerText = vehicleData.modal_name;
                document.getElementById(`${type}_case_granted`).value = vehicleData.case_granted;
                document.getElementById(`${type}_case_expired`).value = vehicleData.case_expire;
                document.getElementById(`${type}_route_line`).value = vehicleData.route_line;
                document.getElementById(`${type}_route_struct`).value = vehicleData.route_struct;
                document.getElementById(`${type}_terminal_name`).value = vehicleData.terminal_name;
                document.getElementById(`${type}_terminal_add`).value = vehicleData.terminal_add;
                document.getElementById(`${type}_operator_name`).value = vehicleData.optr_name;
        } else if (type === 'edit') {
            plate.value = vehicleData.plate_no;
            document.getElementById(`${type}_veh_id`).value = vehicleData.id;
            document.getElementById(`header_${type}_veh_id`).innerText = vehicleData.veh_id;
            document.getElementById(`${type}_vtype_id`).value = vehicleData.vtype_id;
            document.getElementById(`${type}_terminal_id`).value = vehicleData.terminal_id;
            document.getElementById(`${type}_optr_id`).value = vehicleData.optr_id;
            document.getElementById(`${type}_case_id`).value = vehicleData.case_id;
            document.getElementById(`${type}_group_id`).value = vehicleData.group_id;
        }       

        const modalElement = document.getElementById(`${type}Modal`);

        const driverIds = vehicleData.driver_ids?.split(', ') || [];
        const driverNames = vehicleData.driver_names?.split(', ') || [];
        const driverResis = vehicleData.driver_resi_codes?.split(', ') || [];

        const terminalSelect = modalElement.querySelector('.terminal-select');

        if(type !== 'view'){
            updateCaseOptions(type, terminalSelect);
        }

        const driverContainer = document.getElementById(`${type}_drivers_info`);
        driverContainer.innerHTML = '';

        driverNames.forEach(function(driver, index) {
            var outerDiv = document.createElement('div');
            outerDiv.classList.add('form-group', 'row');

            var driverNameDiv = document.createElement('div');
            driverNameDiv.classList.add(type == 'view' ? 'col-8' : 'col-11');

            if (type === 'view') {
                console.log('e')
                var driverInput = document.createElement('input');
                driverInput.classList.add('form-control');
                driverInput.value = driver;
                driverInput.readOnly = true;
                driverNameDiv.appendChild(driverInput);

                var resiCodeDiv = document.createElement('div');
                resiCodeDiv.classList.add('col-4');

                var resiInput = document.createElement('input');
                resiInput.classList.add('form-control');
                resiInput.value = driverResis[index];
                resiInput.readOnly = true;

                resiCodeDiv.appendChild(resiInput);
                outerDiv.appendChild(driverNameDiv);
                outerDiv.appendChild(resiCodeDiv);
                driverContainer.appendChild(outerDiv);
            }
        });
        if (type === 'edit') {
            if (driverNames.length === 0) {
                addDriverRow(type, true);
            } else {
                addDriverRow(type, false, driverIds);
            }
        }
    }

    function addDriverRow(type, isInitial, selectedDriverIds = []) {
        const driversContainer = document.getElementById(`${type}_drivers_info`);
        const allSelects = driversContainer.querySelectorAll('.driver-select');
        const selectedDrivers = Array.from(allSelects).map(select => select.value);

        if (type === 'add') {
            const newRow = document.createElement('div');
            newRow.classList.add('form-group', 'row', 'mt-2');
            const col11 = document.createElement('div');
            col11.classList.add('col-11');

            const newSelect = document.createElement('select');
            newSelect.classList.add('form-select', 'driver-select');
            newSelect.name = 'drivers[]';
            newSelect.required = true;

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.selected = true;
            defaultOption.textContent = 'Select Driver';
            newSelect.appendChild(defaultOption);
            // Populate the select with available drivers
            <?php
            $driver_query = 'SELECT * FROM driver';
            $driver_result = mysqli_query($conn, $driver_query) or die(mysqli_error($conn));
            while ($driver_row = mysqli_fetch_assoc($driver_result)) {
                echo "var option = document.createElement('option');";
                echo "option.value = '" . htmlspecialchars($driver_row['id']) . "';";
                echo "option.textContent = '" . htmlspecialchars($driver_row['driver_name']) . "';";
                echo "if (!selectedDrivers.includes(option.value)) newSelect.appendChild(option);";
            }
            ?>
            // Pre-select drivers if provided
            selectedDrivers.forEach(id => {
                const option = newSelect.querySelector(`option[value='${id}']`);
                if (option) option.selected = true;
            });
            newSelect.addEventListener('change', function() {
                updateDriverOptions(type);
            });
            col11.appendChild(newSelect);
            const col1 = document.createElement('div');
            col1.classList.add('col-1');

            if (isInitial) {
                const addButton = document.createElement('button');
                addButton.type = 'button';
                addButton.classList.add('btn', 'btn-primary', 'driver-button');
                addButton.textContent = '+';
                addButton.onclick = function() {
                    addDriverRow(type, false);
                    updateDriverOptions(type);
                };
                col1.appendChild(addButton);
            } else {
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.classList.add('btn', 'btn-danger', 'driver-button');
                deleteButton.textContent = '-';
                deleteButton.onclick = function() {
                    driversContainer.removeChild(newRow);
                    updateDriverOptions(type);
                };
                col1.appendChild(deleteButton);
            }
            newRow.appendChild(col11);
            newRow.appendChild(col1);
            driversContainer.appendChild(newRow);
        } else {
            if (!selectedDriverIds) {
                const newRow = document.createElement('div');
                newRow.classList.add('form-group', 'row', 'mt-2');
                const col11 = document.createElement('div');
                col11.classList.add('col-11');

                const newSelect = document.createElement('select');
                newSelect.classList.add('form-select', 'driver-select');
                newSelect.name = 'drivers[]';
                newSelect.required = true;

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.selected = true;
                defaultOption.textContent = 'Select Driver';
                newSelect.appendChild(defaultOption);
                // Populate the select with available drivers
                <?php
                $driver_query = 'SELECT * FROM driver';
                $driver_result = mysqli_query($conn, $driver_query) or die(mysqli_error($conn));
                while ($driver_row = mysqli_fetch_assoc($driver_result)) {
                    echo "var option = document.createElement('option');";
                    echo "option.value = '" . htmlspecialchars($driver_row['id']) . "';";
                    echo "option.textContent = '" . htmlspecialchars($driver_row['driver_name']) . "';";
                    echo "if (!selectedDrivers.includes(option.value)) newSelect.appendChild(option);";
                }
                ?>
                // Pre-select drivers if provided
                selectedDrivers.forEach(id => {
                    const option = newSelect.querySelector(`option[value='${id}']`);
                    if (option) option.selected = true;
                });
                newSelect.addEventListener('change', function() {
                    updateDriverOptions(type);
                });
                col11.appendChild(newSelect);
                const col1 = document.createElement('div');
                col1.classList.add('col-1');

                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.classList.add('btn', 'btn-danger', 'driver-button');
                deleteButton.textContent = '-';
                deleteButton.onclick = function() {
                    driversContainer.removeChild(newRow);
                    updateDriverOptions(type);
                };
                col1.appendChild(deleteButton);

                newRow.appendChild(col11);
                newRow.appendChild(col1);
                driversContainer.appendChild(newRow);

            } else {

                <?php
                $driver_query = 'SELECT * FROM driver';
                $driver_result = mysqli_query($conn, $driver_query) or die(mysqli_error($conn));
                $drivers = [];
                while ($driver_row = mysqli_fetch_assoc($driver_result)) {
                    $drivers[] = $driver_row;
                }
                ?>
                const allDrivers = <?php echo json_encode($drivers); ?>;

                const remainingDrivers = allDrivers.filter(driver => !selectedDriverIds.includes(driver.id))
                selectedDriverIds.forEach((id, index) => {
                    const newRow = document.createElement('div');
                    newRow.classList.add('form-group', 'row', 'mt-2');

                    const col11 = document.createElement('div');
                    col11.classList.add('col-11');

                    const newSelect = document.createElement('select');
                    newSelect.classList.add('form-select', 'driver-select');
                    newSelect.name = 'drivers[]';
                    newSelect.required = true;

                    const defaultOption = document.createElement('option');
                    const driver = allDrivers.find(d => d.id === id);
                    defaultOption.value = driver.id;
                    defaultOption.selected = true;
                    defaultOption.textContent = driver.driver_name;
                    newSelect.appendChild(defaultOption);

                    // Add remaining drivers as options
                    remainingDrivers.forEach(driver => {
                        const option = document.createElement('option');
                        option.value = driver.id;
                        option.textContent = driver.driver_name;
                        newSelect.appendChild(option);
                    });

                    newSelect.addEventListener('change', function() {
                        updateDriverOptions(type);
                    });
                    col11.appendChild(newSelect);
                    const col1 = document.createElement('div');
                    col1.classList.add('col-1');

                    if (index === 0) {
                        const addButton = document.createElement('button');
                        addButton.type = 'button';
                        addButton.classList.add('btn', 'btn-primary', 'driver-button');
                        addButton.textContent = '+';
                        addButton.onclick = function() {
                            addDriverRow(type, false, null);
                            updateDriverOptions(type);
                        };
                        col1.appendChild(addButton);
                    } else {
                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.classList.add('btn', 'btn-danger', 'driver-button');
                        deleteButton.textContent = '-';
                        deleteButton.onclick = function() {
                            driversContainer.removeChild(newRow);
                            updateDriverOptions(type);
                        };
                        col1.appendChild(deleteButton);
                    }
                    newRow.appendChild(col11);
                    newRow.appendChild(col1);
                    driversContainer.appendChild(newRow);
                })
            }
        }
    }

    function updateCaseOptions(type, terminalSelect) {
        <?php
        // Fetch all cases from the database
        $cases_query = 'SELECT * FROM cases';
        $cases_result = mysqli_query($conn, $cases_query) or die(mysqli_error($conn));
        $cases = [];
        while ($cases_row = mysqli_fetch_assoc($cases_result)) {
            $cases[] = $cases_row;
        }
        ?>

        // Convert the PHP cases array to a JavaScript array
        const allCases = <?php echo json_encode($cases); ?>;
        const modalType = document.getElementById(`${type}Modal`);

        // Select the cases select element within the modal
        const casesSelect = modalType.querySelector('.cases-select');

        // Get the selected terminal route ID
        const selectedRouteId = terminalSelect.options[terminalSelect.selectedIndex].getAttribute('data-route-id');

        // Filter the cases based on the selected terminal and route ID
        const remainingCases = allCases.filter(caseItem => caseItem.route_id == selectedRouteId);

        console.log(remainingCases);

        casesSelect.innerHTML = '';
        // Clear the existing options in the cases select element
        if (type === 'add' && remainingCases.length > 0) {
            casesSelect.innerHTML = '<option value="" selected>Select</option>';
        } else if (type === 'add' && remainingCases.length === 0) {
            casesSelect.innerHTML = '<option value="" selected>No available cases for matching route</option>';
        }
        // Add the filtered cases as options in the cases select element
        remainingCases.forEach(caseItem => {
            const option = document.createElement('option');
            option.value = caseItem.id;
            option.textContent = caseItem.case_no;
            casesSelect.appendChild(option);
        });

        // If type is edit, select the current value
        if (type === 'edit') {
            const currentCaseId = modalType.querySelector('.cases-select').getAttribute('data-current-case-id');
            if (currentCaseId) {
                casesSelect.value = currentCaseId;
            }
        }
    }

    function updateDriverOptions(type) {
        <?php
        $driver_query = 'SELECT * FROM driver';
        $driver_result = mysqli_query($conn, $driver_query) or die(mysqli_error($conn));
        $drivers = [];
        while ($driver_row = mysqli_fetch_assoc($driver_result)) {
            $drivers[] = $driver_row;
        }
        ?>
        const allDrivers = <?php echo json_encode($drivers); ?>;

        const modalType = document.getElementById(`${type}Modal`)

        const allSelects = modalType.querySelectorAll('.driver-select');
        const selectedDrivers = Array.from(allSelects).map(select => select.value);

        const remainingDrivers = allDrivers.filter(driver => !selectedDrivers.includes(driver.id));

        allSelects.forEach(select => {
            const selected = select.querySelectorAll('option')
            var option
            selected.forEach(select => {
                if (select.selected) {
                    option = select;
                }
            })

            // Clear existing options
            select.innerHTML = '';

            if (type === 'add') {
                // Add default option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.selected = true;
                defaultOption.textContent = 'Select Driver';
                select.appendChild(defaultOption);
            }
            if (option.value !== "") {
                select.appendChild(option);
            }
            // Add remaining drivers as options
            remainingDrivers.forEach(driver => {
                const option = document.createElement('option');
                option.value = driver.id;
                option.textContent = driver.driver_name;
                select.appendChild(option);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var modalArray = document.querySelectorAll('.modal');
        modalArray.forEach((modal) => {
            const modalForm = modal.querySelector('form');
            const infoTab = modal.querySelector('.nav-item > :first-child');
            const infoPane = modal.querySelector('.tab-content > :first-child');
            $(modal).on('hidden.bs.modal', function(e) {
                if (modalForm && modalForm.id == 'addModalForm') {
                    modalForm.reset();
                    document.getElementById('add_drivers_info').innerHTML = '';
                    addDriverRow('add', true);
                }
                modal.querySelectorAll('.nav-tabs .nav-item .nav-link').forEach(function(tabLink) {
                    tabLink.classList.remove('active');
                });
                modal.querySelectorAll('.tab-content .tab-pane').forEach(function(tabPane) {
                    tabPane.classList.remove('active');
                });
                infoTab.classList.add('active');
                infoPane.classList.add('active');
                infoPane.classList.add('show');
            });
        });

        var dataTable = document.getElementById('dataTable');
        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-info') || event.target.classList.contains('btn-warning')) {
                var vehicleData = JSON.parse(event.target.getAttribute('data-vehicle'));
                var type = event.target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, vehicleData);
            } else if (event.target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function(event) {
            var id = event.target.getAttribute('data-id');
            window.location.href = 'trms.php?page=vehicletrans&action=delete&id=' + id;
        });

    });
</script>