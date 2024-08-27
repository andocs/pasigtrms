<?php
$userid = $_SESSION['userid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get resolution variables from the form
    $resoId = $_POST['reso_id'] ?? '';
    $inspId = $_POST['insp_id'] ?? '';
    $resoName = $_POST['reso_name'] ?? '';
    $veriClear = $_POST['veri_clear'] ?? '';

    // Check for empty fields
    if (empty($resoId) || empty($inspId) || empty($resoName) || empty($veriClear)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Insert new resolution
                $insertQuery = $conn->prepare("INSERT INTO term_approval (reso_id, insp_id, reso_name, veri_clear) VALUES (?, ?, ?, ?)");
                $insertQuery->bind_param('ssss', $resoId, $inspId, $resoName, $veriClear);
                if ($insertQuery->execute()) {
                    // Add audit log
                    log_add($userid, 'term_approval', [
                        'reso_id' => $resoId,
                        'insp_id' => $inspId,
                        'reso_name' => $resoName,
                        'veri_clear' => $veriClear
                    ], $conn);

                    redirectTo('success', 'Successfully added.', 'trms.php?page=reso');
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $insertQuery->error . "</div>";
                }
                $insertQuery->close();
                break;

            case 'edit':
                $rowId = $_POST['id'] ?? '';

                // Fetch old data for auditing
                $oldQuery = $conn->prepare("SELECT * FROM term_approval WHERE id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update resolution
                $query = $conn->prepare("UPDATE term_approval SET insp_id = ?, reso_name = ?, veri_clear = ? WHERE id = ?");
                $query->bind_param('sssi', $inspId, $resoName, $veriClear, $rowId);
                if ($query->execute()) {
                    // Add audit log
                    log_edit($userid, 'term_approval', $oldData, [
                        'reso_id' => $resoId,
                        'insp_id' => $inspId,
                        'reso_name' => $resoName,
                        'veri_clear' => $veriClear
                    ], $conn);

                    redirectTo('success', 'Successfully edited.', 'trms.php?page=reso');
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
        // Resolution ID for deletion
        $rowId = $_GET['id'] ?? '';
        if (!empty($rowId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM term_approval WHERE id = ?");
            $oldQuery->bind_param('i', $rowId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Prepare the DELETE statement
            $query = $conn->prepare('DELETE FROM term_approval WHERE id = ?');
            $query->bind_param('i', $rowId);
            // Execute the statement
            if ($query->execute()) {
                // Add audit log
                log_delete($userid, 'term_approval', $oldData, $conn);

                redirectTo('success', 'Successfully deleted.', 'trms.php?page=reso');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
            }
            $query->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No resolution ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request.</div>";
    }
}
