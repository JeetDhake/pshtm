<?php
include('connect.php');
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: admin_login.php");
}


if (isset($_POST['submit'])) {
    $trainer_id = (int)$_POST['trainer_id'];
    $first_name = pg_escape_string($conn, $_POST['first_name']);
    $last_name = pg_escape_string($conn, $_POST['last_name']);
    $mobile = pg_escape_string($conn, $_POST['mobile']);
    $email = pg_escape_string($conn, $_POST['email']);
    $role_name = pg_escape_string($conn, $_POST['role_name']);
    $username = pg_escape_string($conn, $_POST['username']);
    $password = pg_escape_string($conn, $_POST['password']);


    $insert_query_credentials = "";
    switch ($role_name) {
        case 'admin':
            $insert_query_admin = "INSERT INTO admin_records (admin_id,first_name, last_name, mobile, email)
                                        VALUES ($1, $2, $3, $4, $5) RETURNING admin_id";
            $result_query1 = pg_query_params($conn, $insert_query_admin, array($trainer_id, $first_name, $last_name, $mobile, $email));

            $row_admin = pg_fetch_assoc($result_query1);
            $admin_id = $row_admin['admin_id'];

            $insert_query_credentials = "INSERT INTO login_credentials_admin (admin_id, username, password)
                                        VALUES ($1, $2, $3)";
            $result_query2 = pg_query_params($conn, $insert_query_credentials, array($trainer_id, $username, $password));
            break;

        case 'trainer':
    

            
    $sign_img = $_FILES['sign']['name'];
    $tmp_image = $_FILES['sign']['tmp_name'];

    $fileextention = explode('.', $sign_img);
    $fileactext = strtolower(end($fileextention));
    $filenewname = uniqid('', true) . "." . $fileactext;

    move_uploaded_file($tmp_image, "db_img/$filenewname");

            $insert_query_trainer = "INSERT INTO trainer_records (trainer_id,first_name, last_name, mobile, email, sign)
                                        VALUES ($1, $2, $3, $4, $5, $6) RETURNING trainer_id";
            $result_query1 = pg_query_params($conn, $insert_query_trainer, array($trainer_id, $first_name, $last_name, $mobile, $email, $filenewname));

            $row_trainer = pg_fetch_assoc($result_query1);
            $trainer_id = $row_trainer['trainer_id'];

            $insert_query_credentials = "INSERT INTO login_credentials_trainers (trainer_id, username, password)
                                        VALUES ($1, $2, $3)";
            $result_query2 = pg_query_params($conn, $insert_query_credentials, array($trainer_id, $username, $password));
            break;

        default:
            echo "Invalid role selected.";
            exit;
    }

    if (!$result_query2) {
        echo '<script>alert("error(admin/trainer)!");</script>';
    }

    if (!$result_query1) {
        echo '<script>alert("error(credentials)!");</script>';
    }

    if ($result_query1 && $result_query2) {
        echo '<script>alert("User registered successfully!");</script>';
    } else {
        echo '<script>alert("User registering error!");</script>';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/manage_dept.css">
    <link rel="stylesheet" href="style/sidebar.css">
    <title>Add members</title>
</head>

<body>
    <?php require_once("navbar.html") ?>


    <div class="container">

        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    Add members
                </header>
                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="pdetail">
                        <div class="fld">
                            <label for="">Member Id</label>
                            <input type="number" name="trainer_id" id="training_program_id" placeholder="Enter Member id" required>
                        </div>
                        <div class="f">
                            <div class="fld">
                                <label for="">First Name</label>
                                <input type="text" name="first_name" id="training_name" placeholder="Enter First Name" required>
                            </div>

                            <div class="fld">
                                <label for="">Last Name</label>
                                <input type="text" name="last_name" id="training_name" placeholder="Enter Last Name" required>
                            </div>
                        </div>
                        <div class="fld">
                            <label for="">Contact no.</label>
                            <input type="text" name="mobile" id="training_name" placeholder="Enter Contact Details" required>
                        </div>

                        <div class="fld">
                            <label for="">Email</label>
                            <input type="email" name="email" id="training_name" placeholder="Enter Your Email" required>
                        </div>
                        <div class="f">
                            <div class="fld">
                                <label for="">Username</label>
                                <input type="text" name="username" id="training_name" placeholder="Create Username" required>
                            </div>

                            <div class="fld">
                                <label for="">Password</label>
                                <input type="password" name="password" id="training_name" placeholder="Create Password" required>
                            </div>

                        </div>




                        <div class="fld">
                            <label for="">Role</label>
                            <select name="role_name" required id="roleSelect">
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="trainer">Trainer</option>
                            </select>
                        </div>

                        <div class="fld" id="sign" style="display:none;">
                            <label for="sign">Signature</label>
                            <input type="file" name="sign">
                        </div>

                    </div>
                    <div class="fld btn">
                        <input type="submit" value="Add Member" name="submit" id="submit">
                    </div>
        </div>
        </form>

        </section>
    </div>

    </div>
    <script>
const roleSelect = document.getElementById('roleSelect');
    const signField = document.getElementById('sign');

    roleSelect.addEventListener('change', function() {
        if (roleSelect.value === 'trainer') {
            signField.style.display = 'block'; 
        } else {
            signField.style.display = 'none';  
        }
    });
    </script>

</body>

</html>