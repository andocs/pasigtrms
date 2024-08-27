<?php
$message = '';
require_once 'includes/header.php';

if (isset($_GET['message'])) {
    if ($_GET['message'] == 'sent') {
        $message = 'If the email address exists in our database, you will receive a password reset email shortly.';
    } elseif ($_GET['message'] == 'invalid_email') {
        $message = 'Email is not valid!';
    } elseif ($_GET['message'] == '404') {
        $message = 'Your email does not exist in our records.';
    } elseif ($_GET['message'] == 'error') {
        $message = 'There was an error sending the email. Please try again later.';
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
        <div class="title login">Forgot Password</div>
    </div>
    <div class="form-container">
        <div class="form-inner">
            <?php if (!empty($message)) : ?>
                <div class="message">
                    <?= $message ?>
                </div>
            <?php endif; ?>
            <form action="forgot_password_process.php" method="post">
                <div class="field">
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <!-- <label for="email">
                        <i class="fas fa-envelope"></i>
                    </label> -->
                <div class="field btn">
                    <div class="btn-layer"></div>
                    <input type="submit" value="Reset Password">
                </div>
                <button id="cancelBtn" class="submit" type="button">Cancel </button>
        </div>
        </form>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>