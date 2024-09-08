<?php 
    session_start();
    if(isset($_SESSION['emp_id'])){
        header("location: home_page.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/admin_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <title>Login</title>
</head>
<body>

<div class="wrapper">
    <section class="login" id="login">

        <form action="" enctype="" id="user">
            <div class="error">
                
            </div>
            <div class="user-detail">
                
                <div class="field">
                    <label for="">Email | Emp_ID</label>
                    <input type="text" name="identity" id="email" placeholder="Enter Email Or Emp ID ">
                </div>
                <div class="field">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your Password">
                    <i class="fas fa-eye"></i>
                </div>
                
                <div class="field btn">
                    <input type="submit" value="Login">
                </div>

                <div class="field link">
                    <a href="admin_login.php">login as admin</a>
                </div>
            </div>
        </form>
    </section>
</div>

<script src="user_login.js"></script>  

</body>

</html>