<?php
$userid = $_SESSION['userid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch POST data
    $routeId = $_POST['route_id'] ?? '';
    $routeLine = $_POST['route_line'] ?? '';
    $routeStruct = $_POST['route_struct'] ?? '';
    $routeModify = $_POST['route_modify'] ?? '';

    // Check for empty fields
    if (empty($routeId) || empty($routeLine) || empty($routeStruct)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                // Check for duplicate route ID using a prepared statement
                $query = $conn->prepare("SELECT * FROM route WHERE route_id = ?");
                $query->bind_param('s', $routeId);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Route ID already exists.</div>";
                } else {
                    // Insert new route using a prepared statement
                    $insertQuery = $conn->prepare("INSERT INTO route (route_id, route_line, route_struct, route_modify) VALUES (?, ?, ?, ?)");
                    $insertQuery->bind_param('ssss', $routeId, $routeLine, $routeStruct, $routeModify);
                    if ($insertQuery->execute()) {
                        // Add audit log
                        log_add($userid, 'route', [
                            'route_id' => $routeId,
                            'route_line' => $routeLine,
                            'route_struct' => $routeStruct,
                            'route_modify' => $routeModify
                        ], $conn);

                        redirectTo('success', 'Successfully added.', 'trms.php?page=route');
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
                $oldQuery = $conn->prepare("SELECT * FROM route WHERE id = ?");
                $oldQuery->bind_param('i', $rowId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Update route using a prepared statement
                $query = $conn->prepare("UPDATE route SET route_line = ?, route_struct = ?, route_modify = ? WHERE id = ?");
                $query->bind_param('sssi', $routeLine, $routeStruct, $routeModify, $rowId);
                if ($query->execute()) {
                    // Add audit log
                    log_edit($userid, 'route', $oldData, [
                        'route_id' => $routeId,
                        'route_line' => $routeLine,
                        'route_struct' => $routeStruct,
                        'route_modify' => $routeModify
                    ], $conn);

                    redirectTo('info', 'Successfully edited.', 'trms.php?page=route');
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
                }
                $query->close();
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
        $routeId = $_GET['id'] ?? '';
        if (!empty($routeId)) {
            $oldQuery = $conn->prepare("SELECT * FROM route WHERE id = ?");
            $oldQuery->bind_param('i', $routeId);
            $oldQuery->execute();
            $oldResult = $oldQuery->get_result();
            if ($oldResult && $oldResult->num_rows > 0) {
                $oldData = $oldResult->fetch_assoc();
            } else {
                echo "<div class='alert alert-danger'>No data found for the provided route ID.</div>";
                exit;
            }
            $oldQuery->close();

            // Prepare the DELETE statement
            $query = $conn->prepare('DELETE FROM route WHERE id = ?');
            $query->bind_param('i', $routeId);
            // Execute the statement
            if ($query->execute()) {
                // Add audit log
                log_delete($userid, 'route', $oldData, $conn);

                redirectTo('success', 'Successfully Deleted.', 'trms.php?page=route');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
            }
            $query->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No route ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request method.</div>";
    }
}
