<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['userid'];
    $userId = $_POST['user_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $picture = '';

    // Check for empty fields
    if (empty($name) || empty($username) || empty($email)) {
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

    // Fetch old data for auditing
    $oldQuery = $conn->prepare("SELECT * FROM users WHERE userid = ?");
    $oldQuery->bind_param('s', $userId);
    $oldQuery->execute();
    $oldData = $oldQuery->get_result()->fetch_assoc();
    $oldQuery->close();

    // Update user profile using a prepared statement
    if ($picture === '') {
        // If no picture is uploaded, keep the current picture
        $query = $conn->prepare("UPDATE users SET name = ?, username = ?, email = ? WHERE userid = ?");
        $query->bind_param('sssi', $name, $username, $email, $userId);
    } else {
        $query = $conn->prepare("UPDATE users SET name = ?, username = ?, email = ?, picture = ? WHERE userid = ?");
        $query->bind_param('ssssi', $name, $username, $email, $picture, $userId);
    }

    if ($query->execute()) {
        // Add audit log
        log_edit($userid, 'users', $oldData, [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'picture' => $picture
        ], $conn);

        // Redirect to profile page with success message
        redirectTo('success', 'Profile Updated successfully.', 'trms.php?page=homepage');
    } else {
        echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
    }
    $query->close();
} else {
    echo "<div class='alert alert-danger'>Invalid request method.</div>";
}
