<?php
session_start();
include('connect.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['import'])) {
    $file_name = $_FILES['import_file']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $valid_ext = ['csv', 'xls', 'xlsx'];

    if (in_array($file_ext, $valid_ext)) {
        try {

            $inputFileNamePath = $_FILES['import_file']['tmp_name'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);

            $data = $spreadsheet->getActiveSheet()->toArray();
            $msg = false;
            $count = 0;
            pg_query($conn, "BEGIN");
            foreach ($data as $row) {
                if ($count > 0) {

                    $training_program_id = intval($row['0']);
                    $name = pg_escape_string($row['1']);
                    $training_desc = pg_escape_string($row['2']);

                    $question_text = pg_escape_string($row['3']);
                    $answer = pg_escape_string($row['4']);
                    $option_1 = pg_escape_string($row['5']);
                    $option_2 = pg_escape_string($row['6']);
                    $option_4 = pg_escape_string($row['7']);
                    $option_3 = pg_escape_string($row['8']);

                    $type = "mcq";
                    $status = "true";

                    if (empty($training_program_id) || empty($name) || empty($training_desc) || empty($question_text) || empty($answer) || empty($option_1) || empty($option_2) || empty($option_3) || empty($option_4)) {

                        pg_query($conn, "ROLLBACK");
                        $_SESSION['message'] = "Import Failed: empty values";
                        header('location: import_tr.php');
                        exit(0);
                    }
                    // $check = "SELECT * FROM create_training_programs WHERE training_program_id = $training_program_id";
                    // $result_check = pg_query($conn, $check);
                    // if (pg_num_rows($result_check) > 0) {

                    //     pg_query($conn, "ROLLBACK");
                    //     $_SESSION['message'] = "Import Failed: Id exists";
                    //     header('location: import_tr.php');
                    //     exit(0);
                    // }

                    $insert_1 = "INSERT INTO create_training_programs (training_program_id, name, training_desc, training_status) VALUES ($1, $2, $3, $4)";
                    $result_1 = pg_query_params($conn, $insert_1, [$training_program_id, $name, $training_desc, $status]);

                    $insert_2 = "INSERT INTO questions (que_text, training_program_id, ques_type, answer, option_1, option_2, option_3, option_4) 
                    VALUES ( '$question_text','$training_program_id', '$type', '$answer', '$option_1', '$option_2', '$option_3', '$option_4')";
                    $result_2 = pg_query($conn, $insert_2);

                    if (!$result_1 || !$result_2) {
                        throw new Exception('Database insertion failed: ' . pg_last_error($conn));
                    }
                    $msg = true;
                } else {
                    $count = 1;
                }
            }
            pg_query($conn, "COMMIT");
            if (isset($msg)) {
                $_SESSION['message'] = "Data Imported Successfully";
                header('location: import_tr.php');
                exit(0);
            }
        } catch (Exception $e) {
            pg_query($conn, "ROLLBACK");
            $_SESSION['message'] = "Error: " . $e->getMessage();
        }
    } else {
        if (isset($msg)) {
            $_SESSION['message'] = "File extention invalid";
            header('location: import_tr.php');
            exit(0);
        }
    }
}
