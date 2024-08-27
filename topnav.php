<?php

$userId = $_SESSION['userid'];
$name = '';
$role_id = '';
$role_name = '';
$picture = '';
$query = "
    SELECT users.name, users.picture, roles.role_id, roles.role_name 
    FROM users 
    LEFT JOIN roles ON users.role = roles.role_id 
    WHERE users.userid = ?
";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $picture, $role_id, $role_name);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "No data found for user ID: $userId";
    }
} else {
    echo "Failed to prepare the SQL statement.";
}
?>

<nav class="navbar navbar-expand navbar-dark static-top" style="background-color: #05269E">
    <a class="navbar-brand mr-1" href="trms.php?page=homepage">
        <img src="uploads/pasig.jpg" alt="User Image" style="width:35px; height:35px; border-radius:50%; margin-right:10px;">TRMS
    </a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></form>
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo htmlspecialchars($name) . " " . htmlspecialchars($role_name); ?>
                <?php if (!empty($picture)) { ?>
                    <img src="<?php echo htmlspecialchars($picture); ?>" alt="User Image" style="width: 35px; height: 35px; border-radius: 50%; margin-right: 10px; object-fit: cover">
                <?php } ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <?php if (!isUserLoggedIn()) { ?>
                    <a class="dropdown-item" href="index.html">Register</a>
                    <a class="dropdown-item" href="index.html">Sign in</a>
                <?php } ?>
                <a class="dropdown-item" href="trms.php?page=profile">Profile</a>
                <a class="dropdown-item" href="logout.php" data-target="#logoutModal">Logout</a>
            </div>
        </li>
    </ul>
</nav>