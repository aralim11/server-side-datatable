<?php 
## database connection
$mysqli = new mysqli("localhost", "root", "", "hrm_db_ihelp_2022");

## Check connection
if ($mysqli->connect_errno) {
    echo json_encode("Failed to connect to MySQL");
    exit();
}

## define table name
$table = "users";

## define columns
$columns = array(
    0 => "name",
    1 => "email",
    2 => "status",
);

## request with parameters, define variables
$params = array(); $params = $_REQUEST; $where = "";
$recordsTotal = $recordsFiltered = 0;

## define conditions
if (!empty($params['search']['value'])) {
    $where = " WHERE `name` LIKE '%".$params['search']['value']."%' OR `email` LIKE '%".$params['search']['value']."%'";
}

## convert column array to select value
$select = implode("`, `", $columns);

## fetch data
$user_result = mysqli_query($mysqli, "SELECT `".$select."` FROM ".$table." ".$where." ORDER BY ".$columns[$params['order'][0]['column']]." ".$params['order'][0]['dir']." LIMIT ".$params['start'].",".$params['length']."");

## if data found set array for response
$json_data = array();
if (mysqli_num_rows($user_result) > 0) {

    ## total count for recordsTotal & recordsFiltered
    $tot_sql = mysqli_query($mysqli, "SELECT * FROM ".$table." ".$where."");
    $recordsTotal = mysqli_num_rows($tot_sql);
    $recordsFiltered = mysqli_num_rows($tot_sql);

    ## fetch data for response
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