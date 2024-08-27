<?php
if (!hasPermission(40)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Case Records</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Case Records
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(44) ? 'block' : 'none'; ?>">Add New</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Case ID</th>
                        <th>Route</th>
                        <th>Case Number</th>
                        <th>Date Granted</th>
                        <th>Date Expired</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT cases.*, 
                    route.id AS route_id,
                    route.route_line 
                    FROM cases 
                    JOIN route ON cases.route_id = route.id';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                    while ($row = mysqli_fetch_assoc($result)) {
                        $caseData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['case_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['route_line']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['case_no']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['case_granted']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['case_expire']) . '</td>';
                        echo '<td>';
                        if (hasPermission(40)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-case="' . $caseData . '">VIEW</button>';
                        }
                        if (hasPermission(45)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-case="' . $caseData . '">EDIT</button>';
                        }
                        if (hasPermission(46)) {
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
            <form role="form" method="post" action="trms.php?page=casestrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Case</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <?php
                        // Fetch the current year
                        $current_year = date('Y');

                        // Fetch the highest current ID for the current year
                        $query = "
                            SELECT MAX(CAST(SUBSTRING(case_id, LENGTH('C$current_year-') + 1) AS UNSIGNED)) AS max_id
                            FROM cases
                            WHERE case_id LIKE 'C$current_year-%'
                        ";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);

                        // Increment the max ID by 1
                        $next_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
                        $next_id_padded = str_pad($next_id, 5, '0', STR_PAD_LEFT); // Format the number with leading zeros
                        $prefixed_id = "C$current_year-$next_id_padded"; // Combine year and number
                        ?>
                        <div class="col-6">
                            <label for="case_id" class="form-label">Case ID</label>
                            <input class="form-control" name="case_id" value="<?php echo htmlspecialchars($prefixed_id); ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label for="case_no" class="form-label">Case Number</label>
                            <input class="form-control" name="case_no" required>
                        </div>
                    </div>
                    <div class="form-group">
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
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="case_granted" class="form-label">Date Granted</label>
                            <input type="date" class="form-control" name="case_granted" required>
                        </div>
                        <div class="col-6">
                            <label for="case_expire" class="form-label">Date Expired</label>
                            <input type="date" class="form-control" name="case_expire" required>
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
        <div class="modal-content">
            <form role="form" method="post" action="trms.php?page=casestrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Case</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <input class="form-control" name="id" id="edit_id" hidden>
                        <div class="col-6">
                            <label for="edit_case_id" class="form-label">Case ID</label>
                            <input class="form-control" name="case_id" id="edit_case_id" readonly>
                        </div>
                        <div class="col-6">
                            <label for="edit_case_no" class="form-label">Case Number</label>
                            <input class="form-control" name="case_no" id="edit_case_no" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_route_id" class="form-label">Route</label>
                        <select class="form-select" name="route_id" id="edit_route_id" required>
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
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="edit_case_granted" class="form-label">Date Granted</label>
                            <input type="date" class="form-control" name="case_granted" id="edit_case_granted" required>
                        </div>
                        <div class="col-6">
                            <label for="edit_case_expire" class="form-label">Date Expired</label>
                            <input type="date" class="form-control" name="case_expire" id="edit_case_expire" required>
                        </div>
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
                <h4 class="modal-title">View Case</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-6">
                        <label for="view_case_id" class="form-label">Case ID</label>
                        <input class="form-control" id="view_case_id" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_case_no" class="form-label">Case Number</label>
                        <input class="form-control" id="view_case_no" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="view_route_id" class="form-label">Route</label>
                    <input class="form-control" id="view_route_id" readonly>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="view_case_granted" class="form-label">Date Granted</label>
                        <input class="form-control" id="view_case_granted" readonly>
                    </div>
                    <div class="col-6">
                        <label for="view_case_expire" class="form-label">Date Expired</label>
                        <input class="form-control" id="view_case_expire" readonly>
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
                <h4 class="modal-title">Delete Case</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>Are you sure you want to delete this case?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(type, caseData) {
        console.log(caseData)
        document.getElementById(`${type}_case_id`).value = caseData.case_id;
        document.getElementById(`${type}_route_id`).value = caseData.route_id;
        document.getElementById(`${type}_case_no`).value = caseData.case_no;
        document.getElementById(`${type}_case_granted`).value = caseData.case_granted;
        document.getElementById(`${type}_case_expire`).value = caseData.case_expire;

        if (document.getElementById(`${type}_id`)) {
            document.getElementById(`${type}_id`).value = caseData.id;
        }

        if (type == 'view') {
            document.getElementById(`${type}_route_id`).value = caseData.route_line;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');

        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-info') || event.target.classList.contains('btn-warning')) {
                var caseData = JSON.parse(event.target.getAttribute('data-case'));
                var type = event.target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, caseData);
            } else if (event.target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function() {
            var id = event.target.getAttribute('data-id');
            window.location.href = 'trms.php?page=casestrans&action=delete&id=' + id;
        });
    });
</script>