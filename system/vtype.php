<?php
if (!hasPermission(41)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Vehicle Types</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Vehicle Types
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(48) ? 'block' : 'none'; ?>">Add New</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Modal</th>
                        <th>Modal Name</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT * FROM unit_type';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                    while ($row = mysqli_fetch_assoc($result)) {
                        $vtypeData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['modal']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['modal_name']) . '</td>';
                        echo '<td>';
                        if (hasPermission(41)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-vtype="' . $vtypeData . '">VIEW</button>';
                        }
                        if (hasPermission(49)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-vtype="' . $vtypeData . '">EDIT</button>';
                        }
                        if (hasPermission(50)) {
                            echo '<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="' . htmlspecialchars($row['vtype_id']) . '">DELETE</button>';
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
            <form role="form" method="post" action="trms.php?page=vtypetrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Vehicle Type</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modal" class="form-label">Modal</label>
                        <input type="text" class="form-control" name="modal" required>
                    </div>
                    <div class="form-group">
                        <label for="modal_name" class="form-label">Modal Name</label>
                        <input type="text" class="form-control" name="modal_name" required>
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
            <form role="form" method="post" action="trms.php?page=vtypetrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Vehicle Type</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="edit_id">
                        <label for="edit_modal" class="form-label">Modal</label>
                        <input type="text" class="form-control" name="modal" id="edit_modal" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_modal_name" class="form-label">Modal Name</label>
                        <input type="text" class="form-control" name="modal_name" id="edit_modal_name" required>
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
                <h4 class="modal-title">View Vehicle Type</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="view_modal" class="form-label">Modal</label>
                    <input type="text" class="form-control" id="view_modal" readonly>
                </div>
                <div class="form-group">
                    <label for="view_modal_name" class="form-label">Modal Name</label>
                    <input type="text" class="form-control" id="view_modal_name" readonly>
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
                <h4 class="modal-title">Delete Vehicle Type</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="id" id="delete_id">
                    <p>Are you sure you want to delete this vehicle type?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(type, vtypeData) {
        console.log(vtypeData)
        if (type === 'edit') {
            document.getElementById(`${type}_id`).value = vtypeData.vtype_id;
        }
        document.getElementById(`${type}_modal`).value = vtypeData.modal;
        document.getElementById(`${type}_modal_name`).value = vtypeData.modal_name;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');

        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-info') || event.target.classList.contains('btn-warning')) {
                var vtypeData = JSON.parse(event.target.getAttribute('data-vtype'));
                var type = event.target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, vtypeData);
            } else if (event.target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function() {
            var id = event.target.getAttribute('data-id');
            window.location.href = 'trms.php?page=vtypetrans&action=delete&id=' + id;
        });
    });
</script>