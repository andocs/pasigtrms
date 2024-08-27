<?php
$userid = $_SESSION['userid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch POST data
    $vehId = $_POST['veh_id'] ?? '';
    $plateNo = $_POST['plate_no'] ?? '';
    $caseId = $_POST['case_id'] ?? '';
    $vtypeId = $_POST['vtype_id'] ?? '';
    $optrId = $_POST['optr_id'] ?? '';
    $terminalId = $_POST['terminal_id'] ?? '';
    $groupId = $_POST['group_id'] ?? '';
    $crNo = $_POST['cr_no'] ?? '';
    $engineNo = $_POST['engine_no'] ?? '';
    $chassisNo = $_POST['chassis_no'] ?? '';
    $drivers = $_POST['drivers'] ?? [];

    // Check if all required fields are provided
    if (empty($plateNo) || empty($caseId) || empty($vtypeId) || empty($optrId) || empty($terminalId) || empty($groupId) || empty($crNo) || empty($engineNo) || empty($chassisNo) || empty($drivers)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                if (!empty($vehId)) {
                    // Insert new vehicle using prepared statement
                    $insertQuery = $conn->prepare("INSERT INTO vehicle_unit (veh_id, plate_no, case_id, vtype_id, optr_id, terminal_id, group_id, cr_no, engine_no, chassis_no) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insertQuery->bind_param('ssssssssss', $vehId, $plateNo, $caseId, $vtypeId, $optrId, $terminalId, $groupId, $crNo, $engineNo, $chassisNo);
                    if ($insertQuery->execute()) {
                        // Get the last inserted veh_id
                        $vehId = $conn->insert_id;

                        // Insert drivers into vehicle_driver table
                        foreach ($drivers as $driverId) {
                            $driverQuery = $conn->prepare("INSERT INTO vehicle_driver (veh_id, driver_id) VALUES (?, ?)");
                            $driverQuery->bind_param('ss', $vehId, $driverId);
                            $driverQuery->execute();
                            $driverQuery->close();
                        }

                        // Add audit log
                        log_add($userid, 'vehicle_unit', [
                            'veh_id' => $vehId,
                            'plate_no' => $plateNo,
                            'case_id' => $caseId,
                            'vtype_id' => $vtypeId,
                            'optr_id' => $optrId,
                            'terminal_id' => $terminalId,
                            'group_id' => $groupId,
                            'cr_no' => $crNo,
                            'engine_no' => $engineNo,
                            'chassis_no' => $chassisNo
                        ], $conn);

                        redirectTo('success', 'Successfully added.', 'trms.php?page=vehicle');
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $insertQuery->error . "</div>";
                    }
                    $insertQuery->close();
                } else {
                    echo "<div class='alert alert-danger'>No generated Vehicle ID!</div>";
                    exit;
                }
                break;

            case 'edit':
                // Fetch veh_id from POST data
                $rowId = $_POST['id'] ?? '';

                // Fetch old data for auditing
                $oldQuery = $conn->prepare("SELECT * FROM vehicle_unit WHERE id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update existing vehicle using prepared statement
                $query = $conn->prepare("UPDATE vehicle_unit SET plate_no = ?, case_id = ?, vtype_id = ?, optr_id = ?, terminal_id = ?, group_id = ?, cr_no = ?, engine_no = ?, chassis_no = ? WHERE id = ?");
                $query->bind_param('sssssssssi', $plateNo, $caseId, $vtypeId, $optrId, $terminalId, $groupId, $crNo, $engineNo, $chassisNo, $rowId);
                if ($query->execute()) {
                    // Delete existing drivers for the vehicle
                    $deleteDriverQuery = $conn->prepare("DELETE FROM vehicle_driver WHERE veh_id = ?");
                    $deleteDriverQuery->bind_param('i', $rowId);
                    $deleteDriverQuery->execute();
                    $deleteDriverQuery->close();

                    // Insert new drivers into vehicle_driver table
                    foreach ($drivers as $driverId) {
                        $driverQuery = $conn->prepare("INSERT INTO vehicle_driver (veh_id, driver_id) VALUES (?, ?)");
                        $driverQuery->bind_param('si', $rowId, $driverId);
                        $driverQuery->execute();
                        $driverQuery->close();
                    }

                    // Add audit log
                    log_edit($userid, 'vehicle_unit', $oldData, [
                        'plate_no' => $plateNo,
                        'case_id' => $caseId,
                        'vtype_id' => $vtypeId,
                        'optr_id' => $optrId,
                        'terminal_id' => $terminalId,
                        'group_id' => $groupId,
                        'cr_no' => $crNo,
                        'engine_no' => $engineNo,
                        'chassis_no' => $chassisNo
                    ], $conn);

                    redirectTo('success', 'Successfully edited.', 'trms.php?page=vehicle');
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
                }
                $query->close();
                break;
        }
    } else {
        echo "<div class='alert alert-danger'>No action specified.</div>";
    }
} else {
    if (isset($_GET['action']) && $_GET['action'] == "delete") {
        $vehicleId = $_GET['id'] ?? '';
        if (!empty($vehicleId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM vehicle_unit WHERE id = ?");
            $oldQuery->bind_param('s', $vehicleId);
            $oldQuery->execute();
            $oldResult = $oldQuery->get_result();
            if ($oldResult && $oldResult->num_rows > 0) {
                $oldData = $oldResult->fetch_assoc();
            } else {
                echo "<div class='alert alert-danger'>No data found for the provided vehicle ID.</div>";
                exit;
            }
            $oldQuery->close();
    
            // Ensure deletion of vehicle drivers first
            $deleteDriverQuery = $conn->prepare("DELETE FROM vehicle_driver WHERE veh_id = ?");
            $deleteDriverQuery->bind_param('s', $vehicleId);
            $deleteDriverQuery->execute();
            $deleteDriverQuery->close();
    
            // Now delete the vehicle
            $deleteQuery = $conn->prepare('DELETE FROM vehicle_unit WHERE id = ?');
            $deleteQuery->bind_param('s', $vehicleId);
            if ($deleteQuery->execute()) {
                // Add audit log
                log_delete($userid, 'vehicle_unit', $oldData, $conn);
    
                // Redirect to success page
                redirectTo('success', 'Successfully deleted.', 'trms.php?page=vehicle');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $deleteQuery->error . "</div>";
            }
            $deleteQuery->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No vehicle ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request.</div>";
    }    
}
