<?php
if(!hasPermission(2)){
    redirectTo('warning','You do not have access!','trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">PUV Driver</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Driver Records
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(11) ? 'block' : 'none'; ?>">Add New</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Driver ID</th>
                        <th>Driver Name</th>
                        <th>Driver Address</th>
                        <th>Driver Contact</th>
                        <th>Residency ID</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT driver.*, 
                    residency.id AS resi_id,
                    residency.resi_code 
                    FROM driver 
                    JOIN residency ON driver.resi_id = residency.id';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                    while ($row = mysqli_fetch_assoc($result)) {
                        $driverData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['driver_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['driver_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['driver_address']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['driver_contact']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['resi_code']) . '</td>';
                        echo '<td>';
                        if (hasPermission(2)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-driver="' . $driverData . '">VIEW</button>';
                        } 
                        if (hasPermission(12)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-driver="' . $driverData . '">EDIT</button>';
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
    <div class="modal-dialog modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" action="trms.php?page=drivertrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Driver</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row justify-content-between">
                        <?php
                        // Fetch the current year
                        $current_year = date('Y');

                        // Fetch the highest current ID for the current year
                        $query = "
                            SELECT MAX(CAST(SUBSTRING(driver_id, LENGTH('DRV-$current_year-') + 1) AS UNSIGNED)) AS max_id
                            FROM driver
                            WHERE driver_id LIKE 'DRV-$current_year-%'
                        ";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);

                        // Increment the max ID by 1
                        $next_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
                        $next_id_padded = str_pad($next_id, 4, '0', STR_PAD_LEFT); // Format the number with leading zeros
                        $prefixed_id = "DRV-$current_year-$next_id_padded"; // Combine year and number
                        ?>
                        <div class="col-6">
                            <label for="driver_id" class="form-label">Driver ID</label>
                            <input class="form-control" name="driver_id" value="<?php echo htmlspecialchars($prefixed_id); ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label for="resi_id" class="form-label">Residency</label>
                            <select class="form-select" name="resi_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch residency options
                                $resi_query = 'SELECT * FROM residency';
                                $resi_result = mysqli_query($conn, $resi_query) or die(mysqli_error($conn));
                                while ($resi_row = mysqli_fetch_assoc($resi_result)) {
                                    echo "<option value='" . htmlspecialchars($resi_row['id']) . "'>" . htmlspecialchars($resi_row['resi_code']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="driver_name" class="form-label">Driver Name</label>
                        <input class="form-control" name="driver_name" required>
                    </div>
                    <div class="form-group">
                        <label for="driver_contact" class="form-label">Driver Contact</label>
                        <input class="form-control" name="driver_contact" required>
                    </div>
                    <div class="form-group">
                        <label for="driver_address" class="form-label">Driver Address</label>
                        <input class="form-control" name="driver_address" required>
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
            <form role="form" method="post" action="trms.php?page=drivertrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Driver</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row justify-content-between">
                        <input class="form-control" name="id" id="edit_id" hidden>
                        <div class="col-6">
                            <label for="edit_driver_id" class="form-label">Driver ID</label>
                            <input class="form-control" name="driver_id" id="edit_driver_id" readonly>
                        </div>
                        <div class="col-6">
                            <label for="edit_resi_id" class="form-label">Residency</label>
                            <select class="form-select" name="resi_id" id="edit_resi_id" required>
                                <?php
                                // Fetch residency options
                                $resi_query = 'SELECT * FROM residency';
                                $resi_result = mysqli_query($conn, $resi_query) or die(mysqli_error($conn));
                                while ($resi_row = mysqli_fetch_assoc($resi_result)) {
                                    echo "<option value='" . htmlspecialchars($resi_row['id']) . "'>" . htmlspecialchars($resi_row['resi_code']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_driver_name" class="form-label">Driver Name</label>
                        <input class="form-control" name="driver_name" id="edit_driver_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_driver_contact" class="form-label">Driver Contact</label>
                        <input class="form-control" name="driver_contact" id="edit_driver_contact" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_driver_address" class="form-label">Driver Address</label>
                        <input class="form-control" name="driver_address" id="edit_driver_address" required>
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
    <div class="modal-dialog modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Driver</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group row justify-content-between">
                    <div class="col-6">
                        <label for="view_driver_id" class="form-label">Driver ID</label>
                        <input class="form-control" name="driver_id" id="view_driver_id" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_resi_code" class="form-label">Residency</label>
                        <input class="form-control" name="resi_code" id="view_resi_code" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="view_driver_name" class="form-label">Driver Name</label>
                    <input class="form-control" name="driver_name" id="view_driver_name" readonly>
                </div>
                <div class="form-group">
                    <label for="view_driver_contact" class="form-label">Driver Contact</label>
                    <input class="form-control" name="driver_contact" id="view_driver_contact" readonly>
                </div>
                <div class="form-group">
                    <label for="view_driver_address" class="form-label">Driver Address</label>
                    <input class="form-control" name="driver_address" id="view_driver_address" readonly>
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
                <h4 class="modal-title">Delete Driver</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this driver?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(type, driverData) {
        console.log(driverData)
        document.getElementById(`${type}_driver_id`).value = driverData.driver_id;
        document.getElementById(`${type}_driver_name`).value = driverData.driver_name;
        document.getElementById(`${type}_driver_address`).value = driverData.driver_address;
        document.getElementById(`${type}_driver_contact`).value = driverData.driver_contact;
        if (document.getElementById(`${type}_id`)) {
            document.getElementById(`${type}_id`).value = driverData.id;
        }
        if (document.getElementById(`${type}_resi_id`)) {
            document.getElementById(`${type}_resi_id`).value = driverData?.resi_id;
        }
        if (document.getElementById(`${type}_resi_code`)) {
            document.getElementById(`${type}_resi_code`).value = driverData?.resi_code;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');
        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-info') || event.target.classList.contains('btn-warning')) {
                var driverData = JSON.parse(event.target.getAttribute('data-driver'));
                var type = event.target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, driverData);
            } else if (event.target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function() {
            var id = event.target.getAttribute('data-id');
            window.location.href = 'trms.php?page=drivertrans&action=delete&id=' + id;
        });
    });
</script>