<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['userid'];
    // Fetch POST data
    $roleId = $_POST['role_id'] ?? '';
    $permissions = $_POST['permissions'] ?? [];

    // Check for empty fields
    if (empty($roleId)) {
        echo "<div class='alert alert-danger'>Role ID is required.</div>";
        exit;
    }

    // Fetch old permissions for auditing
    $oldPermissionsQuery = $conn->prepare("SELECT permission_id FROM role_permissions WHERE role_id = ?");
    $oldPermissionsQuery->bind_param('i', $roleId);
    $oldPermissionsQuery->execute();
    $oldPermissionsResult = $oldPermissionsQuery->get_result();
    $oldPermissions = [];
    while ($row = $oldPermissionsResult->fetch_assoc()) {
        $oldPermissions[] = $row['permission_id'];
    }
    $oldPermissionsQuery->close();

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'edit':
                // Start a transaction
                $conn->begin_transaction();

                try {
                    // Delete existing permissions
                    $deleteQuery = $conn->prepare("DELETE FROM role_permissions WHERE role_id = ?");
                    $deleteQuery->bind_param('i', $roleId);
                    $deleteQuery->execute();
                    $deleteQuery->close();

                    // Insert new permissions
                    $insertQuery = $conn->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
                    foreach ($permissions as $permissionId) {
                        $insertQuery->bind_param('ii', $roleId, $permissionId);
                        $insertQuery->execute();
                    }
                    $insertQuery->close();

                    // Commit the transaction
                    $conn->commit();

                    // Add audit log
                    log_edit($userid, 'role_permissions', $oldPermissions, $permissions, $conn);

                    redirectTo('info', 'Successfully edited.', 'trms.php?page=roleaccess');
                } catch (Exception $e) {
                    // Rollback the transaction on error
                    $conn->rollback();
                    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                }
                break;

            default:
                echo "<div class='alert alert-danger'>Invalid action specified.</div>";
                break;
        }
    } else {
        echo "<div class='alert alert-danger'>No action specified.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request method.</div>";
}
