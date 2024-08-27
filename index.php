<?php

$pageTitle = 'Login';
require_once 'includes/db_connection.php';
require_once 'includes/header.php';
require_once 'includes/functions.php';

if (isUserLoggedIn()) {
  redirectTo('', '', 'trms.php?page=homepage');
}

?>
<div class="clock">
  <p id="date"></p>
  <p id="time"></p>
</div>
<div class="wrapper">
  <div id="toast" class="toast align-items-center position-absolute top-0 end-0 w-auto px-1 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div id="toast-body" class="toast-body">
      </div>
      <button type="button" class="btn-close p-2 m-auto btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  <div class="logo-container">
    <img src="uploads/logo2.jpg" alt="Pasig City Logo">
    <img src="uploads/agos2.png" alt="Pasig City Wordmark">
  </div>

  <div class="title-text">
    <div class="title login">Login Form</div>
    <div class="title signup">Signup Form</div>
  </div>
  <div class="form-container">
    <div class="slide-controls">
      <input type="radio" name="slide" id="login" checked>
      <input type="radio" name="slide" id="signup">
      <label for="login" class="slide login">Login</label>
      <label for="signup" class="slide signup">Signup</label>
      <div class="slider-tab"></div>
    </div>

    <!-- Login Form -->
    <div class="form-inner">
      <form action="authenticate.php" method="POST" class="login">
        <div class="field">
          <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="field">
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="pass-link d-flex justify-content-between align-middle">
          <div>
            <input type="checkbox" id="remember_me" name="remember_me"> Remember Me
          </div>
          <a href="forgot_password.php">Forgot password?</a>
        </div>
        <div class="field btn">
          <input type="submit" value="Login">
        </div>
        <div class="signup-link">Not a member? <a href="">Signup now</a></div>
      </form>

      <!-- Signup Form -->
      <form action="register_process.php" method="POST" class="signup">
        <div class="field">
          <input type="text" name="name" placeholder="Full Name" required>
        </div>
        <div class="field">
          <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="field">
          <input type="text" name="email" placeholder="Email Address" required>
        </div>
        <div class="field">
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="field">
          <input type="password" name="confirm_password" placeholder="Confirm password" required>
        </div>
        <div class="form-check mb-3">
          <input type="checkbox" id="terms" />
          <label class="form-check-label" for="terms">I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a></label>
        </div>
        <div class="field btn">
          <div class="btn-layer"></div>
          <input type="submit" value="Signup">
        </div>
      </form>
    </div>
  </div>

</div>
<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2>Terms and Conditions</h2>
        <p>Welcome to our Web Base System!</p>
        <p>These terms and conditions outline the rules and regulations for the use of our Web Base System.</p>

        <h3>1. Terms</h3>
        <p>By accessing this Transportation & Regulatory Management System, you are agreeing to be bound by these Web Base System Terms and Conditions of Use, applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site.</p>

        <h3>2. Use License</h3>
        <p>Permission is granted to temporarily download one copy of the materials (information or software) on our website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
        <ul>
          <li>Modify or copy the materials;</li>
          <li>Use the materials for any commercial purpose, or for any public display (commercial or non-commercial);</li>
          <li>Attempt to decompile or reverse engineer any software contained on our Web Base System;</li>
          <li>Remove any copyright or other proprietary notations from the materials; or</li>
          <li>Transfer the materials to another person or "mirror" the materials on any other server.</li>
        </ul>
        <p>This license shall automatically terminate if you violate any of these restrictions and may be terminated by us at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed format.</p>

        <h3>3. Disclaimer</h3>
        <p>The materials on our Web Base System are provided "as is". We make no warranties, expressed or implied, and hereby disclaim and negate all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. Further, we do not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on our website or otherwise relating to such materials or on any sites linked to this site.</p>

        <!-- Add more sections as needed -->

        <h3>Contact Us</h3>
        <p>If you have any questions about these Terms, please contact us at [info@mail.com].</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>