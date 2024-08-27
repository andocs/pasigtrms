<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Officer Records</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Transport Officer Record
            <a href="trms.php?page=officeradd" type="button" class="btn btn-xs btn-info">Add New</a>
        </div>
        <br/>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Officer ID</th>
                        <th>Officer Name</th>
                        <th>Officer Position</th>
                        <th>Officer Contact</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT * FROM group_officers';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['officer_id'] . '</td>';
                        echo '<td>' . $row['officer_name'] . '</td>';
                        echo '<td>' . $row['officer_position'] . '</td>';
                        echo '<td>' . $row['officer_contact'] . '</td>';
                        echo '<td>
                            <a type="button" class="btn btn-xs btn-info" href="trms.php?page=officerview&id=' . $row['officer_id'] . '">VIEW</a>
                            <a type="button" class="btn btn-xs btn-warning" href="trms.php?page=officeredit&id=' . $row['officer_id'] . '">EDIT</a>
                            <a type="button" class="btn btn-xs btn-danger" href="trms.php?page=officerdel&id=' . $row['officer_id'] . '">DELETE</a>
                            </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>