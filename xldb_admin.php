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

                    $admin_id = intval($row['0']);
                    $first_name = pg_escape_string($row['1']);
                    $last_name = pg_escape_string($row['2']);
                    $mobile = $row['3'];
                    $email = pg_escape_string($row['4']);
                    $username = pg_escape_string($row['5']);
                    $password = pg_escape_string($row['6']);

                    $status = "true";

                    if (empty($admin_id) || empty($first_name) || empty($last_name) || empty($mobile) || empty($email) || empty($username) || empty($password)) {
                        pg_query($conn, "ROLLBACK");
                        $_SESSION['message'] = "Import failed: empty values";
                        header('location: import_admin.php');
                        exit(0);
                    }


                    $insert_query_admin = "INSERT INTO admin_records (admin_id,first_name, last_name, mobile, email)
                                        VALUES ($1, $2, $3, $4, $5) RETURNING admin_id";
                    $result_query1 = pg_query_params($conn, $insert_query_admin, array($admin_id, $first_name, $last_name, $mobile, $email));

                    $row_admin = pg_fetch_assoc($result_query1);
                    $admin_id = $row_admin['admin_id'];

                    $insert_query_credentials = "INSERT INTO login_credentials_admin (admin_id, username, password)
                                        VALUES ($1, $2, $3)";
                    $result_query2 = pg_query_params($conn, $insert_query_credentials, array($admin_id, $username, $password));



                    if (!$result_query1 || !$result_query2) {
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
                header('location: import_admin.php');
                exit(0);
            }
        } catch (Exception $e) {
            pg_query($conn, "ROLLBACK");
            $_SESSION['message'] = "Error: " . $e->getMessage();
        }
    } else {
        if (isset($msg)) {
            $_SESSION['message'] = "File extention invalid";
            header('location: import_admin.php');
            exit(0);
        }
    }
}
