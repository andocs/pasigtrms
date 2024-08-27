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
        <li class="breadcrumb-item active">Transport Route</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Route Records
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(15) ? 'block' : 'none'; ?>">Add New</button>
        </div>
        <br> </br>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Route ID</th>
                        <th>Route Line</th>
                        <th>Route Struct</th>
                        <th>Route Modify</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT * FROM route';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_assoc($result)) {
                        $routeData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . $row['route_id'] . '</td>';
                        echo '<td>' . $row['route_line'] . '</td>';
                        echo '<td>' . $row['route_struct'] . '</td>';
                        echo '<td>' . $row['route_modify'] . '</td>';
                        echo '<td>';
                        if (hasPermission(3)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-route="' . $routeData . '">VIEW</button>';
                        } 
                        if (hasPermission(16)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-route="' . $routeData . '">EDIT</button>';
                        }
                        if (hasPermission(17)) {
                            echo '<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="' . htmlspecialchars($row['id']) . '">DELETE</button>';
                        }                           
                        echo '</td>';
                        echo '</tr> ';
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
            <form role="form" method="post" action="trms.php?page=routetrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Route</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row justify-content-between">
                        <?php
                        // Fetch the current year
                        $current_year = date('Y');

                        // Fetch the highest current ID for the current year
                        $query = "
                            SELECT MAX(CAST(SUBSTRING(route_id, LENGTH('R$current_year-') + 1) AS UNSIGNED)) AS max_id
                            FROM route
                            WHERE route_id LIKE 'R$current_year-%'
                        ";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);

                        // Increment the max ID by 1
                        $next_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
                        $next_id_padded = str_pad($next_id, 5, '0', STR_PAD_LEFT); // Format the number with leading zeros
                        $prefixed_id = "R$current_year-$next_id_padded"; // Combine year and number
                        ?>
                        <div class="col-6">
                            <label for="route_id" class="form-label">Route ID</label>
                            <input class="form-control" name="route_id" value="<?php echo htmlspecialchars($prefixed_id); ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label for="route_line" class="form-label">Route Line</label>
                            <input class="form-control" name="route_line" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="route_struct" class="form-label">Route Structure</label>
                        <input class="form-control" name="route_struct" required>
                    </div>
                    <div class="form-group">
                        <label for="route_modify" class="form-label">Route Modify</label>
                        <input class="form-control" name="route_modify">
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
            <form role="form" method="post" action="trms.php?page=routetrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Modal</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row justify-content-between">
                        <input class="form-control" name="id" id="edit_id" hidden>
                        <div class="col-6">
                            <label for="edit_route_id" class="form-label">Route ID</label>
                            <input class="form-control" name="route_id" id="edit_route_id" readonly>
                        </div>
                        <div class="col-6">
                            <label for="edit_route_line" class="form-label">Route Line</label>
                            <input class="form-control" name="route_line" id="edit_route_line" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_route_struct" class="form-label">Route Structure</label>
                        <input class="form-control" name="route_struct" id="edit_route_struct" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_route_modify" class="form-label">Route Modify</label>
                        <input class="form-control" name="route_modify" id="edit_route_modify">
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
            <form role="form" method="post" action="trms.php?page=routetrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Modal</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <label for="view_route_id" class="form-label">Route ID</label>
                            <input class="form-control" name="route_id" id="view_route_id" readonly>
                        </div>
                        <div class="col-6">
                            <label for="view_route_line" class="form-label">Route Line</label>
                            <input class="form-control" name="route_line" id="view_route_line" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view_route_struct" class="form-label">Route Structure</label>
                        <input class="form-control" name="route_struct" id="view_route_struct" readonly>
                    </div>
                    <div class="form-group">
                        <label for="view_route_modify" class="form-label">Route Modify</label>
                        <input class="form-control" name="route_modify" id="view_route_modify" readonly>
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Route</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this route?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(type, routeData) {
        if (type === 'edit' || type === 'view') {
            document.getElementById(`${type}_route_id`).value = routeData.route_id;
            document.getElementById(`${type}_route_line`).value = routeData.route_line;
            document.getElementById(`${type}_route_struct`).value = routeData.route_struct;
            document.getElementById(`${type}_route_modify`).value = routeData.route_modify;
        }

        if (document.getElementById(`${type}_id`)) {
            document.getElementById(`${type}_id`).value = routeData.id;
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');
        dataTable.addEventListener('click', function(event) {
            var target = event.target;
            if (target.classList.contains('btn-info') || target.classList.contains('btn-warning')) {
                var routeData = JSON.parse(target.getAttribute('data-route'));
                var type = target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, routeData);
            } else if (target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });
        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function() {
            var id = event.target.getAttribute('data-id');
            window.location.href = 'trms.php?page=routetrans&action=delete&id=' + id;
        });
    });
</script>