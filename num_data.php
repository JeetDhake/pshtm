<?php
include('connect.php');

    $numberer = pg_escape_string($_POST['numberer']);
    $input_type = $_POST['input_type'];

    $training_program_id = $_POST['training_program_id'];

    $insert = pg_query($conn, "INSERT INTO questions (que_text, training_program_id, ques_type) VALUES ( '$numberer','$training_program_id', '$input_type')");

?>