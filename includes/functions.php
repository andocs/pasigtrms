<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';
require_once 'session.php';
require_once 'phpqrcode/qrlib.php';

//checks and returns if user is logged in
function isUserLoggedIn()
{
    return isset($_SESSION['userid']);
}

//displays a popup alert before redirecting to link
function redirectTo($type, $message, $url)
{
    if (!$message == '') {
        $_SESSION['toast'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    header('Location: ' . $url);
    exit();
}

//is a valid page for trms.php
function isPage($page, $page_array)
{
    if (!in_array($page, $page_array)) {
        return false;
    }
    return true;
}

//gets row count for charts
function getRowCount($conn, $tableName)
{
    $sql = "SELECT COUNT(*) as count FROM $tableName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}

//checks if user has permission
function hasPermission($permissionId)
{
    if (isUserLoggedIn()) {
        global $conn;
        $userId = $_SESSION['userid'];
        $query = "
            SELECT 1
            FROM users
            INNER JOIN roles ON users.role = roles.role_id
            INNER JOIN role_permissions ON roles.role_id = role_permissions.role_id
            INNER JOIN permissions ON role_permissions.permission_id = permissions.permission_id
            WHERE users.userid = ? AND permissions.permission_id = ?
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $userId, $permissionId);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0 ? true : false;
    }
    return false;
}

//sends mail to user
function sendMail($email, $subject, $message)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->Host       = 'smtp.mail.yahoo.com';
        $mail->Username   = 'jerry_obico@yahoo.com';
        $mail->Password   = 'sfkvpvsnyuvvuqvh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('jerry_obico@yahoo.com', 'Pasig TRMS Support');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;

        if ($mail->send()) {
            return 'success';
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

//general audit log
function log_action($userid, $action, $description, $conn)
{
    $stmt = $conn->prepare('INSERT INTO audit_log (userid, action, description) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $userid, $action, $description);
    $stmt->execute();
    $stmt->close();
}

//log for create
function log_add($userid, $table, $data, $conn)
{
    $description = "Added new record to $table: " . json_encode($data);
    log_action($userid, 'Add', $description, $conn);
}

//log for update
function log_edit($userid, $table, $oldData, $newData, $conn)
{
    $description = "Edited record in $table. Old values: " . json_encode($oldData) . "; New values: " . json_encode($newData);
    log_action($userid, 'Edit', $description, $conn);
}

//log for delete
function log_delete($userid, $table, $data, $conn)
{
    $description = "Deleted record from $table: " . json_encode($data);
    log_action($userid, 'Delete', $description, $conn);
}
