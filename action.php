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
$params = array(); $params = $_REQUEST;

$user_result = mysqli_query($mysqli, "SELECT `name`, `email` FROM users ORDER BY ".$columns[$params['order'][0]['column']]." ".$params['order'][0]['dir']." LIMIT ".$params['length']."");

$recordsTotal = mysqli_num_rows(mysqli_query($mysqli, "SELECT `name`, `email` FROM users"));
$recordsFiltered = mysqli_num_rows(mysqli_query($mysqli, "SELECT `name`, `email` FROM users"));

## if data found set array for response
if (mysqli_num_rows($user_result) > 0) {
    while ($user_data = mysqli_fetch_row($user_result)) {
        $data[] = $user_data;
    }
}

$json = array(
    "draw" => intval($params['draw']),
    "recordsTotal" => intval($recordsTotal),
    "recordsFiltered" => intval($recordsFiltered),
    "data" => $data
);

echo json_encode($json);



?>