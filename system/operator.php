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
        <li class="breadcrumb-item active">PUV Operator List</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Operator Record
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(11) ? 'block' : 'none'; ?>">Add New</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Operator ID</th>
                        <th>Residency</th>
                        <th>Operator Name</th>
                        <th>Operator Address</th>
                        <th>Operator Contact</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT operator.*, 
                    residency.id as resi_id,
                    residency.resi_code 
                    FROM operator 
                    JOIN residency ON operator.resi_id = residency.id';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_assoc($result)) {
                        $operatorData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . $row['optr_id'] . '</td>';
                        echo '<td>' . $row['resi_code'] . '</td>';
                        echo '<td>' . $row['optr_name'] . '</td>';
                        echo '<td>' . $row['optr_add'] . '</td>';
                        echo '<td>' . $row['optr_contact'] . '</td>';
                        echo '<td>';
                        if (hasPermission(2)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-operator="' . $operatorData . '">VIEW</button>';
                        } 
                        if (hasPermission(12)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-operator="' . $operatorData . '">EDIT</button>';
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
            <form role="form" method="post" action="trms.php?page=operatortrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Operator</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row justify-content-between">
                        <?php
                        // Fetch the current year
                        $current_year = date('Y');

                        // Fetch the highest current ID for the current year
                        $query = "
                            SELECT MAX(CAST(SUBSTRING(optr_id, LENGTH('OPR$current_year-') + 1) AS UNSIGNED)) AS max_id
                            FROM operator
                            WHERE optr_id LIKE 'OPR$current_year-%'
                        ";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);

                        // Increment the max ID by 1
                        $next_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
                        $next_id_padded = str_pad($next_id, 4, '0', STR_PAD_LEFT); // Format the number with leading zeros
                        $prefixed_id = "OPR$current_year-$next_id_padded"; // Combine year and number
                        ?>

                        <div class="col-6">
                            <label for="optr_id" class="form-label">Operator ID</label>
                            <input class="form-control" name="optr_id" value="<?php echo htmlspecialchars($prefixed_id); ?>" readonly>
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
                        <label for="optr_name" class="form-label">Operator Name</label>
                        <input class="form-control" name="optr_name" required>
                    </div>
                    <div class="form-group">
                        <label for="optr_contact" class="form-label">Operator Contact</label>
                        <input class="form-control" name="optr_contact" required>
                    </div>
                    <div class="form-group">
                        <label for="optr_add" class="form-label">Operator Address</label>
                        <input class="form-control" name="optr_add" required>
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
            <form role="form" method="post" action="trms.php?page=operatortrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Operator</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row justify-content-between">
                        <input class="form-control" name="id" id="edit_id" hidden>
                        <div class="col-6">
                            <label for="edit_optr_id" class="form-label">Operator ID</label>
                            <input class="form-control" name="optr_id" id="edit_optr_id" readonly>
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
                        <label for="edit_optr_name" class="form-label">Operator Name</label>
                        <input class="form-control" name="optr_name" id="edit_optr_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_optr_contact" class="form-label">Operator Contact</label>
                        <input class="form-control" name="optr_contact" id="edit_optr_contact" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_optr_add" class="form-label">Operator Address</label>
                        <input class="form-control" name="optr_add" id="edit_optr_add" required>
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
                <h4 class="modal-title">View Operator</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group row justify-content-between">
                    <div class="col-6">
                        <label for="view_optr_id" class="form-label">Operator ID</label>
                        <input class="form-control" name="optr_id" id="view_optr_id" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_resi_code" class="form-label">Residency</label>
                        <input class="form-control" name="resi_code" id="view_resi_code" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="view_optr_name" class="form-label">Operator Name</label>
                    <input class="form-control" name="optr_name" id="view_optr_name" readonly>
                </div>
                <div class="form-group">
                    <label for="view_optr_contact" class="form-label">Operator Contact</label>
                    <input class="form-control" name="optr_contact" id="view_optr_contact" readonly>
                </div>
                <div class="form-group">
                    <label for="view_optr_add" class="form-label">Operator Address</label>
                    <input class="form-control" name="optr_add" id="view_optr_add" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Deletion</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(type, operatorData) {
        console.log(operatorData)
        document.getElementById(`${type}_optr_id`).value = operatorData.optr_id;
        if (document.getElementById(`${type}_id`)) {
            document.getElementById(`${type}_id`).value = operatorData.id;
        }
        if (document.getElementById(`${type}_resi_id`)) {
            document.getElementById(`${type}_resi_id`).value = operatorData?.resi_id;
        }
        if (document.getElementById(`${type}_resi_code`)) {
            document.getElementById(`${type}_resi_code`).value = operatorData?.resi_code;
        }
        document.getElementById(`${type}_optr_name`).value = operatorData.optr_name;
        document.getElementById(`${type}_optr_contact`).value = operatorData.optr_contact;
        document.getElementById(`${type}_optr_add`).value = operatorData.optr_add;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');
        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-info') || event.target.classList.contains('btn-warning')) {
                var operatorData = JSON.parse(event.target.getAttribute('data-operator'));
                var type = event.target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, operatorData);
            } else if (event.target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function() {
            var id = event.target.getAttribute('data-id');
            window.location.href = 'trms.php?page=operatortrans&action=delete&id=' + id;
        });
    });
</script>