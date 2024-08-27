<?php
session_start();

if (!isUserLoggedIn() && isset($_COOKIE['remember_me'])) {
    require_once 'db_connection.php';
    
    $cookie_value = $_COOKIE['remember_me'];

    // Verify the token from the database
    $stmt = $connection->prepare('SELECT userid FROM users WHERE remember_token = ?');
    $stmt->bind_param('s', $cookie_value);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['userid'] = $stmt->fetch()[0];
    } else {
        // If the token is invalid, clear the cookie
        setcookie('remember_me', '', time() - 3600, '/');
    }
}
?>
