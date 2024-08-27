<?php
date_default_timezone_set('Asia/Manila');

function log_action($userid, $action, $description, $conn) {
    $stmt = $conn->prepare('INSERT INTO audit_log (userid, action, description) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $userid, $action, $description);
    $stmt->execute();
    $stmt->close();
}
?>
