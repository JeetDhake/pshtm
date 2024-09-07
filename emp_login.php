<?php
session_start();
include_once "connect.php";

$identity = pg_escape_string($conn, $_POST['identity']);
$password = pg_escape_string($conn, $_POST['password']);

if (!empty($identity) && !empty($password)) {

    $sql = pg_query($conn, "SELECT * FROM employee_records WHERE password = '{$password}' AND emp_email = '{$identity}'");
    if (pg_num_rows($sql) > 0) {
        $row = pg_fetch_assoc($sql);

        if ($sql) {
            $_SESSION['emp_id'] = $row['emp_id'];

            echo "success";
        }
    } else {
        if (is_int($identity)) {
            $sql2 = pg_query($conn, "SELECT * FROM employee_records WHERE password = '{$password}' AND emp_uid = {$identity}");
            if (pg_num_rows($sql2) > 0) {
                $row2 = pg_fetch_assoc($sql2);

                if ($sql2) {
                    $_SESSION['emp_id'] = $row2['emp_id'];

                    echo "success";
                }
            } else {
                echo "invalid Input";
            }
        }
        else{
            echo "invalid Input";
        }
    }
} else {
    echo "all fields required";
}
