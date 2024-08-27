<?php
// HEADER.PHP - reusable //

//base url of website, change if hosted online.
define('BASE_URL', 'http://localhost/pasigtrms/');

require_once 'db_connection.php';
require_once 'functions.php';

header('Content-Type: text/html; charset=utf-8');

date_default_timezone_set('Asia/Manila');

//variable for different page titles
$pageTitle = $pageTitle ?? 'Pasig TRMS';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>    
    <link href="css/styles.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" >
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/b-3.1.0/b-colvis-3.1.0/b-html5-3.1.0/b-print-3.1.0/datatables.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

</head>
