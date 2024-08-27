<?php
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $userid = $_SESSION['userid'];

    setcookie('remember_me', '', time() - 3600, '/');
    log_action($userid, 'Logout', 'User logged out', $conn);
    session_unset();
    session_destroy();
}

header('Location: index.php');
exit();
?>
