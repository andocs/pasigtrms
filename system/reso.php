<?php
if (!hasPermission(43)) { // Change the permission ID as necessary
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Resolution Records</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Resolution Records
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(56) ? 'block' : 'none'; ?>">Add New</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Resolution ID</th>
                        <th>Inspection ID</th>
                        <th>Resolution Name</th>
                        <th>Verification Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT term_approval.*, 
                    insp_clearance.id AS insp_id, 
                    insp_clearance.insp_id AS insp_code 
                    FROM term_approval 
                    JOIN insp_clearance ON term_approval.insp_id = insp_clearance.id';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                    while ($row = mysqli_fetch_assoc($result)) {
                        $resoData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['reso_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['insp_code']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['reso_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['veri_clear']) . '</td>';
                        echo '<td>';
                        if (hasPermission(43)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-reso="' . $resoData . '">VIEW</button>';
                        }
                        if (hasPermission(57)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-reso="' . $resoData . '">EDIT</button>';
                        }
                        if (hasPermission(58)) {
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
            <form role="form" method="post" action="trms.php?page=resotrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Resolution</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                    <?php
                        // Fetch the current year
                        $current_year = date('Y');

                        // Fetch the highest current ID for the current year
                        $query = "
                            SELECT MAX(CAST(SUBSTRING(reso_id, LENGTH('TERM-$current_year-') + 1) AS UNSIGNED)) AS max_id
                            FROM term_approval
                            WHERE reso_id LIKE 'TERM-$current_year-%'
                        ";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);

                        // Increment the max ID by 1
                        $next_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
                        $next_id_padded = str_pad($next_id, 3, '0', STR_PAD_LEFT); // Format the number with leading zeros
                        $prefixed_id = "TERM-$current_year-$next_id_padded"; // Combine year and number
                        ?>
                        
                        <div class="col-6">
                            <label for="reso_id" class="form-label">Resolution ID</label>
                            <input class="form-control" name="reso_id" value="<?php echo htmlspecialchars($prefixed_id); ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label for="insp_id" class="form-label">Inspection ID</label>
                            <select class="form-select" name="insp_id" required>
                                <option value="" selected>Select</option>
                                <?php
                                // Fetch inspection options
                                $insp_query = 'SELECT * FROM insp_clearance';
                                $insp_result = mysqli_query($conn, $insp_query) or die(mysqli_error($conn));
                                while ($insp_row = mysqli_fetch_assoc($insp_result)) {
                                    echo "<option value='" . htmlspecialchars($insp_row['id']) . "'>" . htmlspecialchars($insp_row['insp_id']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reso_name" class="form-label">Resolution Name</label>
                        <input class="form-control" name="reso_name" required>
                    </div>
                    <div class="form-group">
                        <label for="veri_clear" class="form-label">Verification Status</label>
                        <select class="form-select" name="veri_clear" required>
                            <option value="" selected>Select</option>
                            <option value="Ok">Ok</option>
                            <option value="Not">Not</option>
                        </select>
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
        <div class="modal-content">
            <form role="form" method="post" action="trms.php?page=resotrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Resolution</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <input class="form-control" name="id" id="edit_id" hidden>
                        <div class="col-6">
                            <label for="edit_reso_id" class="form-label">Resolution ID</label>
                            <input class="form-control" name="reso_id" id="edit_reso_id" readonly>
                        </div>
                        <div class="col-6">
                            <label for="edit_insp_id" class="form-label">Inspection ID</label>
                            <select class="form-select" name="insp_id" id="edit_insp_id" required>
                                <?php
                                // Fetch inspection options
                                $insp_query = 'SELECT * FROM insp_clearance';
                                $insp_result = mysqli_query($conn, $insp_query) or die(mysqli_error($conn));
                                while ($insp_row = mysqli_fetch_assoc($insp_result)) {
                                    echo "<option value='" . htmlspecialchars($insp_row['id']) . "'>" . htmlspecialchars($insp_row['insp_id']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_reso_name" class="form-label">Resolution Name</label>
                        <input class="form-control" name="reso_name" id="edit_reso_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_veri_clear" class="form-label">Verification Status</label>
                        <select class="form-select" name="veri_clear" id="edit_veri_clear" required>
                            <option value="Ok">Ok</option>
                            <option value="Not">Not</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Save Changes</button>
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
                <h4 class="modal-title">View Resolution</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-6">
                        <label for="view_reso_id" class="form-label">Resolution ID</label>
                        <input class="form-control" name="reso_id" id="view_reso_id" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_insp_id" class="form-label">Inspection ID</label>
                        <input type="text" class="form-control" id="view_insp_id" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="view_reso_name" class="form-label">Resolution Name</label>
                    <input class="form-control" name="reso_name" id="view_reso_name" readonly>
                </div>
                <div class="form-group">
                    <label for="view_veri_clear" class="form-label">Verification Status</label>
                    <input class="form-control" name="reso_name" id="view_veri_clear" readonly>
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
    function showModal(type, resoData) {
        console.log(resoData)
        document.getElementById(`${type}_reso_id`).value = resoData.reso_id;
        document.getElementById(`${type}_insp_id`).value = resoData.insp_id;
        document.getElementById(`${type}_reso_name`).value = resoData.reso_name;
        document.getElementById(`${type}_veri_clear`).value = resoData.veri_clear;

        if (document.getElementById(`${type}_id`)) {
            document.getElementById(`${type}_id`).value = resoData.id;
        }

        if (type == 'view') {
            document.getElementById(`${type}_insp_id`).value = resoData.insp_code;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');

        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-info') || event.target.classList.contains('btn-warning')) {
                var resoData = JSON.parse(event.target.getAttribute('data-reso'));
                var type = event.target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, resoData);
            } else if (event.target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function() {
            var id = event.target.getAttribute('data-id');
            window.location.href = 'trms.php?page=resotrans&action=delete&id=' + id;
        });
    });
</script>