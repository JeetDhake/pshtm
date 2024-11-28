<?php
include('connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tr_id = $_POST['tr_id'];
    $status = $_POST['status'];
    $xm = $_POST['xm'];

    if($xm == "pre"){
        $query1 = "UPDATE create_training_programs SET pre_status = '$status' WHERE training_program_id = $tr_id";
    
        $result1 = pg_query($conn, $query1);

        if($result1){
            echo "success";
        }
        else{
            echo "fail";
        }
    }
    if($xm == "post"){
        $query1 = "UPDATE create_training_programs SET post_status = '$status' WHERE training_program_id = $tr_id";
    
        $result1 = pg_query($conn, $query1);

        if($result1){
            echo "success";
        }
        else{
            echo "fail";
        }
    }
    
}
    
?>
