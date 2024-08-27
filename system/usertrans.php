<?php
$userid = $_SESSION['userid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $conf_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';
    $picture = '';

    // Check for empty fields
    if (empty($name) || empty($username) || empty($email) || empty($role)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit;
    }

    // Check for valid email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Invalid email format.</div>";
        exit;
    }

    // Handle picture upload
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $picture = 'uploads/' . basename($_FILES['picture']['name']);
        if (!move_uploaded_file($_FILES['picture']['tmp_name'], $picture)) {
            echo "<div class='alert alert-danger'>Error uploading picture.</div>";
            exit;
        }
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                if (empty($password) || empty($conf_password)) {
                    echo "<div class='alert alert-danger'>All fields are required.</div>";
                    exit;
                }

                // Check if passwords match
                if ($password !== $conf_password) {
                    echo "<div class='alert alert-danger'>Passwords do not match.</div>";
                    exit;
                }

                // Check for duplicate email
                $emailCheckQuery = $conn->prepare("SELECT * FROM users WHERE email = ?");
                $emailCheckQuery->bind_param('s', $email);
                $emailCheckQuery->execute();
                $emailResult = $emailCheckQuery->get_result();

                if ($emailResult->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Error: Email already exists.</div>";
                    exit;
                }

                // Generate verification code
                $verification_code = bin2hex(random_bytes(5));

                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $initialStatus = 'inactive';

                // Insert new user using a prepared statement
                $query = $conn->prepare("INSERT INTO users (name, username, email, role, picture, password, verification_code, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $query->bind_param('ssssssss', $name, $username, $email, $role, $picture, $hashed_password, $verification_code, $initialStatus);
                if ($query->execute()) {
                    // Add audit log
                    log_add($userid, 'users', [
                        'name' => $name,
                        'username' => $username,
                        'email' => $email,
                        'role' => $role,
                        'picture' => $picture,
                        'verification_code' => $verification_code,
                        'status' => $initialStatus
                    ], $conn);

                    // Send verification email
                    $verification_link = "https://localhost/pasigtrms/trms.php?page=verify&email=$email&code=$verification_code";
                    $subject = "Account Verification";
                    $message = "Please click the following link to verify your account: $verification_link";
                    if (sendMail($email, $subject, $message) == 'success') {
                        redirectTo('success', 'Account Verification Code sent.', 'trms.php?page=user');
                    }
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
                }
                $query->close();
                break;

            case 'edit':
                $userId = $_POST['user_id'] ?? '';

                // Fetch old data for auditing
                $oldQuery = $conn->prepare("SELECT * FROM users WHERE userid = ?");
                $oldQuery->bind_param('i', $userId);
                $oldQuery->execute();
                $oldData = $oldQuery->get_result()->fetch_assoc();
                $oldQuery->close();

                // Check for duplicate email for edit action
                // $emailCheckQuery = $conn->prepare("SELECT * FROM users WHERE email = ? AND userid != ?");
                // $emailCheckQuery->bind_param('si', $email, $userId);
                // $emailCheckQuery->execute();
                // $emailResult = $emailCheckQuery->get_result();

                // if ($emailResult->num_rows > 0) {
                //     echo "<div class='alert alert-danger'>Error: Email already exists.</div>";
                //     exit;
                // }

                // Update user using a prepared statement
                if (!empty($userId) && !empty($name) && !empty($username) && !empty($email) && !empty($role)) {
                    if (!empty($picture)) {
                        $query = $conn->prepare("UPDATE users SET name = ?, username = ?, email = ?, role = ?, picture = ? WHERE userid = ?");
                        $query->bind_param('sssssi', $name, $username, $email, $role, $picture, $userId);
                    } else {
                        $query = $conn->prepare("UPDATE users SET name = ?, username = ?, email = ?, role = ? WHERE userid = ?");
                        $query->bind_param('ssssi', $name, $username, $email, $role, $userId);
                    }
                    if ($query->execute()) {
                        // Add audit log
                        log_edit($userid, 'users', $oldData, [
                            'name' => $name,
                            'username' => $username,
                            'email' => $email,
                            'role' => $role,
                            'picture' => $picture
                        ], $conn);

                        redirectTo('success', 'Successfully edited.', 'trms.php?page=user');
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Required form fields are missing.</div>";
                }
                $query->close();
                break;

            default:
                echo "<div class='alert alert-danger'>Invalid action.</div>";
                break;
        }
    } else {
        echo "<div class='alert alert-danger'>No action set.</div>";
    }
} else {
    if (isset($_GET['action']) && $_GET['action'] == "delete") {
        $userId = $_GET['id'] ?? '';
        if (!empty($userId)) {
            // Fetch old data for auditing
            $oldQuery = $conn->prepare("SELECT * FROM users WHERE userid = ?");
            $oldQuery->bind_param('i', $userId);
            $oldQuery->execute();
            $oldData = $oldQuery->get_result()->fetch_assoc();
            $oldQuery->close();

            // Prepare the DELETE statement
            $deleteQuery = $conn->prepare('DELETE FROM users WHERE userid = ?');
            $deleteQuery->bind_param('i', $userId);
            // Execute the statement
            if ($deleteQuery->execute()) {
                // Add audit log
                log_delete($userid, 'users', $oldData, $conn);

                redirectTo('success', 'Successfully Deleted.', 'trms.php?page=user');
            } else {
                echo "<div class='alert alert-danger'>Error: " . $deleteQuery->error . "</div>";
            }
            $deleteQuery->close();
        } else {
            echo "<div class='alert alert-danger'>Invalid request. No user ID provided.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request method.</div>";
    }
}
?>
