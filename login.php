<?php
    session_start();
    include_once "connect.php";

    $username = pg_escape_string($conn, $_POST['admin_username']);
    $password = pg_escape_string($conn, $_POST['admin_password']);

    if(!empty($username) && !empty($password)){

        $sql = pg_query($conn, "SELECT * FROM login_credentials_admin WHERE username = '{$username}' AND password = '{$password}'");
        if(pg_num_rows($sql)>0){
            $row = pg_fetch_assoc($sql);

            $status = TRUE;
            $sql2 = pg_query($conn, "UPDATE login_credentials_admin SET status = '{$status}' WHERE admin_id = {$row['admin_id']}");

            if($sql2){
                $_SESSION['admin_id'] = $row['admin_id'];
            
                echo "success";
            }
        }
        else{
            echo "invalid input";
        }
    }
    else{
        echo "all fields required";
    }
?>