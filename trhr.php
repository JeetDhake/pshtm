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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/analytics.css">
    <link rel="stylesheet" href="style/sidebar.css">


    <title>Analytics</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebana.html") ?>
    <div class="container">
        <div class="xo">


            <div class="one">
                <div class="block">
                    <form action="" method="GET">
                        <div class="card shadow mt-3">
                            <div class="card-header">
                                <h5>Filter</h5>

                                <button type="submit" class="btn">Search</button>

                            </div>
                            <div class="card-body dplist">
                                <h6>Dept List</h6>
                                <hr>
                                <?php


                                $dept_query = "SELECT * FROM department";
                                $dept_query_run  = pg_query($conn, $dept_query);

                                if (pg_num_rows($dept_query_run) > 0) {
                                    while ($deptlist = pg_fetch_assoc($dept_query_run)) { {
                                            $checked = [];
                                            if (isset($_GET['departments'])) {
                                                $checked = $_GET['departments'];
                                            }
                                ?>
                                            <div class="huh">
                                                <input type="checkbox" name="departments[]" value="<?= $deptlist['department_id']; ?>" <?php if (in_array($deptlist['department_id'], $checked)) {
                                                                                                                                            echo "checked";
                                                                                                                                        } ?> />
                                                <?= $deptlist['department_name']; ?>
                                            </div>
                                <?php
                                        }
                                    }
                                } else {
                                    echo "No dept Found";
                                }

                                ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="block">
                    <form action="" method="GET">
                        <div class="card shadow mt-3">
                            <div class="card-header">
                                <h5>Filter</h5>

                                <button type="submit" class="btn">Search</button>

                            </div>
                            <div class="card-body dplist">
                                <h6>Job List</h6>
                                <hr>
                                <?php


                                $job_query = "SELECT * FROM job_post";
                                $job_query_run  = pg_query($conn, $job_query);

                                if (pg_num_rows($job_query_run) > 0) {
                                    while ($joblist = pg_fetch_assoc($job_query_run)) { {
                                            $checked = [];
                                            if (isset($_GET['jobs'])) {
                                                $checked = $_GET['jobs'];
                                            }
                                ?>
                                            <div class="huh">
                                                <input type="checkbox" name="jobs[]" value="<?= $joblist['job_post_id']; ?>" <?php if (in_array($joblist['job_post_id'], $checked)) {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> />
                                                <?= $joblist['job_post_name']; ?>
                                            </div>
                                <?php
                                        }
                                    }
                                } else {
                                    echo "No job Found";
                                }

                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>




            <div class="block">

                <div class="">
                    <div class="searchbox">
                        <input type="text" placeholder="search">
                        <i class="fa-solid fa-magnifying-glass" style="color: #0009;"></i>
                    </div>
                    <div class="">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ly">Training Program Id</th>
                                    <th class="ly">Training Program Name</th>

                                </tr>
                            </thead>
                        </table>
                        <div class="scr">
                            <table class="all">
                                <?php
                                if (isset($_GET['departments'])) {
                                    $branchecked = [];
                                    $branchecked = $_GET['departments'];
                                    foreach ($branchecked as $rowbrand) {
                                        $gettr = "SELECT DISTINCT * FROM employee_records WHERE department_id = $rowbrand";
                                        $gettr_run =  pg_query($conn, $gettr);
                                        while ($row = pg_fetch_assoc($gettr_run)) {

                                            $emp_uid_ar = $row["emp_uid"];

                                            $emp_first_name = $row['emp_first_name'];
                                            $emp_middle_name = $row['emp_middle_name'];
                                            $emp_last_name = $row['emp_last_name'];

                                            echo "
                                        <tbody>
                                            <tr>

                                            <td class='ly'>
                                                <a href='emp_analytics.php?u_id=$emp_uid_ar'>
                                                    <p>$emp_uid_ar</p>
                                                </a>
                                            </td>

                                                <td class='ly'>
                                                    <a href='emp_analytics.php?u_id=$emp_uid_ar'>
                                                        <p>$emp_first_name $emp_middle_name $emp_last_name</p>
                                                    </a>
                                                </td>

                                            </tr>
                        
                                        </tbody>
                                    
                        
                                ";
                                        }
                                    }
                                }

                                if (isset($_GET['jobs'])) {
                                    $branchecked1 = [];
                                    $branchecked1 = $_GET['jobs'];
                                    foreach ($branchecked1 as $rowbrand1) {
                                        $gettr = "SELECT DISTINCT * FROM employee_records WHERE job_post_id = $rowbrand1";
                                        $gettr_run =  pg_query($conn, $gettr);
                                        while ($row = pg_fetch_assoc($gettr_run)) {

                                            $emp_uid_ar = $row["emp_uid"];

                                            $emp_first_name = $row['emp_first_name'];
                                            $emp_middle_name = $row['emp_middle_name'];
                                            $emp_last_name = $row['emp_last_name'];

                                            echo "
                                            <tbody>
                                                <tr>

                                                <td class='ly'>
                                                    <a href='emp_analytics.php?u_id=$emp_uid_ar'>
                                                        <p>$emp_uid_ar</p>
                                                    </a>
                                                </td>

                                                    <td class='ly'>
                                                        <a href='emp_analytics.php?u_id=$emp_uid_ar'>
                                                            <p>$emp_first_name $emp_middle_name $emp_last_name</p>
                                                        </a>
                                                    </td>

                                                </tr>
                            
                                            </tbody>
                                        
                            
                                    ";
                                        }
                                    }
                                }

                                if (!isset($_GET['jobs']) && !isset($_GET['departments'])) {
                                    $products = "SELECT * FROM employee_records";
                                    $products_run = pg_query($conn, $products);

                                    while ($row = pg_fetch_assoc($products_run)) {
                                        $emp_uid_ar = $row["emp_uid"];

                                        $emp_first_name = $row['emp_first_name'];
                                        $emp_middle_name = $row['emp_middle_name'];
                                        $emp_last_name = $row['emp_last_name'];

                                        echo "
                                            <tbody>
                                                <tr>

                                                <td class='ly'>
                                                    <a href='emp_analytics.php?u_id=$emp_uid_ar'>
                                                        <p>$emp_uid_ar</p>
                                                    </a>
                                                </td>

                                                    <td class='ly'>
                                                        <a href='emp_analytics.php?u_id=$emp_uid_ar'>
                                                            <p>$emp_first_name $emp_middle_name $emp_last_name</p>
                                                        </a>
                                                    </td>

                                                </tr>
                            
                                            </tbody>

        ";
                                    }
                                }


                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="manage.js"></script>
    <script src="usersearch.js"></script>
</body>

</html>