<?php
date_default_timezone_set('Asia/Manila');

require_once 'includes/db_connection.php';
require_once 'includes/header.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['email'], $_GET['code'])) {
        $email = $_GET['email'];
        $code = $_GET['code'];

        $stmt = $conn->prepare('SELECT userid FROM users WHERE email = ? AND reset_code = ?');
        $stmt->bind_param('ss', $email, $code);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Reset code is valid, show the form to reset the password
            $stmt->bind_result($userid);
            $stmt->fetch();
        } else {
            $message = 'Invalid reset link or code has expired.';
        }
    } else {
        $message = 'Invalid request.';
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'], $_POST['code'], $_POST['password'])) {
        $email = $_POST['email'];
        $code = $_POST['code'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare('UPDATE users SET password = ?, reset_code = NULL WHERE email = ? AND reset_code = ?');
        $stmt->bind_param('sss', $password, $email, $code);
        if ($stmt->execute()) {
            $message = 'Your password has been reset successfully. You can now <a href="index.html">login</a>.';
        } else {
            $message = 'Failed to reset your password. Please try again.';
        }
    } else {
        $message = 'Invalid request.';
    }
}
?>
<div class="clock">
    <p id="date"></p>
    <p id="time"></p>
</div>

<div class="wrapper">
    <div class="logo-container">
        <img src="uploads/logo2.jpg" alt="Pasig City Logo">
        <img src="uploads/agos2.png" alt="Pasig City Wordmark">
    </div>
    <div class="title-text">
        <div class="title login">Reset Password</div>
    </div>
    <div class="form-container">
            <div class="form-inner">
                <?php if (!empty($message)): ?>
                    <div class="message">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                <?php if (empty($message) || strpos($message, 'successfully') === false): ?>
                    <form action="reset_password.php" method="post">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                        <input type="hidden" name="code" value="<?= htmlspecialchars($code) ?>">
                        <div class="field">
                            <input type="password" name="password" placeholder="New Password" required>
                        </div>
                        <div class="field btn">
                            <div class="btn-layer"></div>
                            <input type="submit" value="Reset Password">
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
</div>
<?php require_once 'includes/footer.php'; ?>