<?php 
    session_start();
    if(isset($_SESSION['admin_id'])){
        header("location: dashboard.php");
    }
    if(isset($_SESSION['trainer_id'])){
        header("location: dashboard2.php");
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
    <title>Admin</title>
</head>
<body>

<div class="wrapper">
    <section class="login" id="login">
        <header>
            Access: <button type="button" class="togglebtn" onclick="admin()">Admin</button>
            <button type="button" class="togglebtn" onclick="trainer()">Trainer</button>
        </header>
        <form action="" enctype="" id="admin">
            <div class="error">
                
            </div>
            <div class="user-detail">
                
                <div class="field">
                    <label for="">Admin Username</label>
                    <input type="text" name="admin_username" id="username" placeholder="Enter your Username">
                </div>
                <div class="field">
                    <label for="">Password</label>
                    <input type="password" name="admin_password" id="password" placeholder="Enter your Password">
                    <i class="fas fa-eye"></i>
                </div>
                
                <div class="field btn">
                    <input type="submit" value="Login as Admin">
                </div>
            </div>
        </form>


        
    </section>



    <section class="login loginx" id="loginx">
        <header>
            Access: <button type="button" class="togglebtn" onclick="admin()">Admin</button>
            <button type="button" class="togglebtn" onclick="trainer()">Trainer</button>
        </header>
        

        <form action="" enctype="" id="trainer">
            <div class="error">
                
            </div>
            <div class="user-detail">
                
                <div class="field">
                    <label for="">Trainer Username</label>
                    <input type="text" name="trainer_username" id="username" placeholder="Enter your Username">
                </div>
                <div class="field">
                    <label for="">Password</label>
                    <input type="password" name="trainer_password" id="password" placeholder="Enter your Password">
                    <i class="fas fa-eye"></i>
                </div>
                

                <div class="field btn">
                    <input type="submit" value="Login as Trainer">
                </div>
            </div>
        </form>
    </section>
</div>

<script src="admin_login.js"></script>  
<script>
    const adminx = document.getElementById("login");
const trainerx = document.getElementById("loginx");

function admin(){
    adminx.style.display = "block";
    trainerx.style.display = "none";
}
function trainer(){
    trainerx.style.display = "block";
    adminx.style.display = "none";
}
</script>
</body>

</html>