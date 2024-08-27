<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Manila');

require_once 'db_connection.php';
require_once 'topnav.php';


ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.html');
    exit;
}
$result = $conn->query('SELECT a.id, u.username, a.action, a.details, a.timestamp FROM audit_trail a JOIN users u ON a.user_id = u.userid ORDER BY a.timestamp DESC');

ob_end_flush();
?>
    <h1>Audit Trail</h1>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Action</th>
                        <th>Details</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                    <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['userid']) ?></td>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><?= htmlspecialchars($row['action']) ?></td>
                                    <td><?= htmlspecialchars($row['details']) ?></td>
                                    <td><?= htmlspecialchars($row['timestamp']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                    </tbody>
        </table>
    </div>
<?php require_once 'footer.php'; ?>
