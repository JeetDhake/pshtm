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

                    $department_id = $row['0'];
                    $department_name = pg_escape_string($row['1']);


                    if (empty($department_id) || empty($department_name)) {

                        pg_query($conn, "ROLLBACK");
                        $_SESSION['message'] = "Import failed: empty values";
                        header('location: import_dpt.php');
                        exit(0);
                    }
                    $check_id = "SELECT * FROM department WHERE department_id = $department_id";
                    $res_q = pg_query($conn, $check_id);
                    if ($res_q) {
                        $num_rows = pg_num_rows($res_q);

                        if ($num_rows > 0) {
                            pg_query($conn, "ROLLBACK");
                            $_SESSION['message'] = "Import failed: existing data";
                            header('location: import_dpt.php');
                            exit(0);
                        } else {

                            $insert_dept = "INSERT INTO department (department_id,department_name) VALUES ($department_id, '$department_name')";

                            $result = pg_query($conn, $insert_dept);

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
                header('location: import_dpt.php');
                exit(0);
            }
        } catch (Exception $e) {
            pg_query($conn, "ROLLBACK");
            $_SESSION['message'] = "Error: " . $e->getMessage();
        }
    } else {
        if (isset($msg)) {
            $_SESSION['message'] = "File extention invalid";
            header('location: import_dpt.php');
            exit(0);
        }
    }
}
