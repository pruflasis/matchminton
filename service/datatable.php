<?php

require_once 'config.php';
 
// DB table to use
$table = 'orders'.'user';
 
// Table's primary key
$primaryKey = 'order_id'.'user_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names
$columns = array(
    array( 'db' => 'order_id', 'dt' => '0' ),
    array( 'db' => 'name'.'surname',  'dt' => '1' ),
    array( 'db' => 'position',   'dt' => '2' ),
    array( 'db' => 'payment_status',     'dt' => '3' ),
    array( 'db' => 'total_price', 'dt' => '4' ),
);
 
// SQL server connection information
$sql_details = $conn;
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
);