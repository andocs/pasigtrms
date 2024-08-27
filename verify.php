<?php
require_once 'includes/db_connection.php';
require_once 'includes/header.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'], $_POST['code'])) {
        $email = $_POST['email'];
        $code = $_POST['code'];

        if ($stmt = $conn->prepare('SELECT * FROM users WHERE email = ? AND verification_code = ?')) {
            $stmt->bind_param('ss', $email, $code);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                if ($update_stmt = $conn->prepare('UPDATE users SET status = ? WHERE email = ? AND verification_code = ?')) {
                    $new_status = 'activated';
                    $update_stmt->bind_param('sss', $new_status, $email, $code);
                    $update_stmt->execute();
                    $message = 'Your account is now activated! You can now login!';
                    redirectTo('success', $message, 'trms.php');
                } else {
                    $message = 'Failed to update user status. Please contact support.';
                    redirectTo('warning', $message, 'trms.php');
                }
            } else {
                $message = 'Incorrect email or verification code!';
                redirectTo('warning', $message, 'trms.php');
            }
        } else {
            $message = 'Error processing your request. Please try again later.';
            redirectTo('warning', $message, 'trms.php');
        }
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
        <div class="title login">Account Verification</div>
    </div>
    <div class="form-container">
        <div class="form-inner">
            <?php if ($message) : ?>
                <div class="message">
                    <?= $message ?>
                </div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="verify">
                <div class="field">
                    <input type="text" name="email" placeholder="Email Address" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>" readonly>
                </div>
                <div class="field">
                    <input type="text" name="code" placeholder="Verification Code" required>
                </div>
                <div class="field btn">
                    <div class="btn-layer"></div>
                    <input type="submit" value="Verify">
                </div>
            </form>
            <div class="resend-container">
                <span>Didn't receive a code? </span>
                <a href="resend_code.php" id="resendCodeLink">Resend</a>
            </div>
        </div>
    </div>
</div>