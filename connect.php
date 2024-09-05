<?php
$host = 'localhost'; 
$port = '5432'; 
$dbname = 'training_module_db'; 
$user = 'postgres'; 
$password = 'admin'; 
$conn_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$conn = pg_connect($conn_string);
if (!$conn) {
    echo "Failed to connect to PostgreSQL database.";
    exit;
}

?>
