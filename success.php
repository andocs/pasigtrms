<?php
require_once('db_connection.php');
session_start();

$user = trim($_POST['username']);
$upass = trim($_POST['password']);
$h_pass = md5($upass);  

$sql = "SELECT * FROM `users` WHERE `username` = ? AND `password` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $h_pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $found_user = $result->fetch_array(MYSQLI_ASSOC);
    $_SESSION['userid'] = $found_user['userid'];
    $_SESSION['name'] = $found_user['name'];
    $_SESSION['username'] = $found_user['username'];
    $_SESSION['email'] = $found_user['email'];
    $_SESSION['position'] = $found_user['position'];
    
    if ($_SESSION['position'] == 'ADMIN') {
        header("Location: index.html");
        exit();
    } else {
        header("Location: homepage.php");
        exit();
    }
} else {
    echo "<script>alert('Username or Password Not Registered! Contact Your administrator.');</script>";
    header("Location: index.html");
    exit();
}
$stmt->close();
$conn->close();
?>
