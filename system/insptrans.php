<?php
$userid = $_SESSION['userid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get inspection variables from the form
    $inspId = $_POST['insp_id'] ?? '';
    $inspDate = $_POST['insp_date'] ?? '';
    $terminalId = $_POST['terminal_id'] ?? '';
    $officerList = $_POST['officer_list'] ?? '';
    $billboard = $_POST['billboard'] ?? '';
    $comfortRoom = $_POST['comfort_room'] ?? '';
    $tenmAway = $_POST['tenm_away'] ?? '';
    $lotArea = $_POST['lot_area'] ?? '';
    $waitingShed = $_POST['waiting_shed'] ?? '';
    $xerox = $_POST['xerox'] ?? '';
    $inspRemark = $_POST['insp_remark'] ?? '';

    // Check for empty fields
    if (empty($inspId) || empty($inspDate) || empty($terminalId) || empty($officerList) || empty($billboard) || empty($comfortRoom) || empty($tenmAway) || empty($lotArea) || empty($waitingShed) || empty($xerox) || empty($inspRemark)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Check for duplicate inspection ID
                $query = $conn->prepare("SELECT * FROM insp_clearance WHERE insp_id = ?");
                $query->bind_param('s', $inspId);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Inspection ID already exists.</div>";
                } else {
                    // Insert new inspection
                    $insertQuery = $conn->prepare("INSERT INTO insp_clearance (insp_id, insp_date, terminal_id, officer_list, billboard, comfort_room, tenm_away, lot_area, waiting_shed, xerox, insp_remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insertQuery->bind_param('ssissssssss', $inspId, $inspDate, $terminalId, $officerList, $billboard, $comfortRoom, $tenmAway, $lotArea, $waitingShed, $xerox, $inspRemark);
                    
                    if ($insertQuery->execute()) {
                        // Add audit log
                        log_add($userid, 'insp_clearance', [
                            'insp_id' => $inspId,
                            'insp_date' => $inspDate,
                            'terminal_id' => $terminalId,
                            'officer_list' => $officerList,
                            'billboard' => $billboard,
                            'comfort_room' => $comfortRoom,
                            'tenm_away' => $tenmAway,
                            'lot_area' => $lotArea,
                            'waiting_shed' => $waitingShed,
                            'xerox' => $xerox,
                            'insp_remark' => $inspRemark
                        ], $conn);

                        redirectTo('success', 'Successfully added.', 'trms.php?page=insp');
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
                $oldQuery = $conn->prepare("SELECT * FROM insp_clearance WHERE id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update inspection
                $query = $conn->prepare("UPDATE insp_clearance SET insp_date = ?, terminal_id = ?, officer_list = ?, billboard = ?, comfort_room = ?, tenm_away = ?, lot_area = ?, waiting_shed = ?, xerox = ?, insp_remark = ? WHERE id = ?");
                $query->bind_param('ssssssssssi', $inspDate, $terminalId, $officerList, $billboard, $comfortRoom, $tenmAway, $lotArea, $waitingShed, $xerox, $inspRemark, $rowId);
                
                if ($query->execute()) {
                    // Add audit log
                    log_edit($userid, 'insp_clearance', $oldData, [
                        'insp_id' => $inspId,
                        'insp_date' => $inspDate,
                        'terminal_id' => $terminalId,
                        'officer_list' => $officerList,
                        'billboard' => $billboard,
                        'comfort_room' => $comfortRoom,
                        'tenm_away' => $tenmAway,
                        'lot_area' => $lotArea,
                        'waiting_shed' => $waitingShed,
                        'xerox' => $xerox,
                        'insp_remark' => $inspRemark
                    ], $conn);

                    redirectTo('success', 'Successfully edited.', 'trms.php?page=insp');
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
        // Inspection ID for deletion
        $inspId = $_GET['id'] ?? '';
        if (!empty($inspId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM insp_clearance WHERE id = ?");
            $oldQuery->bind_param('i', $inspId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Prepare the DELETE statement
            $query = $conn->prepare('DELETE FROM insp_clearance WHERE id = ?');
            $query->bind_param('i', $inspId);
            // Execute the statement
            if ($query->execute()) {
                // Add audit log
                log_delete($userid, 'insp_clearance', $oldData, $conn);

                redirectTo('success', 'Successfully deleted.', 'trms.php?page=insp');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
            }
            $query->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No inspection ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request.</div>";
    }
}
?>
