<?php

include('connect.php');
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: admin_login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/employee_all.css">
    <link rel="stylesheet" href="style/navbar.css">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <title>employee_all</title>
</head>

<body>




<nav class="navbar">
        <div class="lft">
            <i class="fa-solid fa-bars fa-lg" style="color: #0009;"></i>

            <i class="fa-regular fa-hospital fa-lg"></i>
            <h1>PSH</h1>
            <h1 class="hh">TM</h1>
        </div>
        <div class="mid">
            <div class="search">
                <a href="dashboard.php">Dashboard</a>
            </div>
            <div class="search">
                <a href="employee_reg.php">Employees</a>
            </div>
            <div class="search">
                <a href="create_training.php">Trainings</a>
            </div>
            <div class="search">
                <a href="filterview.php">Analytics</a>
            </div>


            <div class="searchbox">
                <input type="text" placeholder="search">
                <i class="fa-solid fa-magnifying-glass" style="color: #0009;"></i>
            </div>


            
        </div>
        <div class="rgt">

            <a href="logout.php">
                <i class="fa-solid fa-right-from-bracket fa-lg"></i>
            </a>

            <a href="">
                <img src="img/user1.png" alt="user" class="user">
            </a>

            
    
        </div>
    </nav>


<div class="all">

<?php
    $select_query = "SELECT * FROM employee_records ";
    $result_query = pg_query($conn, $select_query);

    while ($row = pg_fetch_assoc($result_query)) {
        $emp_id = $row['emp_id'];
        $emp_first_name = $row['emp_first_name'];
        $emp_last_name = $row['emp_last_name'];

        $emp_department_id = $row['department_id'];
        $emp_job_post_id = $row['job_post_id'];

        $emp_email = $row['emp_email'];
        $emp_phone = $row['emp_mobile'];
        // $emp_image = $row['emp_image'];


        $select_query1 = "SELECT department_name FROM department WHERE department_id=$emp_department_id";
        $result_query1 = pg_query($conn, $select_query1);
    
        while ($row1 = pg_fetch_assoc($result_query1)) {
            $emp_department = $row1['department_name'];
        }


        $select_query2 = "SELECT job_post_name FROM job_post WHERE job_post_id=$emp_job_post_id";
        $result_query2 = pg_query($conn, $select_query2);
    
        while ($row2 = pg_fetch_assoc($result_query2)) {
            $emp_job_post = $row2['job_post_name'];
        }


        echo '
            <a href="profile.php?emp_id='.$emp_id.'">
                <div class="card-container">
                    <img class="round" src="img/user1.png" alt="user" />
                    <h3>' . $emp_first_name . ' ' . $emp_last_name . '</h3>

                    <p>' . $emp_email . ' ' . $emp_phone . '</p>
                    <h6>Department: ' . $emp_department . '</h6>
                    <h6>Job post: ' . $emp_job_post . '</h6>
                    
                    <div class="buttons">
                        <a href="edit.php?emp_id=' . $emp_id . '">
                            <button class="primary">
                                Edit Details
                            </button>
                        </a>
                        <a href="deactivate.php?emp_id='.$emp_id.'">
                            <button class="primary ghost">
                                Deactivate
                            </button>
                        </a>
                    </div>
                    
                </div>
            </a>
        ';
    }
?>




</div>
<script src="navsearch.js"></script>
</body>

</html>