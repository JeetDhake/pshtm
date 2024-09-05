<?php
    session_start();
    include_once "connect.php";

    $username = pg_escape_string($conn, $_POST['trainer_username']);
    $password = pg_escape_string($conn, $_POST['trainer_password']);

    if(!empty($username) && !empty($password)){

        $sql = pg_query($conn, "SELECT * FROM login_credentials_trainers WHERE username = '{$username}' AND password = '{$password}'");
        if(pg_num_rows($sql)>0){
            $row = pg_fetch_assoc($sql);

            $status = TRUE;
            $sql2 = pg_query($conn, "UPDATE login_credentials_trainers SET status = '{$status}' WHERE trainer_id = {$row['trainer_id']}");

            if($sql2){
                $_SESSION['trainer_id'] = $row['trainer_id'];
            
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