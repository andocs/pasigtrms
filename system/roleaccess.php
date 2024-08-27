<?php
if (!hasPermission(6)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}

// Fetch all permissions from the database
$permissions_query = 'SELECT * FROM permissions';
$permissions_result = mysqli_query($conn, $permissions_query) or die(mysqli_error($conn));
$module_permissions = [];
$action_permissions = [];

while ($permission_row = mysqli_fetch_assoc($permissions_result)) {
    if (in_array($permission_row['permission_name'], ['ADD', 'EDIT', 'DELETE', 'PRINT'])) {
        $action_permissions[] = $permission_row;
    } else {
        $module_permissions[] = $permission_row;
    }
}

// Convert permissions to JSON for use in JavaScript
$modulePermissions = json_encode($module_permissions);
$actionPermissions = json_encode($action_permissions);
?>

<div class="container-fluid"> <br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Access Management</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            User Access
        </div>
        <br />
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Role ID</th>
                        <th>Role Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $query = 'SELECT roles.*, 
    COALESCE(GROUP_CONCAT(role_permissions.permission_id SEPARATOR ","), "") AS permission_ids 
FROM 
    roles 
LEFT JOIN 
    role_permissions ON roles.role_id = role_permissions.role_id 
GROUP BY 
    roles.role_id;';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_assoc($result)) {
                        $roleData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . $row['role_id'] . '</td>';
                        echo '<td>' . $row['role_name'] . '</td>';
                        echo '<td>';
                        if (hasPermission(6)) {
                            echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#viewModal" data-role="' . $roleData . '">VIEW</button>';
                        }
                        if (hasPermission(28)) {
                            echo '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal" data-role="' . $roleData . '">EDIT</button>';
                        }
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Role</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#viewUserModule">Module Access</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#viewUserRights">Role Access</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="viewUserModule" class="tab-pane fade show active">
                        <!-- Container for User Module checkboxes -->
                        <div id="viewUserModulePermissions" class="p-4"></div>
                    </div>
                    <div id="viewUserRights" class="tab-pane fade">
                        <!-- Container for User Rights checkboxes -->
                        <div id="viewUserRightsPermissions" class="p-4 row"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm" method="post" action="trms.php?page=roleaccesstrans&action=edit">
                    <input type="hidden" name="role_id" id="edit_role_id">
                    <div class="form-group">
                        <label for="edit_role_name">Role Name</label>
                        <input type="text" class="form-control" id="edit_role_name" name="role_name" readonly>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#editUserModule">Module Access</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#editUserRights">Role Access</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="editUserModule" class="tab-pane fade show active">
                            <!-- Container for User Module checkboxes -->
                            <div id="editUserModulePermissions" class="p-4"></div>
                        </div>
                        <div id="editUserRights" class="tab-pane fade">
                            <!-- Container for User Rights checkboxes -->
                            <div id="editUserRightsPermissions" class="p-4 row"></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                        <button type="button" class="btn btn-outline-danger ml-2" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(type, roleData) {
        const modulePermissions = <?php echo $modulePermissions; ?>;
        const actionPermissions = <?php echo $actionPermissions; ?>;

        console.log(roleData);
        const roleName = document.getElementById(`${type}_role_name`);
        const roleId = document.getElementById(`${type}_role_id`);
        if (roleName) {
            roleName.value = roleData.role_name;
        }
        if (roleId) {
            roleId.value = roleData.role_id;
        }
        const userModuleContainer = document.getElementById(`${type}UserModulePermissions`);
        const userRightsContainer = document.getElementById(`${type}UserRightsPermissions`);

        // Clear previous checkboxes
        userModuleContainer.innerHTML = '';
        userRightsContainer.innerHTML = '';

        const modules = ['PUV Information', 'Public Transport', 'Audit Logs', 'User Accounts', 'Role Access', 'User Reports', 'Signatory', 'Case', 'Vehicle Type', 'Inspection Clearance', 'Resolution'];

        const permissionIdsArray = roleData.permission_ids.split(',').map(String);

        // User Module checkboxes
        let userModuleRow;
        modulePermissions.forEach((permission, index) => {
            if (index % 2 === 0) {
                userModuleRow = document.createElement('div');
                userModuleRow.className = 'row';
                userModuleContainer.appendChild(userModuleRow);
            }
            const checkbox = document.createElement('div');
            checkbox.className = 'col-md-6 my-2';
            checkbox.innerHTML = `
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="perm${permission.permission_id}" name="permissions[]" value="${permission.permission_id}" ${permissionIdsArray.includes(permission.permission_id) ? 'checked' : ''} ${type=='edit' ? '' : 'disabled'}>
                <label class="form-check-label" for="perm${permission.permission_id}">${permission.permission_name}</label>
            </div>
        `;
            userModuleRow.appendChild(checkbox);
        });

        // User Rights Access checkboxes
        let currentModuleIndex = -1;
        let userRightsRow;

        actionPermissions.forEach((permission, index) => {
            const moduleIndex = Math.floor(index / 4);
            if (moduleIndex !== currentModuleIndex) {
                currentModuleIndex = moduleIndex;
                const header = document.createElement('h7');
                header.innerText = modules[moduleIndex];
                userRightsContainer.appendChild(header);
            }
            if (index % 4 === 0) {
                userRightsRow = document.createElement('div');
                userRightsRow.className = 'row my-2 ml-2';
                userRightsContainer.appendChild(userRightsRow);
            }
            const checkbox = document.createElement('div');
            checkbox.className = 'col-md-3';
            checkbox.innerHTML = `
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="perm${permission.permission_id}" name="permissions[]" value="${permission.permission_id}" ${permissionIdsArray.includes(permission.permission_id) ? 'checked' : ''} ${type=='edit' ? '' : 'disabled'}>
                <label class="form-check-label" for="perm${permission.permission_id}">${permission.permission_name}</label>
            </div>
        `;
            userRightsRow.appendChild(checkbox);
        });
    }


    document.addEventListener('DOMContentLoaded', function() {
        var modalArray = document.querySelectorAll('.modal');
        modalArray.forEach((modal) => {
            const modalForm = modal.querySelector('form');
            const defaultTab = modal.querySelector('.nav-item > :first-child');
            const defaultPane = modal.querySelector('.tab-content > :first-child');
            $(modal).on('hidden.bs.modal', function(e) {
                modal.querySelectorAll('.nav-tabs .nav-item .nav-link').forEach(function(tabLink) {
                    tabLink.classList.remove('active');
                });
                modal.querySelectorAll('.tab-content .tab-pane').forEach(function(tabPane) {
                    tabPane.classList.remove('active');
                });
                defaultTab.classList.add('active');
                defaultPane.classList.add('active');
                defaultPane.classList.add('show');
            });
        });
        var dataTable = document.getElementById('dataTable');
        dataTable.addEventListener('click', function(event) {
            var target = event.target;
            if (target.classList.contains('btn-info') || target.classList.contains('btn-warning')) {
                var roleData = JSON.parse(target.getAttribute('data-role'));
                var type = target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, roleData);
            }
        });
    });
</script>