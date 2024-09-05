<?php
        include_once "connect.php";
    session_start();
    if(isset($_SESSION['admin_id'])){


        $logout_id = $_SESSION['admin_id'];
        if(isset($logout_id)){

            $sql = pg_query($conn, "UPDATE login_credentials_admin SET status = FALSE WHERE admin_id = '{$logout_id}'");

            if($sql){
                session_unset();
                session_destroy();
                header("location: admin_login.php");
            }
        }
        else{

            header("location: dashboard.php");
        }
    }
    else{
        header("location: admin_login.php");
    }


    if(isset($_SESSION['trainer_id'])){
       

        $logout_id2 = $_SESSION['trainer_id'];
        if(isset($logout_id2)){

            $sql2 = pg_query($conn, "UPDATE login_credentials_trainers SET status = FALSE WHERE trainer_id = '{$logout_id2}'");

            if($sql2){
                session_unset();
                session_destroy();
                header("location: admin_login.php");
            }
        }
        else{

            header("location: dashboard.php");
        }
    }
    else{
        header("location: admin_login.php");
    }

?>