<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'includes/db_connection.php';
require 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']);

    $stmt = $conn->prepare('SELECT userid, password FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, log in the user
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $userid;

            log_action($userid, 'Login', 'User logged in', $conn);

            // Set a cookie if "Remember Me" is checked
            if ($remember_me) {
                $cookie_value = bin2hex(random_bytes(32)); // Generate random token
                setcookie('remember_me', $cookie_value, time() + (86400 * 30), "/"); // Set cookie for X days, in this case 30.

                $stmt = $conn->prepare('UPDATE users SET remember_token = ? WHERE userid = ?');
                $stmt->bind_param('ss', $cookie_value, $_SESSION['userid']);
                $stmt->execute();
            }

            redirectTo('success', 'You have successfully logged in!', 'trms.php?page=homepage');
            exit;
        } else {
            // Password is incorrect, display error message
            redirectTo('info', 'Incorrect password!', 'trms.php?page=homepage');
        }
    } else {
        // Username not found, display error message
        redirectTo('info', 'Incorrect username!', 'trms.php?page=homepage');
    }

    $stmt->close();
}
