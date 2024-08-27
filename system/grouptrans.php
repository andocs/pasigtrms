<?php
$userid = $_SESSION['userid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $groupId = $_POST['group_id'] ?? '';
    $groupName = $_POST['group_name'] ?? '';
    $officerNames = $_POST['officers'] ?? [];
    $officerPositions = $_POST['positions'] ?? [];

    // Check for empty fields
    if (empty($groupId) || empty($groupName)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Check for duplicate group ID using a prepared statement
                $query = $conn->prepare("SELECT * FROM trans_group WHERE group_id = ?");
                $query->bind_param('s', $groupId);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Group ID already exists.</div>";
                } else {
                    // Insert new group using a prepared statement
                    $insertQuery = $conn->prepare("INSERT INTO trans_group (group_id, group_name) VALUES (?, ?)");
                    $insertQuery->bind_param('ss', $groupId, $groupName);
                    if ($insertQuery->execute()) {
                        $newGroupId = $conn->insert_id; // Get the id of the newly inserted group

                        // Insert officers into group_officers table
                        for ($i = 0; $i < count($officerNames); $i++) {
                            $officerName = $officerNames[$i] ?? '';
                            $officerPosition = $officerPositions[$i] ?? '';

                            if (!empty($officerPosition) && !empty($officerName)) {
                                $officerQuery = $conn->prepare("INSERT INTO group_officers (group_id, officer_position, officer_name) VALUES (?, ?, ?)");
                                $officerQuery->bind_param('iss', $newGroupId, $officerPosition, $officerName);
                                $officerQuery->execute();
                                $officerQuery->close();
                            }
                        }

                        // Add audit log
                        log_add($userid, 'trans_group', [
                            'group_id' => $groupId,
                            'group_name' => $groupName
                        ], $conn);

                        // Add officers to audit log
                        foreach ($officerNames as $index => $officerName) {
                            $officerPosition = $officerPositions[$index] ?? '';
                            log_add($userid, 'group_officers', [
                                'group_id' => $newGroupId,
                                'officer_position' => $officerPosition,
                                'officer_name' => $officerName
                            ], $conn);
                        }

                        redirectTo('success', 'Successfully added.', 'trms.php?page=group');
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
                $oldQuery = $conn->prepare("SELECT * FROM trans_group WHERE id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update group using a prepared statement
                $query = $conn->prepare("UPDATE trans_group SET group_name = ? WHERE id = ?");
                $query->bind_param('si', $groupName, $rowId);
                if ($query->execute()) {
                    // Delete existing officers for the group
                    $deleteOfficerQuery = $conn->prepare("DELETE FROM group_officers WHERE group_id = ?");
                    $deleteOfficerQuery->bind_param('i', $rowId);
                    $deleteOfficerQuery->execute();
                    $deleteOfficerQuery->close();

                    // Insert new officers into group_officers table
                    for ($i = 0; $i < count($officerNames); $i++) {
                        $officerName = $officerNames[$i] ?? '';
                        $officerPosition = $officerPositions[$i] ?? '';

                        if (!empty($officerPosition) && !empty($officerName)) {
                            $officerQuery = $conn->prepare("INSERT INTO group_officers (group_id, officer_position, officer_name) VALUES (?, ?, ?)");
                            $officerQuery->bind_param('iss', $rowId, $officerPosition, $officerName);
                            $officerQuery->execute();
                            $officerQuery->close();
                        }
                    }

                    // Add audit log
                    log_edit($userid, 'trans_group', $oldData, [
                        'group_id' => $groupId,
                        'group_name' => $groupName
                    ], $conn);

                    // Add officers to audit log
                    foreach ($officerNames as $index => $officerName) {
                        $officerPosition = $officerPositions[$index] ?? '';
                        log_add($userid, 'group_officers', [
                            'group_id' => $rowId,
                            'officer_position' => $officerPosition,
                            'officer_name' => $officerName
                        ], $conn);
                    }

                    redirectTo('success', 'Successfully edited.', 'trms.php?page=group');
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
                }
                $query->close();
                break;

            default:
                echo "<div class='alert alert-danger'>Invalid action.</div>";
                break;
        }
    } else {
        echo "<div class='alert alert-danger'>No action set.</div>";
    }
} else {
    if (isset($_GET['action']) && $_GET['action'] == "delete") {
        $groupId = $_GET['id'] ?? '';
        if (!empty($groupId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM trans_group WHERE id = ?");
            $oldQuery->bind_param('i', $groupId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Ensure deletion of group officers first
            $deleteOfficerQuery = $conn->prepare("DELETE FROM group_officers WHERE group_id = ?");
            $deleteOfficerQuery->bind_param('i', $groupId);
            $deleteOfficerQuery->execute();
            $deleteOfficerQuery->close();

            // Now delete the group
            $query = $conn->prepare('DELETE FROM trans_group WHERE id = ?');
            $query->bind_param('i', $groupId);
            // Execute the statement
            if ($query->execute()) {
                // Add audit log
                log_delete($userid, 'trans_group', $oldData, $conn);

                redirectTo('success', 'Successfully deleted.', 'trms.php?page=group');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
            }
            $query->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No group ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request.</div>";
    }
}
?>
