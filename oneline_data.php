<?php
include('connect.php');

    $oneliner = pg_escape_string($_POST['oneliner']);
    $input_type = $_POST['input_type'];

    $training_program_id = $_POST['training_program_id'];

    $insert = pg_query($conn, "INSERT INTO questions (que_text, training_program_id, ques_type) VALUES ( '$oneliner','$training_program_id', '$input_type')");
?>