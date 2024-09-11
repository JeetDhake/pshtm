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
                    $emp_first_name = pg_escape_string($row['0']);
                    $emp_last_name = pg_escape_string($row['1']);
                    $emp_mobile = $row['2'];
                    $emp_email = pg_escape_string($row['3']);

                    $job_post_id = $row['4'];
                    $department_id = $row['5'];
                    $emp_uid = intval($row['6']);
                    $password = pg_escape_string($row['7']);

                    $status = "true";

                    if (empty($emp_first_name) || empty($emp_last_name) || empty($emp_mobile) || empty($emp_email) || empty($job_post_id) || empty($department_id) || empty($emp_uid) || empty($password)) {

                        pg_query($conn, "ROLLBACK");
                        $_SESSION['message'] = "Import failed: empty values";
                        header('location: import_emp.php');
                        exit(0);
                    }


                    $check_id = "SELECT * FROM employee_records WHERE emp_uid = $emp_uid";
                    $res_q = pg_query($conn, $check_id);
                    if ($res_q) {
                        $num_rows = pg_num_rows($res_q);

                        if ($num_rows > 0) {
                            pg_query($conn, "ROLLBACK");
                            $_SESSION['message'] = "Import failed: duplicate data";
                            header('location: import_emp.php');
                            exit(0);
                        } else {

                            $insert_user = "INSERT INTO employee_records (emp_first_name,emp_last_name,department_id,job_post_id,emp_email,emp_mobile,emp_status,emp_uid,password) 
                            VALUES ('$emp_first_name','$emp_last_name','$department_id','$job_post_id','$emp_email','$emp_mobile','$status','$emp_uid','$password')";
                            $result = pg_query($conn, $insert_user);

                            if (!$result) {
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
                header('location: import_emp.php');
                exit(0);
            }
        } catch (Exception $e) {
            pg_query($conn, "ROLLBACK");
            $_SESSION['message'] = "Error: " . $e->getMessage();
        }
    } else {
        if (isset($msg)) {
            $_SESSION['message'] = "File extention invalid";
            header('location: import_emp.php');
            exit(0);
        }
    }
}
