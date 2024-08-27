<?php
include_once 'includes/db_connection.php';
include_once 'includes/functions.php';
$type = $_GET['type'];

switch ($type) {
    case 'operator':
        $query = 'SELECT operator.*, 
        residency.id as resi_id,
        residency.resi_code 
        FROM operator 
        JOIN residency ON operator.resi_id = residency.id';
        $headers = ['Operator ID', 'Residency', 'Operator Name', 'Operator Address', 'Operator Contact'];
        $columns = ['optr_id', 'resi_code', 'optr_name', 'optr_add', 'optr_contact'];
        break;
    case 'driver':
        $query = 'SELECT driver.*, 
            residency.id AS resi_id,
            residency.resi_code 
            FROM driver 
            JOIN residency ON driver.resi_id = residency.id';
        $headers = ['Driver ID', 'Driver Name', 'Driver Address', 'Driver Contact', 'Residency'];
        $columns = ['driver_id', 'driver_name', 'driver_address', 'driver_contact', 'resi_code'];
        break;
    case 'vehicle_unit':
        $query = 'SELECT 
            vehicle_unit.*,
            unit_type.vtype_id,
            unit_type.modal_name,
            route.id AS route_id,
            route.route_line,
            terminal.id AS terminal_id
        FROM vehicle_unit
        LEFT JOIN unit_type ON vehicle_unit.vtype_id = unit_type.vtype_id
        LEFT JOIN terminal ON vehicle_unit.terminal_id = terminal.id
        LEFT JOIN route ON terminal.route_id = route.id
        GROUP BY vehicle_unit.id';
        $headers = ['Created At', 'Plate Number', 'Vehicle Type', 'Route Line'];
        $columns = ['created_at', 'plate_no', 'modal_name', 'route_line'];
        break;
    case 'trans_group':
        $query = 'SELECT * FROM trans_group';
        $headers = ['Group ID', 'Group Name'];
        $columns = ['group_id', 'group_name'];
        break;
    case 'terminal':
        $query = 'SELECT 
            terminal.*, 
            route.route_line, 
            term_approval.reso_name, 
            trans_group.group_name
        FROM terminal
        LEFT JOIN route ON terminal.route_id = route.id
        LEFT JOIN term_approval ON terminal.reso_id = term_approval.id
        LEFT JOIN trans_group ON terminal.group_id = trans_group.id';
        $headers = ['Terminal ID', 'Terminal Name', 'Terminal Address', 'Route Line', 'Resolution Name', 'Group Name'];
        $columns = ['terminal_id', 'terminal_name', 'terminal_add', 'route_line', 'reso_name', 'group_name'];
        break;
    case 'route':
        $query = 'SELECT * FROM route';
        $headers = ['Route ID', 'Route Line', 'Route Struct', 'Route Modify'];
        $columns = ['route_id', 'route_line', 'route_struct', 'route_modify'];
        break;
    case 'insp_clearance':
        $query = 'SELECT 
                insp_clearance.*, 
                terminal.id AS terminal_id, 
                terminal.terminal_name,
                terminal.terminal_add,
                route.id AS route_id,
                route.route_line,
                term_approval.id AS reso_id,
                term_approval.reso_name,
                trans_group.id AS group_id,
                trans_group.group_name,
                COUNT(vehicle_unit.id) AS total_vehicle_units
            FROM insp_clearance
            JOIN terminal ON insp_clearance.terminal_id = terminal.id
            JOIN route ON terminal.route_id = route.id
            JOIN term_approval ON terminal.reso_id = term_approval.id
            JOIN trans_group ON terminal.group_id = trans_group.id
            LEFT JOIN vehicle_unit ON terminal.id = vehicle_unit.terminal_id';
        $headers = hasPermission(34) ? ['Clearance ID', 'Terminal Name', 'Terminal Address', 'Route Line', 'Options'] : ['Clearance ID', 'Terminal Name', 'Terminal Address', 'Route Line'];
        $columns = ['insp_id', 'terminal_name', 'terminal_add', 'route_line'];
        break;
    case 'terminal-vehicles':
        $query = 'SELECT 
                vehicle_unit.*, 
                terminal.id AS terminal_id, 
                terminal.terminal_name,
                terminal.terminal_add,
                route.id AS route_id,
                route.route_line,
                trans_group.id AS group_id,
                trans_group.group_name,
                vehicle_driver.veh_id,
                vehicle_driver.driver_id,
                cases.id AS case_id,
                GROUP_CONCAT(vehicle_unit.id SEPARATOR ", ") AS vehicle_ids,
                GROUP_CONCAT(cases.case_no SEPARATOR ", ") AS case_nos,
                GROUP_CONCAT(vehicle_unit.plate_no SEPARATOR ", ") AS plate_nos,
                GROUP_CONCAT(vehicle_driver.driver_id SEPARATOR ", ") AS driver_ids,
                GROUP_CONCAT(driver.driver_name SEPARATOR ", ") AS driver_names
            FROM vehicle_unit
            JOIN cases ON vehicle_unit.case_id = cases.id
            JOIN terminal ON vehicle_unit.terminal_id = terminal.id
            JOIN route ON terminal.route_id = route.id
            JOIN trans_group ON vehicle_unit.group_id = trans_group.id
            LEFT JOIN vehicle_driver ON vehicle_unit.id = vehicle_driver.veh_id
            LEFT JOIN driver ON vehicle_driver.driver_id = driver.id
            GROUP BY terminal.id
                ';
        $headers = hasPermission(34) ? ['Terminal Name', 'Terminal Address', 'Route Line', 'Options'] : ['Terminal Name', 'Terminal Address', 'Route Line'];
        $columns = ['terminal_name', 'terminal_add', 'route_line'];
        break;
    default:
        exit('Invalid type');
}

$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

echo '<table class="table table-bordered" id="dataTable_' . htmlspecialchars($type) . '" width="100%" cellspacing="0">';
echo '<thead><tr>';
foreach ($headers as $header) {
    echo '<th>' . htmlspecialchars($header) . '</th>';
}
echo '</tr></thead><tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    foreach ($columns as $column) {
        echo '<td>' . htmlspecialchars($row[$column]) . '</td>';
    }
    if ($type == 'insp_clearance' && hasPermission(34)) {
        echo '<td><button class="btn btn-primary" data-toggle="modal" data-target="#confirmationModal" data-clearance="' . htmlspecialchars(json_encode($row)) . '">Print</button></td>';
    }
    if ($type == 'terminal-vehicles' && hasPermission(34)) {
        echo '<td><button class="btn btn-primary" onclick="printVehicleList(' . htmlspecialchars(json_encode($row)) . ')">Print</button></td>';
    }
    echo '</tr>';
}

echo '</tbody></table>';

$conn->close();
