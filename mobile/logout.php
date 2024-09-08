<?php
// Display all errors for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_log', './php-error.log');
error_reporting(E_ALL);

// Require the necessary files
require 'db.php'; // Ensure db.php file exists and connection is successful
require 'functions.php'; // Ensure this file exists and includes the log_action function

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$encodedData = file_get_contents('php://input');
$decodedData = json_decode($encodedData, true);

$response = array();

try {
    // Ensure that 'userid' is set in the decoded JSON
    if (isset($decodedData['userid'])) {
        $userid = $decodedData['userid'];

        // Prepare the SQL statement and handle any potential errors
        if ($stmt = $conn->prepare('UPDATE users SET remember_token = NULL WHERE userid = ?')) {
            $stmt->bind_param('s', $userid);

            if ($stmt->execute()) {
                // Log action after successful execution
                log_action($userid, 'Logout', 'User logged out', $conn);

                $response['success'] = true;
                $response['message'] = 'Logged out successfully.';
            } else {
                // If execution fails, log the error
                $response['success'] = false;
                $response['message'] = 'Failed to execute the query: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            // If statement preparation fails, log the error
            $response['success'] = false;
            $response['message'] = 'Failed to prepare the statement: ' . $conn->error;
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'User ID is required.';
    }

    // Output the response as JSON
    echo json_encode($response);
} catch (Exception $e) {
    // Catch any exceptions and log the detailed error
    error_log('Error encountered: ' . $e->getMessage() . $encodedData);
    $response['details'] = $decodedData;
    $response['success'] = false;
    $response['message'] = 'An error occurred: ' . $e->getMessage();
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
