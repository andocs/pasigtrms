<?php
if(!hasPermission(3)){
    redirectTo('warning','You do not have access!','trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Terminal Record Details</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Terminal Records
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(15) ? 'block' : 'none'; ?>">Add New</button>
        </div><br />
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Terminal ID</th>
                        <th>Terminal Name</th>
                        <th>Terminal Address</th>
                        <th>Route Line</th>
                        <th>Resolution Name</th>
                        <th>Group Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT 
                        terminal.*, 
                        route.id AS route_id, route.route_line, 
                        term_approval.id AS reso_id, term_approval.reso_name, 
                        trans_group.id AS group_id, trans_group.group_name,
                        insp_clearance.id AS insp_clearance_id, insp_clearance.insp_id
                    FROM terminal
                    LEFT JOIN route ON terminal.route_id = route.id
                    LEFT JOIN term_approval ON terminal.reso_id = term_approval.id
                    LEFT JOIN trans_group ON terminal.group_id = trans_group.id
                    LEFT JOIN insp_clearance ON terminal.insp_id = insp_clearance.id';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_assoc($result)) {
                        $terminalData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['terminal_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['terminal_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['terminal_add']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['route_line']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['reso_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['group_name']) . '</td>';
                        echo '<td>';
                        if (hasPermission(3)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-terminal="' . $terminalData . '">VIEW</button>';
                        } 
                        if (hasPermission(16)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-terminal="' . $terminalData . '">EDIT</button>';
                        }
                        if (hasPermission(17)) {
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
    <div class="modal-dialog modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" action="trms.php?page=terminaltrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Terminal</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row justify-content-between">
                        <?php

                        // Fetch the highest current ID for the current year
                        $query = "
                            SELECT MAX(CAST(SUBSTRING(terminal_id, LENGTH('T') + 1) AS UNSIGNED)) AS max_id
                            FROM terminal
                            WHERE terminal_id LIKE 'T%'
                        ";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);

                        // Increment the max ID by 1
                        $next_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
                        $next_id_padded = str_pad($next_id, 4, '0', STR_PAD_LEFT); // Format the number with leading zeros
                        $prefixed_id = "T$next_id_padded"; // Combine year and number
                        ?>
                        <div class="col-6">
                            <label for="terminal_id" class="form-label">Terminal ID</label>
                            <input class="form-control" name="terminal_id" value="<?php echo htmlspecialchars($prefixed_id); ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label for="terminal_name" class="form-label">Terminal Name</label>
                            <input class="form-control" name="terminal_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="terminal_add" class="form-label">Terminal Address</label>
                        <input class="form-control" name="terminal_add" required>
                    </div>
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <label for="route_id" class="form-label">Route</label>
                            <select class="form-select" name="route_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch route options
                                $route_query = 'SELECT * FROM route';
                                $route_result = mysqli_query($conn, $route_query) or die(mysqli_error($conn));
                                while ($route_row = mysqli_fetch_assoc($route_result)) {
                                    echo "<option value='" . htmlspecialchars($route_row['id']) . "'>" . htmlspecialchars($route_row['route_line']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="insp_id" class="form-label">Inspection ID</label>
                            <select class="form-select" name="insp_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch insp_clearance options
                                $insp_query = 'SELECT * FROM insp_clearance';
                                $insp_result = mysqli_query($conn, $insp_query) or die(mysqli_error($conn));
                                while ($insp_row = mysqli_fetch_assoc($insp_result)) {
                                    echo "<option value='" . htmlspecialchars($insp_row['id']) . "'>" . htmlspecialchars($insp_row['insp_id']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <label for="reso_id" class="form-label">Resolution</label>
                            <select class="form-select" name="reso_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch term_approval options
                                $reso_query = 'SELECT * FROM term_approval';
                                $reso_result = mysqli_query($conn, $reso_query) or die(mysqli_error($conn));
                                while ($reso_row = mysqli_fetch_assoc($reso_result)) {
                                    echo "<option value='" . htmlspecialchars($reso_row['id']) . "'>" . htmlspecialchars($reso_row['reso_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="group_id" class="form-label">Group</label>
                            <select class="form-select" name="group_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch group options
                                $group_query = 'SELECT * FROM trans_group';
                                $group_result = mysqli_query($conn, $group_query) or die(mysqli_error($conn));
                                while ($group_row = mysqli_fetch_assoc($group_result)) {
                                    echo "<option value='" . htmlspecialchars($group_row['id']) . "'>" . htmlspecialchars($group_row['group_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="busi_permit" class="form-label">Business Permit</label>
                        <input class="form-control" name="busi_permit" required>
                    </div>
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <label for="busi_date" class="form-label">Business Registration</label>
                            <input class="form-control" type="date" name="busi_date" required>
                        </div>
                        <div class="col-6">
                            <label for="busi_expire" class="form-label">Business Expiration</label>
                            <input class="form-control" type="date" name="busi_expire" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Record</button>
                    <button type="reset" class="btn btn-outline-warning">Clear Entry</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" action="trms.php?page=terminaltrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Terminal</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input class="form-control" name="id" id="edit_id" hidden>
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <label for="edit_terminal_id" class="form-label">Terminal ID</label>
                            <input class="form-control" name="terminal_id" id="edit_terminal_id" readonly required>
                        </div>
                        <div class="col-6">
                            <label for="edit_terminal_name" class="form-label">Terminal Name</label>
                            <input class="form-control" name="terminal_name" id="edit_terminal_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_terminal_add" class="form-label">Terminal Address</label>
                        <input class="form-control" name="terminal_add" id="edit_terminal_add" required>
                    </div>
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <label for="edit_route_id" class="form-label">Route</label>
                            <select class="form-select" name="route_id" id="edit_route_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch route options
                                $route_query = 'SELECT * FROM route';
                                $route_result = mysqli_query($conn, $route_query) or die(mysqli_error($conn));
                                while ($route_row = mysqli_fetch_assoc($route_result)) {
                                    echo "<option value='" . htmlspecialchars($route_row['id']) . "'>" . htmlspecialchars($route_row['route_line']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="edit_insp_id" class="form-label">Inspection ID</label>
                            <select class="form-select" name="insp_id" id="edit_insp_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch insp_clearance options
                                $insp_query = 'SELECT * FROM insp_clearance';
                                $insp_result = mysqli_query($conn, $insp_query) or die(mysqli_error($conn));
                                while ($insp_row = mysqli_fetch_assoc($insp_result)) {
                                    echo "<option value='" . htmlspecialchars($insp_row['id']) . "'>" . htmlspecialchars($insp_row['insp_id']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <label for="edit_reso_id" class="form-label">Resolution</label>
                            <select class="form-select" name="reso_id" id="edit_reso_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch term_approval options
                                $reso_query = 'SELECT * FROM term_approval';
                                $reso_result = mysqli_query($conn, $reso_query) or die(mysqli_error($conn));
                                while ($reso_row = mysqli_fetch_assoc($reso_result)) {
                                    echo "<option value='" . htmlspecialchars($reso_row['id']) . "'>" . htmlspecialchars($reso_row['reso_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="edit_group_id" class="form-label">Group</label>
                            <select class="form-select" name="group_id" id="edit_group_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch group options
                                $group_query = 'SELECT * FROM trans_group';
                                $group_result = mysqli_query($conn, $group_query) or die(mysqli_error($conn));
                                while ($group_row = mysqli_fetch_assoc($group_result)) {
                                    echo "<option value='" . htmlspecialchars($group_row['id']) . "'>" . htmlspecialchars($group_row['group_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_busi_permit" class="form-label">Business Permit</label>
                        <input class="form-control" name="busi_permit" id="edit_busi_permit" required>
                    </div>
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <label for="edit_busi_date" class="form-label">Business Registration</label>
                            <input class="form-control" type="date" name="busi_date" id="edit_busi_date" required>
                        </div>
                        <div class="col-6">
                            <label for="edit_busi_expire" class="form-label">Business Expiration</label>
                            <input class="form-control" type="date" name="busi_expire" id="edit_busi_expire" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- View Modal -->
<div id="viewModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Terminal</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row justify-content-between">
                    <div class="col-6">
                        <label for="view_terminal_id" class="form-label">Terminal ID</label>
                        <input class="form-control" name="terminal_id" id="view_terminal_id" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_terminal_name" class="form-label">Terminal Name</label>
                        <input class="form-control" name="terminal_name" id="view_terminal_name" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="view_terminal_add" class="form-label">Terminal Address</label>
                    <input class="form-control" name="terminal_add" id="view_terminal_add" readonly>
                </div>
                <div class="form-group row justify-content-between">
                    <div class="col-6">
                        <label for="view_route_id" class="form-label">Route</label>
                        <input class="form-control" id="view_route_id" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_insp_id" class="form-label">Inspection ID</label>
                        <input class="form-control" id="view_insp_id" readonly>
                    </div>
                </div>
                <div class="form-group row justify-content-between">
                    <div class="col-6">
                        <label for="view_reso_id" class="form-label">Resolution</label>
                        <input class="form-control" id="view_reso_id" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_group_id" class="form-label">Group</label>
                        <input class="form-control" id="view_group_id" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="view_busi_permit" class="form-label">Business Permit</label>
                    <input class="form-control" id="view_busi_permit" readonly>
                </div>
                <div class="form-group row justify-content-between">
                    <div class="col-6">
                        <label for="view_busi_date" class="form-label">Business Registration</label>
                        <input class="form-control" type="date" id="view_busi_date" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_busi_expire" class="form-label">Business Expiration</label>
                        <input class="form-control" type="date" id="view_busi_expire" readonly>
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
                <h4 class="modal-title">Delete Terminal</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this terminal?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    function showModal(type, terminalData) {
        console.log(terminalData)
        document.getElementById(`${type}_terminal_id`).value = terminalData.terminal_id;
        document.getElementById(`${type}_terminal_name`).value = terminalData.terminal_name;
        document.getElementById(`${type}_terminal_add`).value = terminalData.terminal_add;
        document.getElementById(`${type}_insp_id`).value = terminalData.insp_clearance_id;

        if (type === 'edit' || type === 'view') {
            switch (type) {
                case 'view':
                    document.getElementById(`${type}_route_id`).value = terminalData.route_line;
                    document.getElementById(`${type}_reso_id`).value = terminalData.reso_name;
                    document.getElementById(`${type}_group_id`).value = terminalData.group_name;
                    break;
                case 'edit':
                    document.getElementById(`${type}_route_id`).value = terminalData.route_id;
                    document.getElementById(`${type}_reso_id`).value = terminalData.reso_id;
                    document.getElementById(`${type}_group_id`).value = terminalData.group_id;
                    break;

                default:
                    break;
            }

            document.getElementById(`${type}_busi_permit`).value = terminalData.busi_permit;
            document.getElementById(`${type}_busi_date`).value = terminalData.busi_date;
            document.getElementById(`${type}_busi_expire`).value = terminalData.busi_expire;
        }

        if (document.getElementById(`${type}_id`)) {
            document.getElementById(`${type}_id`).value = terminalData.id;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');
        dataTable.addEventListener('click', function(event) {
            var target = event.target;

            if (target.classList.contains('btn-info') || target.classList.contains('btn-warning')) {
                var terminalData = JSON.parse(target.getAttribute('data-terminal'));
                var type = target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, terminalData);
            } else if (target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function() {
            var id = event.target.getAttribute('data-id');
            window.location.href = 'trms.php?page=terminaltrans&action=delete&id=' + id;
        });
    });
</script>