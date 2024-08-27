<?php
if(!hasPermission(1)){
    redirectTo('warning','You do not have access!','trms.php?page=unauthorized');
}
$userid = $_SESSION['userid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch POST data
    $terminalId = $_POST['terminal_id'] ?? '';
    $terminalName = $_POST['terminal_name'] ?? '';
    $terminalAddress = $_POST['terminal_add'] ?? '';
    $routeId = $_POST['route_id'] ?? '';
    $inspectionId = $_POST['insp_id'] ?? '';
    $resoId = $_POST['reso_id'] ?? '';
    $groupId = $_POST['group_id'] ?? '';
    $businessPermit = $_POST['busi_permit'] ?? '';
    $businessRegistration = $_POST['busi_date'] ?? '';
    $businessExpiration = $_POST['busi_expire'] ?? '';

    // Check for empty fields
    if (empty($terminalId) || empty($terminalName) || empty($terminalAddress) || empty($routeId) || empty($inspectionId) || empty($resoId) || empty($groupId) || empty($businessPermit) || empty($businessRegistration) || empty($businessExpiration)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Check for duplicate terminal ID
                $query = $conn->prepare("SELECT * FROM terminal WHERE terminal_id = ?");
                $query->bind_param('s', $terminalId);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Terminal ID already exists.</div>";
                } else {
                    // Insert new terminal using a prepared statement
                    $insertQuery = $conn->prepare("INSERT INTO terminal (terminal_id, terminal_name, terminal_add, route_id, insp_id, reso_id, group_id, busi_permit, busi_date, busi_expire) 
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insertQuery->bind_param('ssssssssss', $terminalId, $terminalName, $terminalAddress, $routeId, $inspectionId, $resoId, $groupId, $businessPermit, $businessRegistration, $businessExpiration);

                    if ($insertQuery->execute()) {
                        // Add audit log
                        log_add($userid, 'terminal', [
                            'terminal_id' => $terminalId,
                            'terminal_name' => $terminalName,
                            'terminal_add' => $terminalAddress,
                            'route_id' => $routeId,
                            'insp_id' => $inspectionId,
                            'reso_id' => $resoId,
                            'group_id' => $groupId,
                            'busi_permit' => $businessPermit,
                            'busi_date' => $businessRegistration,
                            'busi_expire' => $businessExpiration
                        ], $conn);

                        redirectTo('success', 'Successfully added.', 'trms.php?page=terminal');
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $insertQuery->error . "</div>";
                    }
                    $insertQuery->close();
                }
                $query->close();
                break;

            case 'edit':
                $rowId = $_POST['id'] ?? '';

                // Fetch old data for auditing
                $oldQuery = $conn->prepare("SELECT * FROM terminal WHERE id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update terminal using a prepared statement
                $updateQuery = $conn->prepare("UPDATE terminal SET terminal_name = ?, terminal_add = ?, route_id = ?, insp_id = ?, reso_id = ?, group_id = ?, busi_permit = ?, busi_date = ?, busi_expire = ? WHERE id = ?");
                $updateQuery->bind_param('sssssssssi', $terminalName, $terminalAddress, $routeId, $inspectionId, $resoId, $groupId, $businessPermit, $businessRegistration, $businessExpiration, $rowId);

                if ($updateQuery->execute()) {
                    // Add audit log
                    log_edit($userid, 'terminal', $oldData, [
                        'terminal_id' => $terminalId,
                        'terminal_name' => $terminalName,
                        'terminal_add' => $terminalAddress,
                        'route_id' => $routeId,
                        'insp_id' => $inspectionId,
                        'reso_id' => $resoId,
                        'group_id' => $groupId,
                        'busi_permit' => $businessPermit,
                        'busi_date' => $businessRegistration,
                        'busi_expire' => $businessExpiration
                    ], $conn);

                    redirectTo('info', 'Successfully edited.', 'trms.php?page=terminal');
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $updateQuery->error . "</div>";
                }
                $updateQuery->close();
                break;

            default:
                echo "<div class='alert alert-danger'>Invalid action specified.</div>";
                break;
        }
    } else {
        echo "<div class='alert alert-danger'>No action specified.</div>";
    }
} else {
    if (isset($_GET['action']) && $_GET['action'] == "delete") {
        $terminalId = $_GET['id'] ?? '';
        if (!empty($terminalId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM terminal WHERE id = ?");
            $oldQuery->bind_param('i', $terminalId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Prepare the DELETE statement
            $deleteQuery = $conn->prepare('DELETE FROM terminal WHERE id = ?');
            $deleteQuery->bind_param('i', $terminalId);
            // Execute the statement
            if ($deleteQuery->execute()) {
                // Add audit log
                log_delete($userid, 'terminal', $oldData, $conn);

                redirectTo('success', 'Successfully Deleted.', 'trms.php?page=terminal');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $deleteQuery->error . "</div>";
            }
            $deleteQuery->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No terminal ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request method.</div>";
    }
}
