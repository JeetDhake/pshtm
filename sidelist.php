<?php
include('connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/sidelist.css">
    <title>Document</title>
</head>

<body>
    <div class="userlist">
        <div class="scrollbox">
            <div class="scrollboxdata">
                <?php
                $select_query = "SELECT * FROM employee_records ";
                $result_query = pg_query($conn, $select_query);
            
                while ($row = pg_fetch_assoc($result_query)) {
                    $emp_id = $row['emp_id'];
                    $emp_first_name = $row['emp_first_name'];
                    $emp_middle_name = $row['emp_middle_name'];
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
                    <div class="scard">
                        <div class="content">
                        <a href="profile.php?emp_id='.$emp_id.'">
                            <img src="img/user1.png" alt="">
                        </a>
                            <div class="detail">
                                <span>' . $emp_first_name . ' ' . $emp_middle_name . ' ' . $emp_last_name . '</span>
                                <p>Dept: ' . $emp_department . ' job: ' . $emp_job_post . '</p>
                                <div class="bns">
                                    <a href="edit.php?emp_id=' . $emp_id . '">Edit</a>
                                    <a href="deactivate.php?emp_id='.$emp_id.'">Deactivate</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
        <div class="show1">
            <div class="show">
                <a href="employee_all.php">
                  <button class="show-all">show all</button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
