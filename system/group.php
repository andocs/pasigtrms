<?php
if (!hasPermission(3)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}
?>
<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Transport Group Records</li>
    </ol>
    <div class="col-lg-12">
        <div>
            <i class="fas fa-table"></i>
            Transport Groups Record
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#addModal" style="display:<?php echo hasPermission(15) ? 'block' : 'none'; ?>">Add New</button>
        </div><br />
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Group ID</th>
                        <th>Group Name</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT 
                    trans_group.*,
                    GROUP_CONCAT(group_officers.id SEPARATOR ", ") AS officer_ids,
                    GROUP_CONCAT(group_officers.officer_position SEPARATOR ", ") AS officer_positions,
                    GROUP_CONCAT(group_officers.officer_name SEPARATOR ", ") AS officer_names
                    FROM trans_group
                    LEFT JOIN group_officers ON trans_group.id = group_officers.group_id
                    GROUP BY trans_group.id
                    ';
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_assoc($result)) {
                        $groupData = htmlspecialchars(json_encode($row));
                        echo '<tr>';
                        echo '<td>' . $row['group_id'] . '</td>';
                        echo '<td>' . $row['group_name'] . '</td>';
                        echo '<td>';
                        if (hasPermission(3)) {
                            echo '<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#viewModal" data-group="' . $groupData . '">VIEW</button>';
                        }
                        if (hasPermission(16)) {
                            echo '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" data-group="' . $groupData . '">EDIT</button>';
                        }
                        if (hasPermission(17)) {
                            echo '<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="' . htmlspecialchars($row['id']) . '">DELETE</button>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" id="addModalForm" action="trms.php?page=grouptrans&action=add">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Group</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="addTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="add-info-tab" data-toggle="tab" href="#add-info" role="tab" aria-controls="add-info" aria-selected="true">Group Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="add-officers-tab" data-toggle="tab" href="#add-officers" role="tab" aria-controls="add-officers" aria-selected="false">Group Officers</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="addTabContent">
                        <div class="tab-pane active" id="add-info" role="tabpanel" aria-labelledby="add-info-tab">
                            <div class="form-group row justify-content-between mt-3">
                                <?php
                                // Fetch the current year
                                $current_year = date('Y');

                                // Fetch the highest current ID for the current year
                                $query = "
                                    SELECT MAX(CAST(SUBSTRING(group_id, LENGTH('GRP-$current_year-') + 1) AS UNSIGNED)) AS max_id
                                    FROM trans_group
                                    WHERE group_id LIKE 'GRP-$current_year-%'
                                ";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_assoc($result);

                                // Increment the max ID by 1
                                $next_id = isset($row['max_id']) ? $row['max_id'] + 1 : 1;
                                $next_id_padded = str_pad($next_id, 3, '0', STR_PAD_LEFT); // Format the number with leading zeros
                                $prefixed_id = "GRP-$current_year-$next_id_padded"; // Combine year and number
                                ?>
                                <div class="col-6">
                                    <label for="group_id" class="form-label">Group ID</label>
                                    <input class="form-control" name="group_id" value="<?php echo htmlspecialchars($prefixed_id); ?>" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="group_name" class="form-label">Group Name</label>
                                    <input class="form-control" name="group_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="add-officers" role="tabpanel" aria-labelledby="add-officers-tab">
                            <div class="form-group row mt-3">
                                <div class="col-4">
                                    <label class="form-label">Position</label>
                                </div>
                                <div class="col-7">
                                    <label class="form-label">Officer Name</label>
                                </div>
                            </div>
                            <div id="add_officers_info">
                                <div class="form-group row mt-2">
                                    <div class="col-4">
                                        <input class="form-control position-input" name="positions[]" required>
                                    </div>
                                    <div class="col-7">
                                        <input class="form-control officer-input" name="officers[]" required>
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn btn-primary" onclick="addOfficerRow('add')">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Record</button>
                    <button type="reset" class="btn btn-outline-warning">Clear Entry</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" action="trms.php?page=grouptrans&action=edit">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Group</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <ul class="nav nav-tabs" id="editTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="edit-info-tab" data-toggle="tab" href="#edit-info" role="tab" aria-controls="edit-info" aria-selected="true">Group Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="edit-officers-tab" data-toggle="tab" href="#edit-officers" role="tab" aria-controls="edit-officers" aria-selected="false">Group Officers</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="editTabContent">
                        <div class="tab-pane active" id="edit-info" role="tabpanel" aria-labelledby="edit-info-tab">
                            <div class="form-group row justify-content-between  mt-3">
                                <input class="form-control" name="id" id="edit_id" hidden>
                                <div class="col-6">
                                    <label for="edit_group_id" class="form-label">Group ID</label>
                                    <input class="form-control" name="group_id" id="edit_group_id" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="edit_group_name" class="form-label">Group Name</label>
                                    <input class="form-control" name="group_name" id="edit_group_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="edit-officers" role="tabpanel" aria-labelledby="edit-officers-tab">
                            <div class="form-group row mt-3">
                                <div class="col-4">
                                    <label class="form-label">Position</label>
                                </div>
                                <div class="col-7">
                                    <label class="form-label">Officer Name</label>
                                </div>
                            </div>
                            <div id="edit_officers_info"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Group</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="viewTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="view-info-tab" data-toggle="tab" href="#view-info" role="tab" aria-controls="view-info" aria-selected="true">Group Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="view-officers-tab" data-toggle="tab" href="#view-officers" role="tab" aria-controls="view-officers" aria-selected="false">Group Officers</a>
                    </li>
                </ul>
                <div class="tab-content" id="viewTabContent">
                    <div class="tab-pane active" id="view-info" role="tabpanel" aria-labelledby="view-info-tab">
                        <div class="form-group row justify-content-between  mt-3">
                            <div class="col-6">
                                <label for="view_group_id" class="form-label">Group ID</label>
                                <input class="form-control" name="group_id" id="view_group_id" readonly>
                            </div>
                            <div class="col-6">
                                <label for="view_group_name" class="form-label">Group Name</label>
                                <input class="form-control" name="group_name" id="view_group_name" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="view-officers" role="tabpanel" aria-labelledby="view-officers-tab">
                        <div class="form-group row mt-3">
                            <div class="col-4">
                                <label class="form-label">Position</label>
                            </div>
                            <div class="col-7">
                                <label class="form-label">Officer Name</label>
                            </div>
                        </div>
                        <div id="view_officers_info"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Deletion</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, delete it</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(type, groupData) {
        console.log(groupData)
        if (document.getElementById(`${type}_id`)) {
            document.getElementById(`${type}_id`).value = groupData.id;
        }
        document.getElementById(`${type}_group_id`).value = groupData.group_id;
        document.getElementById(`${type}_group_name`).value = groupData.group_name;

        const modalElement = document.getElementById(`${type}Modal`);

        const officerIds = groupData.officer_ids?.split(', ') || [];
        const officerPositions = groupData.officer_positions?.split(', ') || [];
        const officerNames = groupData.officer_names?.split(', ') || [];

        const officerContainer = document.getElementById(`${type}_officers_info`);
        officerContainer.innerHTML = '';

        officerNames.forEach(function(officer, index) {
            var outerDiv = document.createElement('div');
            outerDiv.classList.add('form-group', 'row');

            var officerPositionDiv = document.createElement('div');
            officerPositionDiv.classList.add('col-4');

            if (type === 'view') {
                var positionInput = document.createElement('input');
                positionInput.classList.add('form-control');
                positionInput.value = officerPositions[index];
                positionInput.readOnly = true;
                officerPositionDiv.appendChild(positionInput);

                var officerNameDiv = document.createElement('div');
                officerNameDiv.classList.add('col-8');

                var nameInput = document.createElement('input');
                nameInput.classList.add('form-control');
                nameInput.value = officer;
                nameInput.readOnly = true;

                officerNameDiv.appendChild(nameInput);
                outerDiv.appendChild(officerPositionDiv);
                outerDiv.appendChild(officerNameDiv);
                officerContainer.appendChild(outerDiv);
            }
        });
        if (type === 'edit') {
            addOfficerRow(type, false, officerIds);
        }
    }

    function addOfficerRow(type, isInitial, selectedOfficerIds = []) {
        const officerContainer = document.getElementById(`${type}_officers_info`);

        if (type === 'add') {
            const newRow = document.createElement('div');
            newRow.classList.add('form-group', 'row', 'mt-2');

            const col4 = document.createElement('div');
            col4.classList.add('col-4');

            const newPositionInput = document.createElement('input');
            newPositionInput.classList.add('form-control', 'position-input');
            newPositionInput.name = 'positions[]';
            newPositionInput.required = true;

            col4.appendChild(newPositionInput);

            const col7 = document.createElement('div');
            col7.classList.add('col-7');

            const newNameInput = document.createElement('input');
            newNameInput.classList.add('form-control', 'position-input');
            newNameInput.name = 'officers[]';
            newNameInput.required = true;

            col7.appendChild(newNameInput);

            const col1 = document.createElement('div');
            col1.classList.add('col-1');

            if (isInitial) {
                const addButton = document.createElement('button');
                addButton.type = 'button';
                addButton.classList.add('btn', 'btn-primary', 'officer-button');
                addButton.textContent = '+';
                addButton.onclick = function() {
                    addOfficerRow(type, false);
                };
                col1.appendChild(addButton);
            } else {
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.classList.add('btn', 'btn-danger', 'officer-button');
                deleteButton.textContent = '-';
                deleteButton.onclick = function() {
                    officerContainer.removeChild(newRow);
                };
                col1.appendChild(deleteButton);
            }
            newRow.appendChild(col4);
            newRow.appendChild(col7);
            newRow.appendChild(col1);
            officerContainer.appendChild(newRow);
        } else {
            if (selectedOfficerIds) {
                <?php
                $officer_query = 'SELECT * FROM group_officers';
                $officer_result = mysqli_query($conn, $officer_query) or die(mysqli_error($conn));
                $officers = [];
                while ($officer_row = mysqli_fetch_assoc($officer_result)) {
                    $officers[] = $officer_row;
                }
                ?>
                const allOfficers = <?php echo json_encode($officers); ?>;

                selectedOfficerIds.forEach((id, index) => {
                    const officer = allOfficers.find(o => o.id === id);
                    const newRow = document.createElement('div');
                    newRow.classList.add('form-group', 'row', 'mt-2');

                    const col4 = document.createElement('div');
                    col4.classList.add('col-4');

                    const newPositionInput = document.createElement('input');
                    newPositionInput.classList.add('form-control', 'position-input');
                    newPositionInput.name = 'positions[]';
                    newPositionInput.required = true;
                    newPositionInput.value = officer.officer_position;

                    col4.appendChild(newPositionInput);

                    const col7 = document.createElement('div');
                    col7.classList.add('col-7');

                    const newNameInput = document.createElement('input');
                    newNameInput.classList.add('form-control', 'position-input');
                    newNameInput.name = 'officers[]';
                    newNameInput.required = true;
                    newNameInput.value = officer.officer_name;

                    col7.appendChild(newNameInput);

                    const col1 = document.createElement('div');
                    col1.classList.add('col-1');

                    if (index === 0) {
                        const addButton = document.createElement('button');
                        addButton.type = 'button';
                        addButton.classList.add('btn', 'btn-primary', 'officer-button');
                        addButton.textContent = '+';
                        addButton.onclick = function() {
                            addOfficerRow(type, false, null);
                        };
                        col1.appendChild(addButton);
                    } else {
                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.classList.add('btn', 'btn-danger', 'officer-button');
                        deleteButton.textContent = '-';
                        deleteButton.onclick = function() {
                            officerContainer.removeChild(newRow);
                        };
                        col1.appendChild(deleteButton);
                    }
                    newRow.appendChild(col4);
                    newRow.appendChild(col7);
                    newRow.appendChild(col1);
                    officerContainer.appendChild(newRow);

                })
            } else {
                const newRow = document.createElement('div');
                newRow.classList.add('form-group', 'row', 'mt-2');

                const col4 = document.createElement('div');
                col4.classList.add('col-4');

                const newPositionInput = document.createElement('input');
                newPositionInput.classList.add('form-control', 'position-input');
                newPositionInput.name = 'positions[]';
                newPositionInput.required = true;

                col4.appendChild(newPositionInput);

                const col7 = document.createElement('div');
                col7.classList.add('col-7');

                const newNameInput = document.createElement('input');
                newNameInput.classList.add('form-control', 'position-input');
                newNameInput.name = 'officers[]';
                newNameInput.required = true;

                col7.appendChild(newNameInput);

                const col1 = document.createElement('div');
                col1.classList.add('col-1');

                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.classList.add('btn', 'btn-danger', 'officer-button');
                deleteButton.textContent = '-';
                deleteButton.onclick = function() {
                    officerContainer.removeChild(newRow);
                };
                col1.appendChild(deleteButton);

                newRow.appendChild(col4);
                newRow.appendChild(col7);
                newRow.appendChild(col1);
                officerContainer.appendChild(newRow);

            }

        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var dataTable = document.getElementById('dataTable');
        dataTable.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-info') || event.target.classList.contains('btn-warning')) {
                var groupData = JSON.parse(event.target.getAttribute('data-group'));
                var type = event.target.classList.contains('btn-info') ? 'view' : 'edit';
                showModal(type, groupData);
            } else if (event.target.classList.contains('btn-danger')) {
                var id = event.target.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', id);
            }
        });

        var confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            window.location.href = 'trms.php?page=grouptrans&action=delete&id=' + id;
        });
    });
</script>