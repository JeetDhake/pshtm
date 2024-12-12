<?php
include('connect.php');
session_start();
if (!isset($_SESSION['emp_id'])) {
    header("location: user_login.php");
}
$emp_id = $_SESSION['emp_id'];

$sql = "SELECT * FROM employee_records WHERE emp_id = $emp_id";
$res = pg_query($conn, $sql);
while ($row = pg_fetch_assoc($res)) {
    $e_deptid = $row['department_id'];
    $e_jpid = $row['job_post_id'];
}
$sql5 = "SELECT * FROM department WHERE department_id = $e_deptid";
$res5 = pg_query($conn, $sql5);
while ($row5 = pg_fetch_assoc($res5)) {
    $dept = $row5['department_name'];
}

$sql11 = "SELECT * FROM job_post WHERE job_post_id = $e_jpid";
$res11 = pg_query($conn, $sql11);
while ($row11 = pg_fetch_assoc($res11)) {

    $jp = $row11['job_post_name'];
}
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/home.css">

    <title>pshtm</title>
</head>

<body>
    <?php require_once("user_navbar.php") ?>
    <div class="container">
        <div class="wrapper">
            <div class="train xx">
                <h3>Current Training</h3>
            </div>
            <?php

            $sql1 = "SELECT DISTINCT c.*, c.date 
FROM training_relations r
INNER JOIN create_training_programs c ON r.training_program_id = c.training_program_id
WHERE r.employee_id = $emp_id
ORDER BY c.date ASC";

            $res1 = pg_query($conn, $sql1);

            if ($res1) {
                while ($row1 = pg_fetch_assoc($res1)) {
                    $tr_id = $row1['training_program_id'];

                    $training_date = $row1['date'];

                    $sqly = "SELECT COUNT(*) AS total 
        FROM employee_reports 
        WHERE emp_id = $emp_id 
          AND training_program_id = $tr_id 
          AND employee_performance IS NOT NULL";
                    $resy = pg_query($conn, $sqly);

                    if ($resy) {
                        $rowy = pg_fetch_assoc($resy);
                        if ($rowy['total'] == 0) {
                            if ($training_date > $today) {

            ?>


                                <div class="train" id="<?php echo $tr_id; ?>">
                                    <div class="cont">
                                        <div class="lf">
                                            <h2><?php echo $row1['name']; ?></h2>

                                            <p>Description: </p>
                                            <p class="hx"><?php echo $row1['training_desc']; ?></p>
                                            <br>
                                            <p>date: <?php echo $training_date; ?></p>
                                        </div>
                                        <?php

                                        if ($training_date == $today) {

                                        ?>
                                            <div class="rg">
                                                <?php
                                                if ($row1['pre_status'] == "pending") {
                                                ?>
                                                    <button class="btnx">Pre Exam (available soon) </button>
                                                <?php
                                                } elseif ($row2['pre_status'] == "started") {
                                                ?>
                                                    <button onclick="action('pre', <?php echo $tr_id; ?>)" class="btnx">Enter Pre Exam</button>
                                                <?php
                                                } elseif ($row1['pre_status'] == "finished") {
                                                ?>
                                                    <button class="btnx">Pre Exam Ended</button>
                                                <?php
                                                }

                                                if ($row1['post_status'] == "pending") {
                                                ?>
                                                    <button class="btnx">Post Exam (available soon)</button>
                                                <?php
                                                } elseif ($row1['post_status'] == "started") {
                                                ?>
                                                    <button onclick="action('post', <?php echo $tr_id; ?>)" class="btnx">Enter Post Exam</button>
                                                <?php
                                                } elseif ($row2['post_status'] == "finished") {
                                                ?>
                                                    <button class="btnx">Post Exam Ended</button>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        }
                                        if ($training_date > $today) {
                                        ?>
                                            <div class="rg">
                                                Scheduled on <?php echo $training_date; ?>
                                                <br>
                                                yet to start
                                            </div>
                                        <?php }
                                        if ($training_date < $today) {
                                        ?>
                                            <div class="rg">
                                                Was Scheduled on <?php echo $training_date; ?>
                                                <br>
                                                Date gone (not given)
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

            <?php
                            }
                        }
                    }
                }
            } else {
                echo "No training programs found.";
            }

            ?>
        </div>

        <div class="wrapper">
            <div class="train xx">
                <h3>Training History</h3>
            </div>
            <?php
            // $sql1 = "SELECT DISTINCT training_program_id FROM training_relations WHERE department_id = $e_deptid OR job_post_id = $e_jpid";
            $sql1 = "SELECT DISTINCT training_program_id FROM training_relations WHERE employee_id = $emp_id";
            $res1 = pg_query($conn, $sql1);
            if ($res1) {
                while ($row1 = pg_fetch_assoc($res1)) {
                    $tr_id = $row1['training_program_id'];


                    $sqlx = "SELECT * FROM employee_reports WHERE employee_performance IS NOT NULL AND emp_id = $emp_id AND training_program_id = $tr_id";
                    $resx = pg_query($conn, $sqlx);
                    if (pg_num_rows($resx) > 0) {
                        while ($rowx = pg_fetch_assoc($resx)) {
                            $trx_id = $rowx['training_program_id'];

                            $sql2 = "SELECT * FROM create_training_programs WHERE training_program_id = $trx_id";
                            $res2 = pg_query($conn, $sql2);
                            if ($res2) {
                                while ($row2 = pg_fetch_assoc($res2)) {

            ?>


                                    <div class="train" id="<?php echo $tr_id; ?>">
                                        <div class="cont">
                                            <div class="lf">
                                                <h2><?php echo $row2['name']; ?></h2>

                                                <p>Description: </p>
                                                <p class="hx"><?php echo $row2['training_desc']; ?></p>
                                            </div>
                                            <div class="rg">
                                                <button onclick="action_re(<?php echo $tr_id; ?>)" class="btnx">Report</button>
                                            </div>
                                        </div>
                                    </div>


            <?php
                                }
                            }
                        }
                    }
                }

                if (pg_num_rows($res1) == 0) {
                    echo "<div class='train'><p class='hx'>No Training History</p></div>";
                }
            }
            ?>
        </div>
    </div>
    <script>
        function action(type, tr_id) {
            const emp_id = <?php echo $emp_id; ?>;
            const url = `exam.php?prepost=${encodeURIComponent(type)}&tr_id=${encodeURIComponent(tr_id)}`;

            window.location.href = url;
        }

        function action_re(tr_id) {
            const emp_id = <?php echo $emp_id; ?>;
            const url = `user_profile.php#${encodeURIComponent(tr_id)}`;

            window.location.href = url;

        }
    </script>
</body>


</html>