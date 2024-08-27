<?php
$userid = $_SESSION['userid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get case variables from the form
    $caseId = $_POST['case_id'] ?? '';
    $routeId = $_POST['route_id'] ?? '';
    $caseNo = $_POST['case_no'] ?? '';
    $caseGranted = $_POST['case_granted'] ?? '';
    $caseExpired = $_POST['case_expire'] ?? '';

    // Check for empty fields
    if (empty($caseId) || empty($routeId) || empty($caseNo) || empty($caseGranted) || empty($caseExpired)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Check for duplicate case ID
                $query = $conn->prepare("SELECT * FROM cases WHERE case_id = ?");
                $query->bind_param('s', $caseId);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Case ID already exists.</div>";
                } else {
                    // Insert new case
                    $insertQuery = $conn->prepare("INSERT INTO cases (case_id, route_id, case_no, case_granted, case_expire) VALUES (?, ?, ?, ?, ?)");
                    $insertQuery->bind_param('sisss', $caseId, $routeId, $caseNo, $caseGranted, $caseExpired);
                    if ($insertQuery->execute()) {
                        // Add audit log
                        log_add($userid, 'cases', [
                            'case_id' => $caseId,
                            'route_id' => $routeId,
                            'case_no' => $caseNo,
                            'case_granted' => $caseGranted,
                            'case_expire' => $caseExpired
                        ], $conn);

                        redirectTo('success', 'Successfully added.', 'trms.php?page=cases');
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
                $oldQuery = $conn->prepare("SELECT * FROM cases WHERE id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update case
                $query = $conn->prepare("UPDATE cases SET route_id = ?, case_no = ?, case_granted = ?, case_expire = ? WHERE id = ?");
                $query->bind_param('ssssi', $routeId, $caseNo, $caseGranted, $caseExpired, $rowId);
                if ($query->execute()) {
                    // Add audit log
                    log_edit($userid, 'cases', $oldData, [
                        'case_id' => $caseId,
                        'route_id' => $routeId,
                        'case_no' => $caseNo,
                        'case_granted' => $caseGranted,
                        'case_expire' => $caseExpired
                    ], $conn);

                    redirectTo('success', 'Successfully edited.', 'trms.php?page=cases');
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
        // Case ID for deletion
        $caseId = $_GET['id'] ?? '';
        if (!empty($caseId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM cases WHERE id = ?");
            $oldQuery->bind_param('i', $caseId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Prepare the DELETE statement
            $query = $conn->prepare('DELETE FROM cases WHERE id = ?');
            $query->bind_param('i', $caseId);
            // Execute the statement
            if ($query->execute()) {
                // Add audit log
                log_delete($userid, 'cases', $oldData, $conn);

                redirectTo('success', 'Successfully deleted.', 'trms.php?page=cases');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
            }
            $query->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No case ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request.</div>";
    }
}
