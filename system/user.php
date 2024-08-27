<?php
if (!hasPermission(5)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br>
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">User Role</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            User Roles <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(23) ? 'block' : 'none'; ?>">Add New</button>
        </div>
        <br />
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Users Role</th>
                        <th>Picture</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = '
                    SELECT users.*, roles.role_id, roles.role_name
                    FROM users
                    LEFT JOIN roles ON users.role = roles.role_id
                    ';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_assoc($result)) {
                        $userData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['role_name']) . '</td>';
                        echo '<td>';
                        if (!empty($row['picture'])) {
                            $picture_path = htmlspecialchars($row['picture']);
                            if (file_exists($picture_path)) {
                                echo '<img src="' . $picture_path . '" width="50" height="50" alt="User Image" style="object-fit:cover">';
                            } else {
                                echo '<img src="uploads/placeholder.png" width="50" height="50" alt="Placeholder Image" style="object-fit:cover">';
                            }
                        } else {
                            echo '<img src="uploads/placeholder.png" width="50" height="50" alt="Placeholder Image">';
                        }
                        echo '</td>';
                        echo '<td>';
                        if (hasPermission(24)) {
                            echo '<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#editModal" data-user="' . $userData . '"> EDIT </button>';
                        } 
                        if (hasPermission(25)) {
                            echo '<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="' . htmlspecialchars($row['userid']) . '">DELETE</button>';
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="trms.php?page=usertrans&action=add" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" name="name" required>
                        </div>
                        <div class="col-6">
                            <label for="username" class="form-label">Username</label>
                            <input class="form-control" name="username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input class="form-control" name="email" required>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-6">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="role" class="form-label">User Role</label>
                            <select class="form-select" name="role" required>
                                <option value="" selected>Select Role</option>
                                <?php
                                $role_query = 'SELECT * FROM roles';
                                $role_result = mysqli_query($conn, $role_query) or die(mysqli_error($conn));
                                while ($role_row = mysqli_fetch_assoc($role_result)) {
                                    echo "<option value='" . htmlspecialchars($role_row['role_id']) . "'>" . ucfirst(htmlspecialchars($role_row['role_name'])) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="role" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" name="picture" accept="image/png, image/jpeg">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Save Record</button>
                        <button type="reset" class="btn btn-outline-warning ml-2">Clear Entry</button>
                        <button type="button" class="btn btn-outline-danger ml-2" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="trms.php?page=usertrans&action=edit" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <img id="edit_profile_picture_preview" src="uploads/placeholder.png" class="img-fluid img-thumbnail" alt="Profile Picture" width="150" height="150">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('edit_profile_picture').click();">Edit Picture</button>
                            <input type="file" class="d-none" id="edit_profile_picture" name="picture" accept="image/png, image/jpeg" onchange="previewProfilePicture(event, 'edit_profile_picture_preview')">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="edit_name" class="form-label">Name</label>
                                    <input class="form-control" id="edit_name" name="name" required>
                                </div>
                                <div class="col-6">
                                    <label for="edit_username" class="form-label">Username</label>
                                    <input class="form-control" id="edit_username" name="username" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="edit_email" class="form-label">Email Address</label>
                                <input class="form-control" id="edit_email" name="email" required>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="edit_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="edit_password" name="password">
                                </div>
                                <div class="col-6">
                                    <label for="edit_confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="edit_role" class="form-label">User Role</label>
                                <select class="form-select" id="edit_role" name="role" required>
                                    <option value="" selected>Select Role</option>
                                    <?php
                                    $role_query = 'SELECT * FROM roles';
                                    $role_result = mysqli_query($conn, $role_query) or die(mysqli_error($conn));
                                    while ($role_row = mysqli_fetch_assoc($role_result)) {
                                        echo "<option value='" . htmlspecialchars($role_row['role_id']) . "'>" . ucfirst(htmlspecialchars($role_row['role_name'])) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                                <button type="button" class="btn btn-outline-danger ml-2" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                <h4 class="modal-title">Delete User Account</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user account?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function previewProfilePicture(event, previewId) {
        var output = document.getElementById(previewId);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
    }

    function showModal(userData) {
        console.log(userData)
        document.getElementById('edit_user_id').value = userData.userid;
        document.getElementById('edit_name').value = userData.name;
        document.getElementById('edit_username').value = userData.username;
        document.getElementById('edit_email').value = userData.email;
        document.getElementById('edit_role').value = userData.role_id;
        const profilePicturePreview = document.getElementById('edit_profile_picture_preview');
        profilePicturePreview.src = userData.picture ? `${userData.picture}` : 'uploads/placeholder.png';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');
        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-info')) {
                var userData = JSON.parse(event.target.getAttribute('data-user'));
                showModal(userData);
            } else if (event.target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function() {
            var id = event.target.getAttribute('data-id');
            window.location.href = 'trms.php?page=usertrans&action=delete&id=' + id;
        });
    });
</script>