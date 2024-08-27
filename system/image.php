<?php

// Path to the image in the root directory
$imagePath = '../uploads/'; // Adjust the path accordingly

// Check if the file exists
if (file_exists($imagePath)) {
    // Set the appropriate header for an image
    header('Content-Type: image/jpeg');
    // Output the image content
    readfile($imagePath);
} else {
    // Image not found, output a placeholder image or handle the error
    header("HTTP/1.0 404 Not Found");
    // Output a placeholder image
    readfile('../uploads/default.jpg'); // Adjust the path and the default image accordingly
}
?>