<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'session.php';
require_once 'db_connection.php';

ob_start();

$user = ['userid' => '', 'name' => '', 'username' => '', 'email' => '', 'role' => '', 'picture' => ''];

if (isset($_GET['userid'])) {
    $id = $_GET['userid'];
    $query = "SELECT * FROM users WHERE userid = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        die('User not found.');
    }
}

if (isset($_POST['submit'])) {
    $id = $_POST['userid'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $picture = $user['picture'];

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $picture = 'uploads/' . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
    }

    $query = "UPDATE users SET name = '$name', username = '$username', email = '$email', role = '$role', picture = '$picture' WHERE userid = $id";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    
    header('Location: role.php?edited=true');
    exit();
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title> Users Role</title>
    <!-- Google Map -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS -->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>
<body id="page-top">
    <?php require_once 'topnav.php'; ?>
    <div id="wrapper">
        <?php require_once 'sidebar.php'; ?>
        <div id="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumbs -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="homepage.php">
                            <h2>Transportation and Regulatory Management System</h2>
                        </a>
                    </li>           
                </ol>

                <div class="card-body">
                    <div class="container">
                        <div class="card card-register mx-auto mt-5">
                            <div class="card-header">
                                <div class="card-body">
                                    <h2>Edit Users Record</h2>
                                </div>
                                <form role="form" action="role_edit.php?userid=<?php echo $user['userid']; ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="userid" value="<?php echo $user['userid']; ?>">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
                                    <label for="username">Username:</label>
                                    <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
                                    <label for="role">Role:</label>
                                    <input type="text" name="role" value="<?php echo $user['role']; ?>" required><br>
                                    <label for="picture">Picture:</label>
                                    <input type="file" name="picture" accept="image/*"><br>
                                    <button type="submit" name="submit">Update User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
            <script src="vendor/datatables/jquery.dataTables.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
            <script src="js/sb-admin.min.js"></script>
            <script src="js/demo/datatables-demo.js"></script>
            <script src="js/demo/chart-area-demo.js"></script>            
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
