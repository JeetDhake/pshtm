<?php
session_start();
include_once "connect.php";

if (isset($_GET['emp_id'])) {
    $emp_id = $_GET['emp_id'];
    $status = "false"; 
    $sql2 = pg_query($conn, "UPDATE employee_records SET emp_status = '$status' WHERE emp_id = $emp_id"); 

    if (!$sql2) {
        echo "<script>alert('Deactivation is not successful: " . pg_last_error($conn) . "');</script>";
    } else {
        echo "<script>alert('Deactivated Successfully');</script>";
        
    }
} else {
    echo "Error Deactivating";
}
header("location: profile.php?emp_id=$emp_id");

?>