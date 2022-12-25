<?php 
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'root', 
    'pass' => '', 
    'db'   => 'hrm_db_ihelp_2022' 
); 
 
// DB table to use 
$table = 'users'; 
 
// Table's primary key 
$primaryKey = 'id'; 
 
## $row single row return from database. 
## The `db` parameter represents the column name in the database.  
## The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array('db' => 'name', 'dt' => 0), 
    array('db' => 'email',  'dt' => 1), 
    array( 
        'db' => 'status', 
        'dt' => 2, 
        'formatter' => function( $d, $row) { 
            return ($d == 1) ? 'Active' : 'Inactive'; 
        } 
    ) 
); 
 
## Include SQL query processing class 
require 'ssp.class.php'; 
 
## Output data as json format 
echo json_encode( 
    SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns) 
);