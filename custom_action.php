<?php 
## database connection
$mysqli = new mysqli("localhost", "root", "", "hrm_db_ihelp_2022");

## Check connection
if ($mysqli->connect_errno) {
    echo json_encode("Failed to connect to MySQL");
    exit();
}

## define columns
$columns = array(
    0 => "name",
    1 => "email",
);

## request with parameters
$params = array(); $params = $_REQUEST; $where = "";

## define conditions
if (!empty($params['search']['value'])) {
    $where = " WHERE `name` LIKE '%".$params['search']['value']."%' OR `email` LIKE '%".$params['search']['value']."%'";
}

## fetch data
$user_result = mysqli_query($mysqli, "SELECT `name`, `email`, `status` FROM users ".$where." ORDER BY ".$columns[$params['order'][0]['column']]." ".$params['order'][0]['dir']." LIMIT ".$params['start'].",".$params['length']."");

$recordsTotal = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM users ".$where.""));
$recordsFiltered = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM users ".$where.""));

## if data found set array for response
if (mysqli_num_rows($user_result) > 0) {
    while ($user_data = mysqli_fetch_row($user_result)) {
        $data = array();
        $data[] = $user_data[0];
        $data[] = $user_data[1];
        $data[] = $user_data[2] == 1 ? 'Active' : 'Inactive';
        $json_data[] = $data;
    }
}

## return data to view
echo json_encode(array(
    "draw" => intval($params['draw']),
    "recordsTotal" => intval($recordsTotal),
    "recordsFiltered" => intval($recordsFiltered),
    "data" => $json_data
));

?>