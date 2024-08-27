<?php
date_default_timezone_set('Asia/Manila');
require_once 'includes/db_connection.php';

$response = array('status' => 'error', 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        
        if ($stmt = $conn->prepare('SELECT last_code_sent_at FROM users WHERE email = ?')) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($last_code_sent_at);
            $stmt->fetch();
            
            if ($stmt->num_rows > 0) {
                $current_time = new DateTime();
                $last_code_time = new DateTime($last_code_sent_at);
                $interval = $current_time->diff($last_code_time);

                if ($interval->i >= 1) {
                    // Generate a new code
                    $new_code = rand(100000, 999999);
                    
                    if ($update_stmt = $conn->prepare('UPDATE users SET verification_code = ?, last_code_sent_at = NOW() WHERE email = ?')) {
                        $update_stmt->bind_param('ss', $new_code, $email);
                        $update_stmt->execute();
                        
                        // Here you would send the new code via email
                        sendMail($email, "Your Verification Code", "Your new verification code is: $new_code");

                        $response['status'] = 'success';
                        $response['message'] = 'A new verification code has been sent to your email.';
                    } else {
                        $response['message'] = 'Failed to update verification code. Please contact support.';
                    }
                } else {
                    $response['message'] = 'Please wait for a minute before requesting a new code.';
                }
            } else {
                $response['message'] = 'Email address not found!';
            }
        } else {
            $response['message'] = 'Error processing your request. Please try again later.';
        }
    }
}
echo json_encode($response);
?>
