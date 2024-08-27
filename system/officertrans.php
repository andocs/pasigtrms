<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['userid'];
    $officerId = $_POST['officer_id'] ?? '';
    $officerName = $_POST['officer_name'] ?? '';
    $officerPosition = $_POST['officer_position'] ?? '';
    $officerContact = $_POST['officer_contact'] ?? '';

    // Check for empty fields
    if (empty($officerId) || empty($officerName) || empty($officerPosition) || empty($officerContact)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Check for duplicate officer ID using a prepared statement
                $query = $conn->prepare("SELECT * FROM group_officers WHERE officer_id = ?");
                $query->bind_param('s', $officerId);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Officer ID already exists.</div>";
                } else {
                    // Insert new officer using a prepared statement
                    $insertQuery = $conn->prepare("INSERT INTO group_officers (officer_id, officer_name, officer_position, officer_contact) VALUES (?, ?, ?, ?)");
                    $insertQuery->bind_param('ssss', $officerId, $officerName, $officerPosition, $officerContact);
                    if ($insertQuery->execute()) {
                        // Add audit log
                        log_add($userid, 'group_officers', [
                            'officer_id' => $officerId,
                            'officer_name' => $officerName,
                            'officer_position' => $officerPosition,
                            'officer_contact' => $officerContact
                        ], $conn);

                        redirectTo('success', 'Successfully added.', 'trms.php?page=officer');
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $insertQuery->error . "</div>";
                    }
                    $insertQuery->close();
                }
                $query->close();
                break;

            case 'edit':
                if (!empty($officerId) && !empty($officerName) && !empty($officerPosition) && !empty($officerContact)) {
                    // Fetch old data for auditing
                    $oldQuery = $conn->prepare("SELECT * FROM group_officers WHERE officer_id = ?");
                    $oldQuery->bind_param('s', $officerId);
                    $oldQuery->execute();
                    $oldData = $oldQuery->get_result()->fetch_assoc();
                    $oldQuery->close();

                    // Update officer using a prepared statement
                    $query = $conn->prepare("UPDATE group_officers SET officer_name = ?, officer_position = ?, officer_contact = ? WHERE officer_id = ?");
                    $query->bind_param('ssss', $officerName, $officerPosition, $officerContact, $officerId);
                    if ($query->execute()) {
                        // Add audit log
                        log_edit($userid, 'group_officers', $oldData, [
                            'officer_name' => $officerName,
                            'officer_position' => $officerPosition,
                            'officer_contact' => $officerContact
                        ], $conn);

                        redirectTo('success', 'Successfully edited.', 'trms.php?page=officer');
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
                    }
                    $query->close();
                } else {
                    echo "<div class='alert alert-danger'>Required form fields are missing.</div>";
                }
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
        $officerId = $_GET['id'] ?? '';
        if (!empty($officerId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM group_officers WHERE officer_id = ?");
            $oldQuery->bind_param('s', $officerId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Prepare the DELETE statement
            $query = $conn->prepare('DELETE FROM group_officers WHERE officer_id = ?');
            $query->bind_param('s', $officerId);
            // Execute the statement
            if ($query->execute()) {
                // Add audit log
                log_delete($userid, 'group_officers', $oldData, $conn);

                redirectTo('success', 'Successfully deleted.', 'trms.php?page=officer');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
            }
            $query->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No officer ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request.</div>";
    }
}
