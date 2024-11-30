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

// error_reporting(E_ALL);
// ini_set("display_errors", 0);

// function errorHandler($errno, $errstr, $errfile, $errline){
//     $message = "Error: [$errno] $errstr - $errfile:$errline";
//     error_log($message . PHP_EOL, 3, "error_log.txt");
// }

// set_exception_handler("errorHandler");
?>
