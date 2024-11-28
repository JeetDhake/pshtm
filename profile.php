<?php
include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}

$t = "t";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style/profile.css">
    <link rel="stylesheet" href="fonts/remixicon.css">
</head>

<body>
    <span class="main_bg"></span>
    <div class="container">
        <header>
            <?php


            if (isset($_GET['emp_id'])) {

                $emp_id = $_GET['emp_id'];
                $sql = pg_query($conn, "SELECT * FROM employee_records WHERE emp_id = $emp_id");
                if (pg_num_rows($sql) > 0) {
                    $row = pg_fetch_assoc($sql);
                }
            }
            ?>
            <div class="brandLogo">
                <figure>
                    <p>Employee</p>
                </figure>
                <span>User Settings</span>
                <a href="employee_all.php">Back</a>

            </div>
        </header>



        <section class="userProfile card">
            <div class="profile">
                <figure><img src="img/user1.png" alt="profile" width="250px" height="250px">
                </figure>
            </div>
        </section>


        <section class="work_skills card">


            <div class="work">
                <h1 class="heading">Contact Details</h1>
                <div class="primary">
                    <h1>Email Address</h1>
                    <span><?php $x = $row['emp_status'];

                            if ($x == $t) {
                                echo "Active";
                            } else {
                                echo "deactive";
                            }
                            ?></span>
                    <p>
                        <?php echo $row['emp_email']; ?>
                    </p>
                </div>

                <div class="secondary">
                    <h1>Phone No.</h1>
                    <span><?php $x = $row['emp_status'];
                            if ($x === $t) {
                                echo "Active";
                            } else {
                                echo "deactive";
                            }
                            ?></span>
                    <p>
                        <?php echo $row['emp_mobile']; ?>
                    </p>
                </div>
            </div>


            <div class="skills">
                <h1 class="heading">Trainings History</h1>
                <ul class="scrollable-list">
                    <?php
                    $sqlx = pg_query($conn, "SELECT DISTINCT * FROM employee_reports WHERE emp_id = $emp_id");
                    while ($rowx = pg_fetch_assoc($sqlx)) {
                        $training_program_id = $rowx['training_program_id'];

                        $sqly = pg_query($conn, "SELECT * FROM create_training_programs WHERE training_program_id = $training_program_id");
                        while ($rowy = pg_fetch_assoc($sqly)) {
                            $tr_name = $rowy['name'];
                            $training_program_id = $rowy['training_program_id'];
                            echo '<li><a href="#' . $training_program_id . '">' . $tr_name . '</a></li>';
                        }
                    }
                    ?>

                </ul>
            </div>
        </section>



        <section class="userDetails card">
            <div class="userName">
                <h1 class='name'>
                    <?php echo $row['emp_first_name'] . " " . $row['emp_middle_name'] . " " . $row['emp_last_name'] ?>
                </h1>
                  
                <div class="map">
                    <i class="ri-map-pin-fill ri"></i>
                    <span></span>
                </div>
                  
                <p><?php $x = $row['emp_status'];
                    if ($x === $t) {
                        echo "Active";
                    } else {
                        echo "deactive";
                    }
                    ?> user</p>
            </div>
            <h1>Employee ID: <?php echo $row['emp_uid']; ?></h1>
            <?php
            $emp_department_id = $row['department_id'];

            $select_query1 = "SELECT department_name FROM department WHERE department_id=$emp_department_id";
            $result_query1 = pg_query($conn, $select_query1);

            while ($row1 = pg_fetch_assoc($result_query1)) {
                $emp_departmentx = $row1['department_name'];
            }

            $emp_job_post_id = $row['job_post_id'];
            $select_query2 = "SELECT job_post_name FROM job_post WHERE job_post_id=$emp_job_post_id";
            $result_query2 = pg_query($conn, $select_query2);

            while ($row2 = pg_fetch_assoc($result_query2)) {
                $emp_job_postx = $row2['job_post_name'];
            }
            ?>
            <div class="rank">
                <div class="one">
                    <h1 class="heading">Department</h1>
                    <span><?php echo $emp_departmentx; ?></span>
                </div>
                <div class="two">
                    <h1 class="heading">Job Post</h1>
                    <span><?php echo $emp_job_postx; ?></span>
                </div>
            </div>

            <div class="btns">
                <ul>

                    <li class="sendMsg active">

                        <a href="edit.php?emp_id=<?php echo $row['emp_id'] ?>">Edit details</a>
                    </li>
                    <li class="sendMsg active">

                        <a href="deactivate.php?emp_id=<?php echo $row['emp_id'] ?>">Deactivate</a>
                    </li>

                </ul>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <section class="timeline_about card">
            <div class="contact_Info" id="space">
                <?php

                $sqlx = pg_query($conn, "SELECT DISTINCT * FROM employee_reports WHERE emp_id = $emp_id");
                while ($rowx = pg_fetch_assoc($sqlx)) {
                    $training_program_id = $rowx['training_program_id'];

                    $sqly = pg_query($conn, "SELECT * FROM create_training_programs WHERE training_program_id = $training_program_id");
                    while ($rowy = pg_fetch_assoc($sqly)) {
                        $tr_name = $rowy['name'];
                        $training_program_id = $rowy['training_program_id'];

                        echo '<div class="oneinfo" id="' . $training_program_id . '">
                <h1>' . $tr_name . '</h1>
                <p>Report and Analytics</p>
                <div class="bnx">
                    <div class="inbx">';

                        $select_queryx = "SELECT * FROM employee_reports WHERE emp_id=$emp_id AND training_program_id=$training_program_id";
                        $result_queryx = pg_query($conn, $select_queryx);

                        $prepost = array();

                        while ($rowx = pg_fetch_assoc($result_queryx)) {

                            $emp_p = $rowx["employee_performance"];

                            $q1 = $rowx["questionnaire1_result"];
                            $q2 = $rowx["questionnaire2_result"];
                            $prepost[] = $q1;
                            $prepost[] = $q2;
                        }
                        $sqryz = "SELECT * FROM training_reports WHERE training_program_id = $training_program_id";
                        $rsqryz = pg_query($conn, $sqryz);
                        while($rowz = pg_fetch_assoc($rsqryz)){
                            // $to = $rowz['end_date'];
                            // $from = $rowz['start_date'];
                            $date = $rowz['date'];
                        }

                        // Generate unique IDs for the canvas elements
                        $canvas_id1 = "mychart_" . $training_program_id . "_1";
                        $canvas_id2 = "mychart_" . $training_program_id . "_2";

                        // Print the first chart
                        echo '<div class="chartbox">
                <canvas id="' . $canvas_id1 . '"></canvas>
              </div>';

                        // JavaScript for the first chart
                        echo '<script>
                var pp1 = ' . json_encode($prepost) . ';
                var preq = "pre_question";
                var data = {
                    labels: preq,
                    datasets: [{
                        label: "Performance based",
                        data: pp1,
                        borderWidth: 1
                    }]
                };
                var confi = {
                    type: "bar",
                    data: data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };
                var mychart1 = new Chart(
                    document.getElementById("' . $canvas_id1 . '"),
                    confi
                );
              </script>

              <h1 class="heading">questionnaire1_result: ' . number_format($q1, 2) . '</h1><br>
              <h1 class="heading">Performance: ' . number_format($emp_p, 2) . '</h1><br>
                ';
              ?>
                        <div class="fx">
                            <form action="pdfxd.php" method="POST">
                                <input type="hidden" name="name" value="<?php echo $row['emp_first_name'] . " " . $row['emp_last_name'] ?>">

                                <button type="submit" class="ah"><i class="fa-regular fa-floppy-disk"></i> comp_certi</button>
                            </form>
                            <form action="pdfyd.php" method="POST">
                                <input type="hidden" name="name" value="<?php echo $row['emp_first_name'] . " " . $row['emp_last_name'] ?>" />
                                <!-- <input type="hidden" name="from" value="<?php //echo htmlspecialchars($from); ?>" />
                                <input type="hidden" name="to" value="<?php //echo htmlspecialchars($to); ?>" /> -->
                                <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>" />
                                <button type="submit" class="ah"><i class="fa-regular fa-floppy-disk"></i> part_certi</button>
                            </form>
                        </div>


                        <?php
                        echo '</div>';
                        ?>

                    <?php
                        echo '
                        <div class="inbx">
                        <div class="chartbox cbx">
                <canvas id="' . $canvas_id2 . '"></canvas>
              </div>';
                    

                        echo '<script>
                var pp2 = [' . json_encode($emp_p) . '];
                var po = ["performance"];
                var data2 = {
                    labels: po,
                    datasets: [{
                        label: "# of Analytics",
                        data: pp2,
                        backgroundColor: [
                            "#88cee6",
                         
                          ],
                          hoverOffset: 4
                    }]
                };
                var confi2 = {
                    type: "doughnut",
                    data: data2,
                    
                };
                var mychart2 = new Chart(
                    document.getElementById("' . $canvas_id2 . '"),
                    confi2
                );
              </script>';

                        
                        echo '<h1 class="heading">questionnaire1_result: ' . number_format($q2, 2) . '</h1><br>
              ';
              
                        
                        echo '<a href="preanswersheet.php?emp_id=' . $emp_id . '&training_program_id=' . $training_program_id . '">
                <h1 class="linkto">Pre Answer Sheet</h1>
              </a>';

                        echo '<a href="postanswersheet.php?emp_id=' . $emp_id . '&training_program_id=' . $training_program_id . '">
                <h1 class="linkto">Post Answer Sheet</h1>
              </a>';

                        echo '</div></div></div>'; 
                    }
                }

                ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


            </div>
            <div id="x">
                <!-- <p>xxxxxxxx</p> -->
            </div>

        </section>
    </div>
    <script>


    </script>

</body>

</html>