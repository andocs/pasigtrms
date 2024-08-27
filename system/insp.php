<?php
if (!hasPermission(42)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Inspections</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Inspections
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(52) ? 'block' : 'none'; ?>">Add New</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Inspection ID</th>
                        <th>Terminal</th>
                        <th>Inspection Date</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT insp_clearance.*, terminal.id AS terminal_id, terminal.terminal_name 
                              FROM insp_clearance 
                              INNER JOIN terminal ON insp_clearance.terminal_id = terminal.id';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                    while ($row = mysqli_fetch_assoc($result)) {
                        $inspData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['insp_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['terminal_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['insp_date']) . '</td>';
                        echo '<td>';
                        if (hasPermission(42)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-insp="' . $inspData . '">VIEW</button>';
                        }
                        if (hasPermission(53)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-insp="' . $inspData . '">EDIT</button>';
                        }
                        if (hasPermission(54)) {
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
        <div class="modal-content">
            <form role="form" method="post" action="trms.php?page=insptrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Inspection</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <?php
                        // Fetch the current year
                        $current_year = date('Y');

                        // Fetch the highest current ID for the current year
                        $query = "
                            SELECT MAX(CAST(SUBSTRING(insp_id, LENGTH('INSP-$current_year-') + 1) AS UNSIGNED)) AS max_id
                            FROM insp_clearance
                            WHERE insp_id LIKE 'INSP-$current_year-%'
                        ";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);

                        // Increment the max ID by 1
                        $next_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
                        $next_id_padded = str_pad($next_id, 3, '0', STR_PAD_LEFT); // Format the number with leading zeros
                        $prefixed_id = "INSP-$current_year-$next_id_padded"; // Combine year and number
                        ?>
                        <div class="col-6">
                            <label for="insp_id" class="form-label">Inspection ID</label>
                            <input class="form-control" name="insp_id" value="<?php echo htmlspecialchars($prefixed_id); ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label for="insp_date" class="form-label">Inspection Date</label>
                            <input type="date" class="form-control" name="insp_date" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="terminal_id" class="form-label">Terminal</label>
                            <select class="form-select" name="terminal_id" required>
                                <option value="">Select</option>
                                <?php
                                $terminals = mysqli_query($conn, "SELECT * FROM terminal");
                                while ($terminal = mysqli_fetch_assoc($terminals)) {
                                    echo '<option value="' . htmlspecialchars($terminal['id']) . '">' . htmlspecialchars($terminal['terminal_name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="officer_list" class="form-label">Officer List</label>
                            <select class="form-select" name="officer_list" required>
                                <option value="">Select</option>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label for="billboard" class="form-label">Billboard</label>
                            <select class="form-select" name="billboard" required>
                                <option value="">Select</option>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="comfort_room" class="form-label">Comfort Room</label>
                            <select class="form-select" name="comfort_room" required>
                                <option value="">Select</option>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="tenm_away" class="form-label">Ten Meters Away</label>
                            <select class="form-select" name="tenm_away" required>
                                <option value="">Select</option>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="lot_area" class="form-label">Lot Area</label>
                            <select class="form-select" name="lot_area" required>
                                <option value="">Select</option>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label for="waiting_shed" class="form-label">Waiting Shed</label>
                            <select class="form-select" name="waiting_shed" required>
                                <option value="">Select</option>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="xerox" class="form-label">Xerox</label>
                            <select class="form-select" name="xerox" required>
                                <option value="">Select</option>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="insp_remark" class="form-label">Inspection Remarks</label>
                        <textarea class="form-control" name="insp_remark" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Record</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form role="form" method="post" action="trms.php?page=insptrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Inspection</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input class="form-control" name="id" id="edit_id" hidden>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="edit_insp_id" class="form-label">Inspection ID</label>
                            <input class="form-control" name="insp_id" id="edit_insp_id" readonly>
                        </div>
                        <div class="col-6">
                            <label for="edit_insp_date" class="form-label">Inspection Date</label>
                            <input type="date" class="form-control" name="insp_date" id="edit_insp_date" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="edit_terminal_id" class="form-label">Terminal</label>
                            <select class="form-select" name="terminal_id" id="edit_terminal_id" required>
                                <option value="">Select</option>
                                <?php
                                // Fetch terminals for selection
                                $terminals = mysqli_query($conn, "SELECT * FROM terminal");
                                while ($terminal = mysqli_fetch_assoc($terminals)) {
                                    echo '<option value="' . htmlspecialchars($terminal['id']) . '">' . htmlspecialchars($terminal['terminal_name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="edit_officer_list" class="form-label">Officer List</label>
                            <select class="form-select" name="officer_list" id="edit_officer_list" required>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="edit_billboard" class="form-label">Billboard</label>
                            <select class="form-select" name="billboard" id="edit_billboard" required>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="edit_comfort_room" class="form-label">Comfort Room</label>
                            <select class="form-select" name="comfort_room" id="edit_comfort_room" required>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="edit_tenm_away" class="form-label">Ten Meters Away</label>
                            <select class="form-select" name="tenm_away" id="edit_tenm_away" required>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="edit_lot_area" class="form-label">Lot Area</label>
                            <select class="form-select" name="lot_area" id="edit_lot_area" required>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="edit_waiting_shed" class="form-label">Waiting Shed</label>
                            <select class="form-select" name="waiting_shed" id="edit_waiting_shed" required>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="edit_xerox" class="form-label">Xerox</label>
                            <select class="form-select" name="xerox" id="edit_xerox" required>
                                <option value="Complied">Complied</option>
                                <option value="Not Complied">Not Complied</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_insp_remark" class="form-label">Inspection Remarks</label>
                        <textarea class="form-control" name="insp_remark" id="edit_insp_remark" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update Record</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Inspection Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-6">
                        <label for="view_insp_id" class="form-label">Inspection ID</label>
                        <input class="form-control" id="view_insp_id" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_insp_date" class="form-label">Inspection Date</label>
                        <input type="date" class="form-control" id="view_insp_date" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="view_terminal" class="form-label">Terminal</label>
                        <input class="form-control" id="view_terminal_id" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_officer_list" class="form-label">Officer List</label>
                        <input class="form-control" id="view_officer_list" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="view_billboard" class="form-label">Billboard</label>
                        <input class="form-control" id="view_billboard" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_comfort_room" class="form-label">Comfort Room</label>
                        <input class="form-control" id="view_comfort_room" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="view_tenm_away" class="form-label">Ten Meters Away</label>
                        <input class="form-control" id="view_tenm_away" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_lot_area" class="form-label">Lot Area</label>
                        <input class="form-control" id="view_lot_area" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="view_waiting_shed" class="form-label">Waiting Shed</label>
                        <input class="form-control" id="view_waiting_shed" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_xerox" class="form-label">Xerox</label>
                        <input class="form-control" id="view_xerox" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="view_insp_remark" class="form-label">Inspection Remarks</label>
                    <textarea class="form-control" id="view_insp_remark" rows="3" readonly></textarea>
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
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Deletion</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this record?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>    
    function showModal(type, inspData) {
        console.log(inspData);
        document.getElementById(`${type}_insp_id`).value = inspData.insp_id;
        document.getElementById(`${type}_terminal_id`).value = inspData.terminal_id;
        document.getElementById(`${type}_insp_date`).value = inspData.insp_date;
        document.getElementById(`${type}_officer_list`).value = inspData.officer_list
        document.getElementById(`${type}_billboard`).value = inspData.billboard
        document.getElementById(`${type}_comfort_room`).value = inspData.comfort_room
        document.getElementById(`${type}_tenm_away`).value = inspData.tenm_away
        document.getElementById(`${type}_lot_area`).value = inspData.lot_area
        document.getElementById(`${type}_waiting_shed`).value = inspData.waiting_shed
        document.getElementById(`${type}_xerox`).value = inspData.xerox
        document.getElementById(`${type}_insp_remark`).value = inspData.insp_remark;

        if (type === 'view') {
            document.getElementById(`${type}_terminal_id`).value = inspData.terminal_name;
        }
        if (type === 'edit') {
            document.getElementById(`${type}_id`).value = inspData.id;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');

        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-info') || event.target.classList.contains('btn-warning')) {
                var inspData = JSON.parse(event.target.getAttribute('data-insp'));
                var type = event.target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, inspData);
            } else if (event.target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function(event) {
            var id = confirmDeleteButton.getAttribute('data-id');
            window.location.href = 'trms.php?page=insptrans&action=delete&id=' + id;
        });
    });
</script>