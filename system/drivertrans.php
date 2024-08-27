<?php
$userid = $_SESSION['userid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $driverId = $_POST['driver_id'] ?? '';
    $residencyId = $_POST['resi_id'] ?? '';
    $driverName = $_POST['driver_name'] ?? '';
    $driverAddress = $_POST['driver_address'] ?? '';
    $driverContact = $_POST['driver_contact'] ?? '';

    // Check for empty fields
    if (empty($driverId) || empty($residencyId) || empty($driverName) || empty($driverAddress) || empty($driverContact)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Check for duplicate driver ID using a prepared statement
                $query = $conn->prepare("SELECT * FROM driver WHERE driver_id = ?");
                $query->bind_param('s', $driverId);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Driver ID already exists.</div>";
                } else {
                    // Insert new driver using a prepared statement
                    $insertQuery = $conn->prepare("INSERT INTO driver (driver_id, resi_id, driver_name, driver_address, driver_contact) VALUES (?, ?, ?, ?, ?)");
                    $insertQuery->bind_param('sssss', $driverId, $residencyId, $driverName, $driverAddress, $driverContact);
                    if ($insertQuery->execute()) {
                        // Add audit log
                        log_add($userid, 'driver', [
                            'driver_id' => $driverId,
                            'resi_id' => $residencyId,
                            'driver_name' => $driverName,
                            'driver_address' => $driverAddress,
                            'driver_contact' => $driverContact
                        ], $conn);

                        redirectTo('success', 'Successfully added.', 'trms.php?page=driver');
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
                $oldQuery = $conn->prepare("SELECT * FROM driver WHERE id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update driver using a prepared statement
                $query = $conn->prepare("UPDATE driver SET resi_id = ?, driver_name = ?, driver_address = ?, driver_contact = ? WHERE id = ?");
                $query->bind_param('ssssi', $residencyId, $driverName, $driverAddress, $driverContact, $rowId);
                if ($query->execute()) {
                    // Add audit log
                    log_edit($userid, 'driver', $oldData, [
                        'driver_id' => $driverId,
                        'resi_id' => $residencyId,
                        'driver_name' => $driverName,
                        'driver_address' => $driverAddress,
                        'driver_contact' => $driverContact
                    ], $conn);

                    redirectTo('success', 'Successfully edited.', 'trms.php?page=driver');
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
        $driverId = $_GET['id'] ?? '';
        if (!empty($driverId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM driver WHERE id = ?");
            $oldQuery->bind_param('i', $driverId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Prepare the DELETE statement
            $query = $conn->prepare('DELETE FROM driver WHERE id = ?');
            $query->bind_param('i', $driverId);
            // Execute the statement
            if ($query->execute()) {
                // Add audit log
                log_delete($userid, 'driver', $oldData, $conn);

                redirectTo('success', 'Successfully deleted.', 'trms.php?page=driver');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
            }
            $query->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No driver ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request.</div>";
    }
}
