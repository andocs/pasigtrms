<?php
require 'phpqrcode/qrlib.php';

function generateRandomControlNumber() {
    // Generate a random number and format it as needed
    return 'CN' . strtoupper(uniqid());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleData = json_decode(file_get_contents('php://input'), true);

    if ($vehicleData) {
        // Generate a random control number
        $controlNo = generateRandomControlNumber();

        $data = "Operator's Name: " . $vehicleData['optr_name'] . "\n" .
                "Address: " . $vehicleData['terminal_add'] . "\n" .
                "Case No.: " . $vehicleData['case_no'] . "\n" .
                "Plate No. & Engine No.: " . $vehicleData['plate_no'] . " & " . $vehicleData['engine_no'] . "\n" .
                "Chassis No.: " . $vehicleData['chassis_no'] . "\n" .
                "Route Name: " . $vehicleData['route_line'] . "\n" .
                "Control No.: " . $controlNo;

        $filename = 'uploads/qrcodes/' . $vehicleData['plate_no'] . '.png';
        QRcode::png($data, $filename, QR_ECLEVEL_L, 3);

        // Return the path to the generated QR code image and the control number
        echo json_encode(['qrCodeUrl' => $filename]);
    } else {
        echo json_encode(['error' => 'Invalid data']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
