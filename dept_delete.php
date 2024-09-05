<?php 
include('connect.php');
$department_id = $_GET['department_id'];
$delete_query = "DELETE FROM department WHERE department_id = $department_id";

$result_query = pg_query($conn,$delete_query);
if(!$result_query){
    die("There is an error" . pg_last_error($conn));
}
header("Location:manage_dept.php");               

?>
