<?php
date_default_timezone_set('Asia/Manila');

require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: forgot_password.php?message=invalid_email');
        exit();
    }

    $stmt = $conn->prepare('SELECT userid FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid);
        $stmt->fetch();

        $reset_code = bin2hex(random_bytes(16));
        $stmt = $conn->prepare('UPDATE users SET reset_code = ? WHERE userid = ?');
        $stmt->bind_param('si', $reset_code, $userid);
        $stmt->execute();

        $subject = 'Password Reset Request';
        $reset_link = 'https://localhost/pasigtrms/reset_password.php?email=' . urlencode($email) . '&code=' . $reset_code;
        $body = '<p>To reset your password, please click the following link: <a href="' . $reset_link . '">' . $reset_link . '</a></p>';

        $mailSent = sendMail($email, $subject, $body);
        if ($mailSent == 'success') {
            redirectTo('', '', 'forgot_password.php?message=sent');
        } else {
            redirectTo('info', $mailSent, 'forgot_password.php?message=error');
        }
        exit();
    }
}
 else {
    redirectTo('', '', 'forgot_password.php?message=404');
    exit();
}
