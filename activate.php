<?php
require_once 'db_connection.php';

if (isset($_GET['email'], $_GET['code'])) {
    if ($stmt = $con->prepare('SELECT * FROM users WHERE email = ? AND activation_code = ?')) {
        $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            if ($stmt = $con->prepare('UPDATE users SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
                $newcode = 'activated';
                $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                $stmt->execute();
                echo 'Your account is now activated! You can now <a href="index.html">login</a>!';
            }
        } else {
            echo 'The account is already activated or doesn\'t exist!';
        }
    }
}
?>
