<?php
$userid = $_SESSION['userid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get vehicle type variables from the form
    $modal = $_POST['modal'] ?? '';
    $modalName = $_POST['modal_name'] ?? '';

    // Check for empty fields
    if (empty($modal) || empty($modalName)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Check for duplicate modal
                $query = $conn->prepare("SELECT * FROM unit_type WHERE modal = ?");
                $query->bind_param('s', $modal);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Modal already exists.</div>";
                } else {
                    // Insert new vehicle type
                    $insertQuery = $conn->prepare("INSERT INTO unit_type (modal, modal_name) VALUES (?, ?)");
                    $insertQuery->bind_param('ss', $modal, $modalName);
                    if ($insertQuery->execute()) {
                        // Add audit log
                        log_add($userid, 'unit_type', [
                            'modal' => $modal,
                            'modal_name' => $modalName
                        ], $conn);

                        redirectTo('success', 'Successfully added vehicle type.', 'trms.php?page=vtype');
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
                $oldQuery = $conn->prepare("SELECT * FROM unit_type WHERE vtype_id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update vehicle type
                $query = $conn->prepare("UPDATE unit_type SET modal = ?, modal_name = ? WHERE vtype_id = ?");
                $query->bind_param('ssi', $modal, $modalName, $rowId);
                if ($query->execute()) {
                    // Add audit log
                    log_edit($userid, 'unit_type', $oldData, [
                        'modal' => $modal,
                        'modal_name' => $modalName
                    ], $conn);

                    redirectTo('success', 'Successfully edited vehicle type.', 'trms.php?page=vtype');
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
                }
                $query->close();
                break;

            default:
                echo "<div class='alert alert-danger'>No action set.</div>";
                break;
        }
    } else {
        echo "<div class='alert alert-danger'>No action set.</div>";
    }
} else {
    if (isset($_GET['action']) && $_GET['action'] == "delete") {
        // Vehicle type ID for deletion
        $vtypeId = $_GET['id'] ?? '';
        if (!empty($vtypeId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM unit_type WHERE vtype_id = ?");
            $oldQuery->bind_param('i', $vtypeId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Prepare the DELETE statement
            $query = $conn->prepare('DELETE FROM unit_type WHERE vtype_id = ?');
            $query->bind_param('i', $vtypeId);
            // Execute the statement
            if ($query->execute()) {
                // Add audit log
                log_delete($userid, 'unit_type', $oldData, $conn);

                redirectTo('success', 'Successfully deleted vehicle type.', 'trms.php?page=vtype');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
            }
            $query->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No vehicle type ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request.</div>";
    }
}
