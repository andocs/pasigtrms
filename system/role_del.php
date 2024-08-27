<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();

require_once 'session.php';
require_once 'db_connection.php';

if (isset($_GET['userid'])) {
    $id = $_GET['userid'];

    $query = "DELETE FROM users WHERE userid = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: role.php?deleted=true');
            exit();
        } else {
            error_log('Error: User ID not found.');
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: role.php?deleted=false');
            exit();
        }
    } else {
        error_log('Error preparing statement: ' . mysqli_error($conn));
        header('Location: role.php?deleted=false');
        exit();
    }
} else {
    error_log('No user ID provided');
    header('Location: role.php?deleted=false');
    exit();
}


mysqli_close($conn);

ob_end_flush();
?>
