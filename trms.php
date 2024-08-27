<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/functions.php';
if (!isUserLoggedIn()) {
    redirectTo('', '', 'index.php');
}

$homepage_pages = ['homepage', 'about', 'unauthorized'];
$profile_pages = ['profile', 'profiletrans'];
$operator_pages = ['operatordash', 'operator', 'operatortrans'];
$driver_pages = ['transportdash', 'driver', 'drivertrans'];
$vehicle_pages = ['vehicle', 'vehicletrans'];
$officer_pages = ['officer', 'officertrans'];
$group_pages = ['group', 'grouptrans'];
$terminal_pages = ['terminal', 'terminaltrans'];
$route_pages = ['route', 'routetrans'];
$case_pages = ['cases', 'casestrans'];
$vtype_pages = ['vtype', 'vtypetrans'];
$insp_pages = ['insp', 'insptrans'];
$reso_pages = ['reso', 'resotrans'];
$settings_pages = ['audit_log', 'user', 'usertrans', 'roleaccess', 'roleaccesstrans', 'reports', 'signatory', 'carousel'];
$tables = ['load_table'];

$allowed_pages = array_merge(
    $homepage_pages,
    $profile_pages,
    $operator_pages,
    $driver_pages,
    $vehicle_pages,
    $officer_pages,
    $group_pages,
    $terminal_pages,
    $route_pages,
    $case_pages,
    $vtype_pages,
    $insp_pages,
    $reso_pages,
    $settings_pages,
    $tables
);

$page = $_GET['page'] ?? 'homepage';
$page_file = $page . '.php';

$pageTitles = [
    'homepage' => 'Dashboard',
    'about' => 'About Us',
    'unauthorized' => 'Unauthorized Access',
    'profile' => 'User Profile',
    'profiletrans' => 'Profile Transactions',
    'operatordash' => 'Operator Dashboard',
    'operator' => 'Operator Information',
    'operatortrans' => 'Operator Transactions',
    'transportdash' => 'Transport Dashboard',
    'driver' => 'Driver Information',
    'drivertrans' => 'Driver Transactions',
    'vehicle' => 'Vehicle Information',
    'vehicletrans' => 'Vehicle Transactions',
    'officer' => 'Officer Information',
    'officertrans' => 'Officer Transactions',
    'group' => 'Group Information',
    'grouptrans' => 'Group Transactions',
    'terminal' => 'Terminal Information',
    'terminaltrans' => 'Terminal Transactions',
    'route' => 'Route Information',
    'routetrans' => 'Route Transactions',
    'audit_log' => 'Audit Log',
    'user' => 'User Management',
    'usertrans' => 'User Transactions',
    'roleaccess' => 'Role Access',
    'roleaccesstrans' => 'Role Access Transactions',
    'reports' => 'Reports',
    'signatory' => 'Signatory Information',
    'load_table' => 'Load Table',
    'carousel' => 'Manage Carousel',
    'cases' => 'Cases',
    'vtype' => 'Vehicle Type',
    'insp' => 'Inspection Clearance',
    'reso' => 'Resolution',
];

$pageTitle = $pageTitles[$page] ?? 'Pasig TRMS';
require 'includes/header.php';

?>

<body id="page-top">
    <div class="container-fluid p-0">
        <?php require_once 'topnav.php'; ?>
    </div>
    <div id="wrapper" class="container-fluid p-0">
        <?php require_once 'sidebar.php'; ?>
        <div id="content-wrapper" class="position-relative">
            <div id="toast" class="toast align-items-center position-absolute top-0 end-0 w-auto px-1 m-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div id="toast-body" class="toast-body">
                    </div>
                    <button type="button" class="btn-close p-2 m-auto btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <?php
            $file_path = 'system/' . $page_file;
            if (file_exists($file_path) && isPage($page, $allowed_pages)) {
                require $file_path;
            } else {
                require 'system/404.php';
            }
            require_once 'includes/footer.php';
            ?>
        </div>
    </div>
</body>

<script>
    let idleTime = 0;

    function resetIdleTime() {
        idleTime = 0;
    }

    function checkIdleTime() {
        idleTime++;
        if (idleTime >= 15 * 60) {
            alert('You have been logged out due to inactivity.')
            window.location.href = 'logout.php';
        }
    }

    // Increment the idle time counter every second
    setInterval(checkIdleTime, 1000);

    // Reset the idle time counter on mouse movement, key press, and scroll
    window.onmousemove = resetIdleTime;
    window.onkeypress = resetIdleTime;
    window.onscroll = resetIdleTime;
</script>