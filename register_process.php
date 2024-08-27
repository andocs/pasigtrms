<?php
date_default_timezone_set('Asia/Manila');

require 'includes/db_connection.php';
require 'includes/functions.php';

// Function to display an alert and redirect back
function popup_alert($message)
{
    echo "<script type='text/javascript'>alert('$message'); window.history.back();</script>";
    exit();
}

// Check if required fields are set and not empty
if (
    !isset($_POST['name'], $_POST['username'], $_POST['password'], $_POST['email']) ||
    empty($_POST['name']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])
) {
    popup_alert('Please complete the registration form!');
}

$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    popup_alert('Email is not valid!');
}

// Validate username (alphanumeric)
if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
    popup_alert('Username is not valid!');
}

// Validate password complexity
if (strlen($password) > 20 || strlen($password) < 8) {
    popup_alert('Password must be between 8 and 20 characters long!');
}
if (!preg_match('/[A-Z]/', $password)) {
    popup_alert('Password must include at least one uppercase letter!');
}
if (!preg_match('/[a-z]/', $password)) {
    popup_alert('Password must include at least one lowercase letter!');
}
if (!preg_match('/[0-9]/', $password)) {
    popup_alert('Password must include at least one number!');
}
if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
    popup_alert('Password must include at least one special character!');
}

// Check if username already exists
if ($stmt = $conn->prepare('SELECT userid FROM users WHERE username = ?')) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        popup_alert('Username exists, please choose another!');
    } else {
        // Insert new user
        if ($stmt = $conn->prepare('INSERT INTO users (name, username, password, email, verification_code, status, role) VALUES (?, ?, ?, ?, ?, ?, ?)')) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $verification_code = mt_rand(100000, 999999);
            $status = 'inactive';
            $role = 3;

            $stmt->bind_param('ssssssi', $name, $username, $password_hash, $email, $verification_code, $status, $role);

            if ($stmt->execute()) {
                // Send verification email
                $subject = 'Account Verification';
                $body = '<p>Your verification code is: <strong>' . $verification_code . '</strong>. It will expire within 1 minute.</p>';
                $mailSent = sendMail($email, $subject, $body);

                if ($mailSent == 'success') {
                    redirectTo('', '', 'verify.php?email=' . urlencode($email));
                } else {
                    popup_alert('Error sending email: ' . $mailSent);
                }
            } else {

                popup_alert('Error inserting user: ' . $stmt->error);
            }
            $stmt->close();
        } else {
            popup_alert('Could not prepare statement for user insertion.');
        }
    }
} else {
    popup_alert('Could not prepare statement for username check.');
}

$conn->close();
