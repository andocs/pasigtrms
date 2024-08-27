<?php
if (!hasPermission(4)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br/>
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Audit Logs</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Audit Logs
        </div><br />
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT audit_log.id, audit_log.userid, users.name, audit_log.action, audit_log.description, audit_log.timestamp 
                    FROM audit_log 
                    INNER JOIN users ON audit_log.userid = users.userid";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["userid"]); ?></td>
                            <td><?php echo htmlspecialchars($row["name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["action"]); ?></td>
                            <td><?php echo htmlspecialchars($row["description"]); ?></td>
                            <td><?php echo htmlspecialchars($row["timestamp"]); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>