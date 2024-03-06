<?php
include('connect.php');

    $mcqer = $_POST['mcqer'];
    $input_type = $_POST['input_type'];

    $opt1 = $_POST['opt1'];
    $opt2 = $_POST['opt2'];
    $opt3 = $_POST['opt3'];
    $opt4 = $_POST['opt4'];    

    $training_program_id = $_POST['training_program_id'];

    $insert = pg_query($conn, "INSERT INTO questions (que_text, training_program_id, ques_type) VALUES ( '$mcqer','$training_program_id', '$input_type')");

    $getset = pg_query($conn, " SELECT ques_id FROM questions ORDER BY ques_id DESC LIMIT 1;");
    while ($row = pg_fetch_assoc($getset)) {
    $x_id = $row["ques_id"];
    $insertx = pg_query($conn, "INSERT INTO mcq_options (ques_id, option_1, option_2, option_3, option_4) VALUES ( '$x_id', '$opt1', '$opt2', '$opt3', '$opt4');");
    }
?>