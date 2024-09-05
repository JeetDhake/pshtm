<?php 
include('connect.php');
$job_post_id = $_GET['job_post_id'];
$delete_query = "DELETE FROM job_post
                 WHERE job_post_id = $job_post_id";

$result_query = pg_query($conn,$delete_query);
if(!$result_query){
    die("There is an error" . pg_last_error($conn));
}
header("Location:manage_job.php");               

?>
