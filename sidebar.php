<?php
ob_start();
?>

<div class="d-flex flex-column justify-content-between bg-white">
    <ul class="sidebar navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="trms.php?page=homepage">
                <i class="fas fa-fw fa-home"></i>
                <span>HOMEPAGE</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="driverDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display:<?php echo hasPermission(2) ? 'block' : 'none'; ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>PUV Information</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="driverDropdown">
                <a class="dropdown-item" href="trms.php?page=operatordash" style="display:<?php echo hasPermission(1) ? 'block' : 'none'; ?>">PUV Dashboard</a>
                <a class="dropdown-item" href="trms.php?page=vehicle">PUV Vehicle Unit</a>
                <a class="dropdown-item" href="trms.php?page=operator">PUV Operator</a>
                <a class="dropdown-item" href="trms.php?page=driver">PUV Driver</a>
                <a class="dropdown-item" href="trms.php?page=cases" style="display:<?php echo hasPermission(40) ? 'block' : 'none'; ?>">PUV Cases</a>
                <a class="dropdown-item" href="trms.php?page=vtype" style="display:<?php echo hasPermission(41) ? 'block' : 'none'; ?>">PUV Type</a>
                </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="driverDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display:<?php echo hasPermission(3) ? 'block' : 'none'; ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>Public Transport</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="driverDropdown">
                <a class="dropdown-item" href="trms.php?page=transportdash" style="display:<?php echo hasPermission(1) ? 'block' : 'none'; ?>">Transport Dashboard</a>
                <a class="dropdown-item" href="trms.php?page=group">Transport Group</a>
                <a class="dropdown-item" href="trms.php?page=terminal">Transport Terminal</a>
                <a class="dropdown-item" href="trms.php?page=route">Transport Route</a>
                <a class="dropdown-item" href="trms.php?page=insp" style="display:<?php echo hasPermission(42) ? 'block' : 'none'; ?>">Inspection Clearance</a>
                <a class="dropdown-item" href="trms.php?page=reso" style="display:<?php echo hasPermission(43) ? 'block' : 'none'; ?>">Resolutions</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-cog"></i>
                <span>Settings</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="settingsDropdown">
                <a class="dropdown-item" href="trms.php?page=audit_log" style="display:<?php echo hasPermission(4) ? 'block' : 'none'; ?>">Audit Trail Logs</a>
                <a class="dropdown-item" href="trms.php?page=user" style="display:<?php echo hasPermission(5) ? 'block' : 'none'; ?>">Users Accounts</a>
                <a class="dropdown-item" href="trms.php?page=roleaccess" style="display:<?php echo hasPermission(6) ? 'block' : 'none'; ?>">Role Access</a>
                <a class="dropdown-item" href="trms.php?page=reports" style="display:<?php echo hasPermission(7) ? 'block' : 'none'; ?>">Reports</a>
                <!-- <a class="dropdown-item" href="trms.php?page=signatory" style="display:
                 ">Signatory</a> -->
                <a class="dropdown-item" href="trms.php?page=carousel" style="display:<?php echo hasPermission(10) ? 'block' : 'none'; ?>">Manage Carousel</a>
            </div>
        </li>
        <li class="nav-item" style="display:<?php echo hasPermission(9) ? 'block' : 'none'; ?>">
            <a class="nav-link" href="trms.php?page=about">
                <i class="fas fa  fa-info-circle"></i>
                <span>About</span></a>
        </li>
    </ul>
    <footer class="sticky-footer">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright © <a href="https://www.pasigcity.gov.ph/">Pasig City</a> 2024</span>
            </div>
        </div>
    </footer>
</div>