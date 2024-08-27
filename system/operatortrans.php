<?php
$userid = $_SESSION['userid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $operatorId = $_POST['optr_id'] ?? '';
    $residencyId = $_POST['resi_id'] ?? '';
    $operatorName = $_POST['optr_name'] ?? '';
    $operatorAddress = $_POST['optr_add'] ?? '';
    $operatorContact = $_POST['optr_contact'] ?? '';

    // Check for empty fields
    if (empty($operatorId) || empty($residencyId) || empty($operatorName) || empty($operatorAddress) || empty($operatorContact)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Check for duplicate operator ID using a prepared statement
                $query = $conn->prepare("SELECT * FROM operator WHERE optr_id = ?");
                $query->bind_param('s', $operatorId);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Operator ID already exists.</div>";
                } else {
                    // Insert new operator using a prepared statement
                    $insertQuery = $conn->prepare("INSERT INTO operator (optr_id, resi_id, optr_name, optr_add, optr_contact) VALUES (?, ?, ?, ?, ?)");
                    $insertQuery->bind_param('sssss', $operatorId, $residencyId, $operatorName, $operatorAddress, $operatorContact);
                    if ($insertQuery->execute()) {
                        // Add audit log
                        log_add($userid, 'operator', [
                            'optr_id' => $operatorId,
                            'resi_id' => $residencyId,
                            'optr_name' => $operatorName,
                            'optr_add' => $operatorAddress,
                            'optr_contact' => $operatorContact
                        ], $conn);

                        redirectTo('success', 'Successfully added.', 'trms.php?page=operator');
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
                $oldQuery = $conn->prepare("SELECT * FROM operator WHERE id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update operator using a prepared statement
                $query = $conn->prepare("UPDATE operator SET resi_id = ?, optr_name = ?, optr_add = ?, optr_contact = ? WHERE id = ?");
                $query->bind_param('ssssi', $residencyId, $operatorName, $operatorAddress, $operatorContact, $rowId);
                if ($query->execute()) {
                    // Add audit log
                    log_edit($userid, 'operator', $oldData, [
                        'optr_id' => $operatorId,
                        'resi_id' => $residencyId,
                        'optr_name' => $operatorName,
                        'optr_add' => $operatorAddress,
                        'optr_contact' => $operatorContact
                    ], $conn);

                    redirectTo('success', 'Successfully edited.', 'trms.php?page=operator');
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
        $operatorId = $_GET['id'] ?? '';
        if (!empty($operatorId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM operator WHERE id = ?");
            $oldQuery->bind_param('i', $operatorId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Prepare the DELETE statement
            $query = $conn->prepare('DELETE FROM operator WHERE id = ?');
            $query->bind_param('i', $operatorId);
            // Execute the statement
            if ($query->execute()) {
                // Add audit log
                log_delete($userid, 'operator', $oldData, $conn);

                redirectTo('success', 'Successfully Deleted.', 'trms.php?page=operator');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No operator ID provided.</div>";
        }
        $query->close();
    } else {
        echo "<div class='alert alert-danger'>Invalid request.</div>";
    }
}
