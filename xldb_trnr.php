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

                    $trainer_id = intval($row['0']);
                    $first_name = pg_escape_string($row['1']);
                    $last_name = pg_escape_string($row['2']);
                    $mobile = $row['3'];
                    $email = pg_escape_string($row['4']);
                    $username = pg_escape_string($row['5']);
                    $password = pg_escape_string($row['6']);

                    $status = "true";

                    if (empty($trainer_id) || empty($first_name) || empty($last_name) || empty($mobile) || empty($email) || empty($username) || empty($password)) {
                        pg_query($conn, "ROLLBACK");
                        $_SESSION['message'] = "Import failed: empty values";
                        header('location: import_trnr.php');
                        exit(0);
                    }



                    $check_id = "SELECT * FROM trainer_records WHERE trainer_id = $trainer_id";
                    $res_q = pg_query($conn, $check_id);
                    if ($res_q) {
                        $num_rows = pg_num_rows($res_q);

                        if ($num_rows > 0) {
                            pg_query($conn, "ROLLBACK");
                            $_SESSION['message'] = "Import failed: existing data";
                            header('location: import_dpt.php');
                            exit(0);
                        } else {

                            $insert_query_trainer = "INSERT INTO trainer_records (trainer_id,first_name, last_name, mobile, email)
                    VALUES ($1, $2, $3, $4, $5) RETURNING trainer_id";
                            $result_query1 = pg_query_params($conn, $insert_query_trainer, array($trainer_id, $first_name, $last_name, $mobile, $email));

                            $row_trainer = pg_fetch_assoc($result_query1);
                            $trainer_id = $row_trainer['trainer_id'];

                            $insert_query_credentials = "INSERT INTO login_credentials_trainers (trainer_id, username, password)
                    VALUES ($1, $2, $3)";
                            $result_query2 = pg_query_params($conn, $insert_query_credentials, array($trainer_id, $username, $password));



                            if (!$result_query1 || !$result_query2) {
                                throw new Exception('Database insertion failed: ' . pg_last_error($conn));
                            }
                            $msg = true;
                        }
                    }
                } else {
                    $count = 1;
                }
            }
            pg_query($conn, "COMMIT");
            if (isset($msg)) {
                $_SESSION['message'] = "Data Imported Successfully";
                header('location: import_trnr.php');
                exit(0);
            }
        } catch (Exception $e) {
            pg_query($conn, "ROLLBACK");
            $_SESSION['message'] = "Error: " . $e->getMessage();
        }
    } else {
        if (isset($msg)) {
            $_SESSION['message'] = "File extention invalid";
            header('location: import_trnr.php');
            exit(0);
        }
    }
}
